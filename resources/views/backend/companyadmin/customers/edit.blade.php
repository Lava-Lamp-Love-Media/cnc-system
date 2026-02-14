@extends('layouts.app')

@section('title', 'Edit Customer')
@section('page-title', 'Edit Customer')

@section('content')

<form method="POST" 
      action="{{ route('company.customers.update', $customer->id) }}" 
      enctype="multipart/form-data" 
      id="customerForm"
      data-has-logo="{{ $customer->logo ? '1' : '0' }}">
    @csrf
    @method('PUT')

    <!-- Customer Information Card -->
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit"></i> Edit Customer: {{ $customer->name }}
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Customer Code <span class="text-danger">*</span></label>
                        <input type="text" name="customer_code"
                            class="form-control @error('customer_code') is-invalid @enderror"
                            value="{{ old('customer_code', $customer->customer_code) }}" required>
                        @error('customer_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Customer Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $customer->name) }}" required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $customer->email) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ old('phone', $customer->phone) }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Customer Type <span class="text-danger">*</span></label>
                        <select name="customer_type" class="form-control" required>
                            <option value="company" {{ old('customer_type', $customer->customer_type) == 'company' ? 'selected' : '' }}>Company</option>
                            <option value="individual" {{ old('customer_type', $customer->customer_type) == 'individual' ? 'selected' : '' }}>Individual</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ old('status', $customer->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $customer->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ old('status', $customer->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Credit Limit ($)</label>
                        <input type="number" step="0.01" name="credit_limit" class="form-control"
                            value="{{ old('credit_limit', $customer->credit_limit) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Payment Terms (Days) <span class="text-danger">*</span></label>
                        <input type="number" name="payment_terms_days" class="form-control"
                            value="{{ old('payment_terms_days', $customer->payment_terms_days) }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tax ID</label>
                        <input type="text" name="tax_id" class="form-control"
                            value="{{ old('tax_id', $customer->tax_id) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Customer Logo</label>
                        
                        <!-- Current Logo -->
                        <div class="mb-2" id="currentImage" style="{{ $customer->logo ? '' : 'display: none;' }}">
                            <img id="currentImg" src="{{ $customer->logo_url }}" alt="{{ $customer->name }}"
                                class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                            <button type="button" class="btn btn-sm btn-warning ml-2" id="changeImage">
                                <i class="fas fa-sync"></i> Change
                            </button>
                        </div>
                        
                        <!-- New Image Preview -->
                        <div class="mb-2" id="imagePreview" style="display: none;">
                            <img id="previewImg" src="" alt="New Logo"
                                class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                            <button type="button" class="btn btn-sm btn-danger ml-2" id="removeImage">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        </div>
                        
                        <div class="custom-file" id="fileInputWrapper" style="{{ $customer->logo ? 'display: none;' : '' }}">
                            <input type="file" class="custom-file-input" id="logo" name="logo" accept="image/*">
                            <label class="custom-file-label" for="logo">Choose file</label>
                        </div>
                        <small class="text-muted d-block mt-1">Max 2MB</small>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes', $customer->notes) }}</textarea>
            </div>
        </div>
    </div>

    <!-- Addresses Management -->
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-map-marker-alt"></i> Addresses
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addAddressModal">
                    <i class="fas fa-plus"></i> Add Address
                </button>
            </div>
        </div>
        <div class="card-body">
            @forelse($customer->addresses as $address)
            <div class="border p-3 mb-3 rounded">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        {!! $address->type_badge !!}
                        @if($address->is_default)
                        <span class="badge badge-warning">Default</span>
                        @endif
                        @if($address->contact_person)
                        <br><strong>{{ $address->contact_person }}</strong>
                        @endif
                    </div>
                    <div>
                        <button type="button" class="btn btn-info btn-sm edit-address-btn" 
                                data-id="{{ $address->id }}"
                                data-type="{{ $address->address_type }}"
                                data-default="{{ $address->is_default ? '1' : '0' }}"
                                data-contact="{{ $address->contact_person ?? '' }}"
                                data-phone="{{ $address->phone ?? '' }}"
                                data-line1="{{ $address->address_line_1 }}"
                                data-line2="{{ $address->address_line_2 ?? '' }}"
                                data-city="{{ $address->city }}"
                                data-state="{{ $address->state ?? '' }}"
                                data-zip="{{ $address->zip_code ?? '' }}"
                                data-country="{{ $address->country }}">
                            <i class="fas fa-edit fa-xs"></i> Edit
                        </button>
                        
                        @php
                            $canDelete = true;
                            if ($address->address_type === 'billing') {
                                $billingCount = $customer->addresses->where('address_type', 'billing')->count();
                                if ($billingCount <= 1) {
                                    $canDelete = false;
                                }
                            }
                        @endphp
                        
                        @if($canDelete)
                        <button type="button" class="btn btn-danger btn-sm delete-address-btn"
                                data-url="{{ route('company.customers.delete-address', [$customer->id, $address->id]) }}">
                            <i class="fas fa-trash fa-xs"></i> Delete
                        </button>
                        @else
                        <button type="button" class="btn btn-secondary btn-sm" disabled title="Cannot delete the only billing address">
                            <i class="fas fa-lock fa-xs"></i> Protected
                        </button>
                        @endif
                    </div>
                </div>
                <p class="mb-0 mt-2">
                    {{ $address->address_line_1 }}<br>
                    @if($address->address_line_2){{ $address->address_line_2 }}<br>@endif
                    {{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}<br>
                    {{ $address->country }}
                    @if($address->phone)
                    <br><i class="fas fa-phone fa-xs"></i> {{ $address->phone }}
                    @endif
                </p>
            </div>
            @empty
            <p class="text-muted text-center">No addresses found.</p>
            @endforelse
        </div>
    </div>

    <!-- Submit Buttons -->
    <div class="card">
        <div class="card-footer">
            <button type="submit" class="btn btn-warning btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Update Customer
            </button>
            <a href="{{ route('company.customers.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
            <a href="{{ route('company.customers.show', $customer->id) }}" class="btn btn-info btn-lg">
                <i class="fas fa-eye"></i> View Details
            </a>
        </div>
    </div>
</form>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('company.customers.add-address', $customer->id) }}" id="addAddressForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Address</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address Type <span class="text-danger">*</span></label>
                                <select name="address_type" class="form-control" required>
                                    <option value="billing">Billing</option>
                                    <option value="shipping" selected>Shipping</option>
                                    <option value="warehouse">Warehouse</option>
                                    <option value="office">Office</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contact Person</label>
                                <input type="text" name="contact_person" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" name="address_line_1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Address Line 2</label>
                        <input type="text" name="address_line_2" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>City <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>State</label>
                                <input type="text" name="state" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>ZIP Code</label>
                                <input type="text" name="zip_code" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Country <span class="text-danger">*</span></label>
                        <input type="text" name="country" class="form-control" value="USA" required>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_default_add" name="is_default" value="1">
                        <label class="custom-control-label" for="is_default_add">Set as default for this type</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Add Address
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Address Modal -->
<div class="modal fade" id="editAddressModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="editAddressForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Address</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address Type <span class="text-danger">*</span></label>
                                <select name="address_type" id="edit_address_type" class="form-control" required>
                                    <option value="billing">Billing</option>
                                    <option value="shipping">Shipping</option>
                                    <option value="warehouse">Warehouse</option>
                                    <option value="office">Office</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contact Person</label>
                                <input type="text" name="contact_person" id="edit_contact_person" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" id="edit_phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" name="address_line_1" id="edit_line1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Address Line 2</label>
                        <input type="text" name="address_line_2" id="edit_line2" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>City <span class="text-danger">*</span></label>
                                <input type="text" name="city" id="edit_city" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>State</label>
                                <input type="text" name="state" id="edit_state" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>ZIP Code</label>
                                <input type="text" name="zip_code" id="edit_zip" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Country <span class="text-danger">*</span></label>
                        <input type="text" name="country" id="edit_country" class="form-control" required>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="edit_is_default" name="is_default" value="1">
                        <label class="custom-control-label" for="edit_is_default">Set as default for this type</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Address
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var hasLogo = $('#customerForm').data('has-logo') == '1';

    // Change image button
    $('#changeImage').on('click', function(e) {
        e.preventDefault();
        $('#currentImage').hide();
        $('#fileInputWrapper').show();
    });

    // Image Preview
    $('#logo').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
        
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImg').attr('src', e.target.result);
                $('#imagePreview').show();
                $('#fileInputWrapper').hide();
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Cancel new image
    $('#removeImage').on('click', function(e) {
        e.preventDefault();
        $('#logo').val('');
        $('.custom-file-label').html('Choose file');
        $('#imagePreview').hide();
        
        if (hasLogo) {
            $('#currentImage').show();
        } else {
            $('#fileInputWrapper').show();
        }
    });

    // Edit Address Button
    $(document).on('click', '.edit-address-btn', function(e) {
        e.preventDefault();
        
        var addressId = $(this).data('id');
        var updateUrl = '{{ route("company.customers.update-address", [$customer->id, "ADDRESS_ID"]) }}';
        updateUrl = updateUrl.replace('ADDRESS_ID', addressId);
        
        $('#editAddressForm').attr('action', updateUrl);
        $('#edit_address_type').val($(this).data('type'));
        $('#edit_contact_person').val($(this).data('contact'));
        $('#edit_phone').val($(this).data('phone'));
        $('#edit_line1').val($(this).data('line1'));
        $('#edit_line2').val($(this).data('line2'));
        $('#edit_city').val($(this).data('city'));
        $('#edit_state').val($(this).data('state'));
        $('#edit_zip').val($(this).data('zip'));
        $('#edit_country').val($(this).data('country'));
        $('#edit_is_default').prop('checked', $(this).data('default') == '1');
        
        $('#editAddressModal').modal('show');
    });

    // Delete Address Button with AJAX
    $(document).on('click', '.delete-address-btn', function(e) {
        e.preventDefault();
        
        var deleteUrl = $(this).data('url');
        var btn = $(this);
        
        if (confirm('Are you sure you want to delete this address?')) {
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error deleting address. Please try again.');
                }
            });
        }
    });
});
</script>
@endpush