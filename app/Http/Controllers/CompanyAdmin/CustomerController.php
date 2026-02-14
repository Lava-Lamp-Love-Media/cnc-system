<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Address;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::where('company_id', Auth::user()->company_id)
            ->with(['billingAddress', 'logo'])
            ->latest()
            ->paginate(15);

        return view('backend.companyadmin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('backend.companyadmin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_code' => 'required|string|unique:customers,customer_code|max:50',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'customer_type' => 'required|in:individual,company',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_terms_days' => 'required|integer|min:0',
            'tax_id' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,suspended',
            'notes' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Billing Address
            'addresses' => 'required|array|min:1',
            'addresses.*.address_type' => 'required|in:billing,shipping,warehouse,office',
            'addresses.*.address_line_1' => 'required|string|max:255',
            'addresses.*.city' => 'required|string|max:100',
            'addresses.*.country' => 'required|string|max:100',
        ], [
            'customer_code.unique' => 'This customer code is already in use',
        ]);

        DB::beginTransaction();

        try {
            // Create Customer
            $customer = Customer::create([
                'company_id' => Auth::user()->company_id,
                'customer_code' => $request->customer_code,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'customer_type' => $request->customer_type,
                'credit_limit' => $request->credit_limit,
                'payment_terms_days' => $request->payment_terms_days,
                'tax_id' => $request->tax_id,
                'status' => $request->status,
                'notes' => $request->notes,
            ]);

            // Create Billing Address
            if ($request->has('addresses')) {
                foreach ($request->addresses as $addressData) {
                    Address::create([
                        'addressable_type' => Customer::class,
                        'addressable_id' => $customer->id,
                        'address_type' => $addressData['address_type'],
                        'is_default' => isset($addressData['is_default']) ? true : false,
                        'contact_person' => $addressData['contact_person'] ?? null,
                        'phone' => $addressData['phone'] ?? null,
                        'address_line_1' => $addressData['address_line_1'],
                        'address_line_2' => $addressData['address_line_2'] ?? null,
                        'city' => $addressData['city'],
                        'state' => $addressData['state'] ?? null,
                        'zip_code' => $addressData['zip_code'] ?? null,
                        'country' => $addressData['country'],
                    ]);
                }
            }

            // Handle Logo Upload to DigitalOcean Spaces

            if ($request->hasFile('logo')) {
                try {
                    $file = $request->file('logo');

                    // Upload with public visibility
                    $path = Storage::disk('spaces')->putFile('customers/logos', $file, 'public');

                    Media::create([
                        'mediable_type' => Customer::class,
                        'mediable_id' => $customer->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'file_type' => 'image',
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                        'category' => 'logo',
                        'is_primary' => true,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Logo upload failed: ' . $e->getMessage());
                }
            }
            DB::commit();

            return redirect()->route('company.customers.index')
                ->with('toast_success', '✅ Customer created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Customer creation failed: ' . $e->getMessage());

            return back()->withInput()
                ->with('toast_error', '❌ Error creating customer: ' . $e->getMessage());
        }
    }

    public function show(Customer $customer)
    {
        if ($customer->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        $customer->load(['addresses', 'media', 'billingAddress', 'shippingAddresses']);

        return view('backend.companyadmin.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        if ($customer->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        $customer->load(['addresses', 'billingAddress']);

        return view('backend.companyadmin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        if ($customer->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'customer_code' => 'required|string|max:50|unique:customers,customer_code,' . $customer->id,
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'customer_type' => 'required|in:individual,company',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_terms_days' => 'required|integer|min:0',
            'tax_id' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,suspended',
            'notes' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $customer->update($request->except('logo'));

            // Handle Logo Upload
            if ($request->hasFile('logo')) {
                try {
                    // Delete old logo from DO Spaces
                    if ($customer->logo) {
                        Storage::disk('spaces')->delete($customer->logo->file_path);
                        $customer->logo->delete();
                    }

                    // Upload new logo with public visibility
                    $file = $request->file('logo');
                    $path = Storage::disk('spaces')->putFile('customers/logos', $file, 'public');

                    Media::create([
                        'mediable_type' => Customer::class,
                        'mediable_id' => $customer->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'file_type' => 'image',
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                        'category' => 'logo',
                        'is_primary' => true,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Logo update failed: ' . $e->getMessage());
                }
            }

            DB::commit();

            return redirect()->route('company.customers.index')
                ->with('toast_success', '✅ Customer updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Customer update failed: ' . $e->getMessage());

            return back()->withInput()
                ->with('toast_error', '❌ Error updating customer: ' . $e->getMessage());
        }
    }

    public function destroy(Customer $customer)
    {
        if ($customer->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        DB::beginTransaction();

        try {
            // Delete all media files from DO Spaces
            foreach ($customer->media as $media) {
                try {
                    Storage::disk('spaces')->delete($media->file_path);
                } catch (\Exception $e) {
                    Log::error('Failed to delete media file: ' . $e->getMessage());
                }
            }

            $customerName = $customer->name;
            $customer->delete(); // Soft delete

            DB::commit();

            return back()->with('toast_success', "✅ Customer '{$customerName}' deleted successfully!");
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Customer deletion failed: ' . $e->getMessage());

            return back()->with('toast_error', '❌ Error deleting customer: ' . $e->getMessage());
        }
    }

    // Add Address
    public function addAddress(Request $request, Customer $customer)
    {
        if ($customer->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $request->validate([
            'address_type' => 'required|in:billing,shipping,warehouse,office',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            'is_default' => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {
            // If setting as default, unset other defaults of same type
            if ($request->is_default) {
                Address::where('addressable_type', Customer::class)
                    ->where('addressable_id', $customer->id)
                    ->where('address_type', $request->address_type)
                    ->update(['is_default' => false]);
            }

            Address::create([
                'addressable_type' => Customer::class,
                'addressable_id' => $customer->id,
                'address_type' => $request->address_type,
                'is_default' => $request->is_default ?? false,
                'contact_person' => $request->contact_person,
                'phone' => $request->phone,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'country' => $request->country,
            ]);

            DB::commit();

            return back()->with('toast_success', '✅ Address added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Address creation failed: ' . $e->getMessage());

            return back()->with('toast_error', '❌ Error adding address: ' . $e->getMessage());
        }
    }

    // Delete Address
    public function deleteAddress(Customer $customer, Address $address)
    {
        if ($customer->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        if ($address->addressable_id !== $customer->id) {
            abort(403);
        }

        // ✅ Prevent deleting the only billing address
        if ($address->address_type === 'billing') {
            $billingCount = Address::where('addressable_type', Customer::class)
                ->where('addressable_id', $customer->id)
                ->where('address_type', 'billing')
                ->count();

            if ($billingCount <= 1) {
                return back()->with('toast_error', '❌ Cannot delete the only billing address! Customer must have at least one billing address.');
            }
        }

        // ✅ If deleting a default address, set another as default
        if ($address->is_default) {
            $replacement = Address::where('addressable_type', Customer::class)
                ->where('addressable_id', $customer->id)
                ->where('address_type', $address->address_type)
                ->where('id', '!=', $address->id)
                ->first();

            if ($replacement) {
                $replacement->update(['is_default' => true]);
            }
        }

        try {
            $address->delete();
            return back()->with('toast_success', '✅ Address deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Address deletion failed: ' . $e->getMessage());
            return back()->with('toast_error', '❌ Error deleting address: ' . $e->getMessage());
        }
    }

    // Upload Document
    public function uploadDocument(Request $request, Customer $customer)
    {
        if ($customer->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'category' => 'required|in:contract,certificate,tax_document,other',
            'title' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $file = $request->file('document');
            $path = Storage::disk('spaces')->putFile('vendors/documents', $file, 'public');

            Media::create([
                'mediable_type' => Customer::class,
                'mediable_id' => $customer->id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => str_starts_with($file->getMimeType(), 'image/') ? 'image' : 'document',
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'category' => $request->category,
                'title' => $request->title,
                'is_primary' => false,
            ]);

            DB::commit();

            return back()->with('toast_success', '✅ Document uploaded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Document upload failed: ' . $e->getMessage());

            return back()->with('toast_error', '❌ Error uploading document: ' . $e->getMessage());
        }
    }

    // Delete Media
    public function deleteMedia(Customer $customer, Media $media)
    {
        if ($customer->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        if ($media->mediable_id !== $customer->id) {
            abort(403);
        }

        DB::beginTransaction();

        try {
            Storage::disk('spaces')->delete($media->file_path);
            $media->delete();

            DB::commit();

            return back()->with('toast_success', '✅ File deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Media deletion failed: ' . $e->getMessage());

            return back()->with('toast_error', '❌ Error deleting file: ' . $e->getMessage());
        }
    }

    public function print(Customer $customer)
    {
        if ($customer->company_id !== Auth::user()->company_id) {
            abort(403, 'Unauthorized access');
        }

        $customer->load(['addresses', 'logo']);

        return view('backend.companyadmin.customers.print', compact('customer'));
    }

    // Update Address
    public function updateAddress(Request $request, Customer $customer, Address $address)
    {
        if ($customer->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        if ($address->addressable_id !== $customer->id) {
            abort(403);
        }

        $request->validate([
            'address_type' => 'required|in:billing,shipping,warehouse,office',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            'is_default' => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {
            // If setting as default, unset other defaults of same type
            if ($request->is_default) {
                Address::where('addressable_type', Customer::class)
                    ->where('addressable_id', $customer->id)
                    ->where('address_type', $request->address_type)
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => false]);
            }

            $address->update([
                'address_type' => $request->address_type,
                'is_default' => $request->is_default ?? false,
                'contact_person' => $request->contact_person,
                'phone' => $request->phone,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'country' => $request->country,
            ]);

            DB::commit();

            return back()->with('toast_success', '✅ Address updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Address update failed: ' . $e->getMessage());
            return back()->with('toast_error', '❌ Error updating address: ' . $e->getMessage());
        }
    }
}
