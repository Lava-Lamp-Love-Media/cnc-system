<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Address;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::where('company_id', Auth::user()->company_id)
            ->with(['billingAddress', 'logo'])
            ->latest()
            ->paginate(15);

        return view('backend.companyadmin.vendors.index', compact('vendors'));
    }

    public function create()
    {
        return view('backend.companyadmin.vendors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_code' => 'required|string|unique:vendors,vendor_code|max:50',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'vendor_type' => 'required|in:supplier,manufacturer,distributor,contractor',
            'payment_terms_days' => 'required|integer|min:0',
            'lead_time_days' => 'nullable|integer|min:0',
            'tax_id' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,blacklisted',
            'notes' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'addresses' => 'required|array|min:1',
            'addresses.*.address_type' => 'required|in:billing,shipping,warehouse,office',
            'addresses.*.address_line_1' => 'required|string|max:255',
            'addresses.*.city' => 'required|string|max:100',
            'addresses.*.country' => 'required|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            $vendor = Vendor::create([
                'company_id' => Auth::user()->company_id,
                'vendor_code' => $request->vendor_code,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'vendor_type' => $request->vendor_type,
                'payment_terms_days' => $request->payment_terms_days,
                'lead_time_days' => $request->lead_time_days,
                'tax_id' => $request->tax_id,
                'status' => $request->status,
                'notes' => $request->notes,
            ]);

            // Create Addresses
            if ($request->has('addresses')) {
                foreach ($request->addresses as $addressData) {
                    Address::create([
                        'addressable_type' => Vendor::class,
                        'addressable_id' => $vendor->id,
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

            // Handle Logo Upload
            if ($request->hasFile('logo')) {
                try {
                    $file = $request->file('logo');
                    $path = Storage::disk('spaces')->putFile('vendors/logos', $file, 'public');

                    Media::create([
                        'mediable_type' => Vendor::class,
                        'mediable_id' => $vendor->id,
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

            return redirect()->route('company.vendors.index')
                ->with('toast_success', '✅ Vendor created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Vendor creation failed: ' . $e->getMessage());
            return back()->withInput()->with('toast_error', '❌ Error creating vendor: ' . $e->getMessage());
        }
    }

    public function show(Vendor $vendor)
    {
        if ($vendor->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $vendor->load(['addresses', 'media']);

        return view('backend.companyadmin.vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        if ($vendor->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $vendor->load(['addresses', 'billingAddress']);

        return view('backend.companyadmin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        if ($vendor->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $request->validate([
            'vendor_code' => 'required|string|max:50|unique:vendors,vendor_code,' . $vendor->id,
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'vendor_type' => 'required|in:supplier,manufacturer,distributor,contractor',
            'payment_terms_days' => 'required|integer|min:0',
            'lead_time_days' => 'nullable|integer|min:0',
            'tax_id' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,blacklisted',
            'notes' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $vendor->update($request->except('logo'));

            if ($request->hasFile('logo')) {
                try {
                    if ($vendor->logo) {
                        Storage::disk('spaces')->delete($vendor->logo->file_path);
                        $vendor->logo->delete();
                    }

                    $file = $request->file('logo');
                    $path = Storage::disk('spaces')->putFile('vendors/logos', $file, 'public');

                    Media::create([
                        'mediable_type' => Vendor::class,
                        'mediable_id' => $vendor->id,
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

            return redirect()->route('company.vendors.index')
                ->with('toast_success', '✅ Vendor updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Vendor update failed: ' . $e->getMessage());
            return back()->withInput()->with('toast_error', '❌ Error updating vendor: ' . $e->getMessage());
        }
    }

    public function destroy(Vendor $vendor)
    {
        if ($vendor->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        DB::beginTransaction();

        try {
            foreach ($vendor->media as $media) {
                try {
                    Storage::disk('spaces')->delete($media->file_path);
                } catch (\Exception $e) {
                    Log::error('Failed to delete media: ' . $e->getMessage());
                }
            }

            $vendorName = $vendor->name;
            $vendor->delete();

            DB::commit();

            return back()->with('toast_success', "✅ Vendor '{$vendorName}' deleted successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Vendor deletion failed: ' . $e->getMessage());
            return back()->with('toast_error', '❌ Error deleting vendor: ' . $e->getMessage());
        }
    }

    // Add Address
    public function addAddress(Request $request, Vendor $vendor)
    {
        if ($vendor->company_id !== Auth::user()->company_id) {
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
            if ($request->is_default) {
                Address::where('addressable_type', Vendor::class)
                    ->where('addressable_id', $vendor->id)
                    ->where('address_type', $request->address_type)
                    ->update(['is_default' => false]);
            }

            Address::create([
                'addressable_type' => Vendor::class,
                'addressable_id' => $vendor->id,
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


    // Update Address
    public function updateAddress(Request $request, Vendor $vendor, Address $address)
    {
        if ($vendor->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        if ($address->addressable_id !== $vendor->id) {
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
            if ($request->is_default) {
                Address::where('addressable_type', Vendor::class)
                    ->where('addressable_id', $vendor->id)
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

    // Delete Address
    public function deleteAddress(Vendor $vendor, Address $address)
    {
        if ($vendor->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        if ($address->addressable_id !== $vendor->id) {
            abort(403);
        }

        // Prevent deleting the only billing address
        if ($address->address_type === 'billing') {
            $billingCount = Address::where('addressable_type', Vendor::class)
                ->where('addressable_id', $vendor->id)
                ->where('address_type', 'billing')
                ->count();

            if ($billingCount <= 1) {
                return back()->with('toast_error', '❌ Cannot delete the only billing address! Vendor must have at least one billing address.');
            }
        }

        // If deleting a default address, set another as default
        if ($address->is_default) {
            $replacement = Address::where('addressable_type', Vendor::class)
                ->where('addressable_id', $vendor->id)
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
    public function uploadDocument(Request $request, Vendor $vendor)
    {
        if ($vendor->company_id !== Auth::user()->company_id) {
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
                'mediable_type' => Vendor::class,
                'mediable_id' => $vendor->id,
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
    public function deleteMedia(Vendor $vendor, Media $media)
    {
        if ($vendor->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        if ($media->mediable_id !== $vendor->id) {
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

    // Print
    public function print(Vendor $vendor)
    {
        if ($vendor->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $vendor->load(['addresses', 'logo']);

        return view('backend.companyadmin.vendors.print', compact('vendor'));
    }
}
