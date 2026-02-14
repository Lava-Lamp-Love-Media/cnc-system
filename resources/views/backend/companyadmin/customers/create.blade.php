@extends('layouts.app')

@section('title', 'Create Customer')
@section('page-title', 'Add New Customer')

@section('content')

<form method="POST" action="{{ route('company.customers.store') }}" enctype="multipart/form-data" id="customerForm">
    @csrf

    <!-- Customer Information Card -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-info-circle"></i> Customer Information
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Customer Code <span class="text-danger">*</span></label>
                        <input type="text" name="customer_code" id="customerCode"
                            class="form-control @error('customer_code') is-invalid @enderror"
                            value="{{ old('customer_code') }}" placeholder="e.g., CUST-00001" required>
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
                            value="{{ old('name') }}" required>
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
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}">
                        @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone') }}">
                        @error('phone')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Customer Type <span class="text-danger">*</span></label>
                        <select name="customer_type" class="form-control" required>
                            <option value="company" {{ old('customer_type', 'company') == 'company' ? 'selected' : '' }}>Company</option>
                            <option value="individual" {{ old('customer_type') == 'individual' ? 'selected' : '' }}>Individual</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Credit Limit ($)</label>
                        <input type="number" step="0.01" name="credit_limit"
                            class="form-control" value="{{ old('credit_limit') }}" placeholder="0.00">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Payment Terms (Days) <span class="text-danger">*</span></label>
                        <input type="number" name="payment_terms_days"
                            class="form-control" value="{{ old('payment_terms_days', 30) }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tax ID</label>
                        <input type="text" name="tax_id" class="form-control"
                            value="{{ old('tax_id') }}" placeholder="XX-XXXXXXX">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Customer Logo</label>
                        <div class="mb-2" id="imagePreview" style="display: none;">
                            <img id="previewImg" src="" alt="Logo Preview"
                                class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                            <button type="button" class="btn btn-sm btn-danger ml-2" id="removeImage">
                                <i class="fas fa-times"></i> Remove
                            </button>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="logo" name="logo" accept="image/*">
                            <label class="custom-file-label" for="logo">Choose file</label>
                        </div>
                        <small class="text-muted">Max 2MB (jpeg, png, jpg, gif)</small>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
            </div>
        </div>
    </div>

    <!-- Addresses Card -->
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-map-marker-alt"></i> Addresses
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm" id="addAddressBtn">
                    <i class="fas fa-plus"></i> Add Address
                </button>
            </div>
        </div>
        <div class="card-body">
            <div id="addressesContainer">
                <!-- Default Billing Address -->
                <div class="address-item border p-3 mb-3 rounded" data-index="0">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">
                            <span class="badge badge-primary">Address 1</span>
                            <span class="badge badge-info ml-2">Billing (Default)</span>
                        </h5>
                    </div>

                    <input type="hidden" name="addresses[0][address_type]" value="billing">
                    <input type="hidden" name="addresses[0][is_default]" value="1">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contact Person</label>
                                <input type="text" name="addresses[0][contact_person]" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="addresses[0][phone]" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" name="addresses[0][address_line_1]" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Address Line 2</label>
                        <input type="text" name="addresses[0][address_line_2]" class="form-control">
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>City <span class="text-danger">*</span></label>
                                <input type="text" name="addresses[0][city]" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>State</label>
                                <input type="text" name="addresses[0][state]" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>ZIP Code</label>
                                <input type="text" name="addresses[0][zip_code]" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Country <span class="text-danger">*</span></label>
                        <input type="text" name="addresses[0][country]" class="form-control" value="USA" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Buttons -->
    <div class="card">
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Create Customer
            </button>
            <a href="{{ route('company.customers.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </div>

</form>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let addressIndex = 1;

        // Image Preview
        $('#logo').on('change', function(e) {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);

            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                    $('#imagePreview').show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        $('#removeImage').on('click', function() {
            $('#logo').val('');
            $('.custom-file-label').html('Choose file');
            $('#imagePreview').hide();
        });

        // Auto-generate customer code
        $('input[name="name"]').on('blur', function() {
            var name = $(this).val();
            if (name && !$('#customerCode').val()) {
                var code = 'CUST-' + Math.floor(Math.random() * 100000).toString().padStart(5, '0');
                $('#customerCode').val(code);
            }
        });

        // Add Address
        $('#addAddressBtn').on('click', function() {
            const html = `
            <div class="address-item border p-3 mb-3 rounded" data-index="${addressIndex}">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">
                        <span class="badge badge-secondary">Address ${addressIndex + 1}</span>
                    </h5>
                    <button type="button" class="btn btn-danger btn-sm remove-address">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label>Address Type <span class="text-danger">*</span></label>
                        <select name="addresses[${addressIndex}][address_type]" class="form-control" required>
                            <option value="shipping">Shipping</option>
                            <option value="billing">Billing</option>
                            <option value="warehouse">Warehouse</option>
                            <option value="office">Office</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>&nbsp;</label>
                        <div class="custom-control custom-checkbox pt-2">
                            <input type="checkbox" class="custom-control-input" 
                                   id="default_${addressIndex}" 
                                   name="addresses[${addressIndex}][is_default]" value="1">
                            <label class="custom-control-label" for="default_${addressIndex}">
                                Set as default for this type
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contact Person</label>
                            <input type="text" name="addresses[${addressIndex}][contact_person]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="addresses[${addressIndex}][phone]" class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Address Line 1 <span class="text-danger">*</span></label>
                    <input type="text" name="addresses[${addressIndex}][address_line_1]" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Address Line 2</label>
                    <input type="text" name="addresses[${addressIndex}][address_line_2]" class="form-control">
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>City <span class="text-danger">*</span></label>
                            <input type="text" name="addresses[${addressIndex}][city]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" name="addresses[${addressIndex}][state]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>ZIP Code</label>
                            <input type="text" name="addresses[${addressIndex}][zip_code]" class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Country <span class="text-danger">*</span></label>
                    <input type="text" name="addresses[${addressIndex}][country]" class="form-control" value="USA" required>
                </div>
            </div>
        `;

            $('#addressesContainer').append(html);
            addressIndex++;
        });

        // Remove Address
        $(document).on('click', '.remove-address', function() {
            $(this).closest('.address-item').remove();
        });

        // Form submission
        $('#customerForm').submit(function() {
            $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Creating...').prop('disabled', true);
        });
    });
</script>
@endpush