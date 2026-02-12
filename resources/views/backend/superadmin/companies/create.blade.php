@extends('layouts.app')

@section('title','Create Company')
@section('page-title','Create Company & Admin')

@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-plus"></i> Add New Company
        </h3>
    </div>

    <form method="POST" action="{{ route('superadmin.companies.store') }}" id="companyForm">
        @csrf

        <div class="card-body">
            <div class="row">

                <!-- Left Side: Company Info -->
                <div class="col-md-6">
                    <h5 class="text-primary">
                        <i class="fas fa-building"></i> Company Information
                    </h5>
                    <hr>

                    <div class="form-group">
                        <label>Company Name <span class="text-danger">*</span></label>
                        <input type="text"
                            name="company_name"
                            class="form-control @error('company_name') is-invalid @enderror"
                            value="{{ old('company_name') }}"
                            placeholder="Enter company name"
                            required>
                        @error('company_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Company Email <span class="text-danger">*</span></label>
                        <input type="email"
                            name="company_email"
                            class="form-control @error('company_email') is-invalid @enderror"
                            value="{{ old('company_email') }}"
                            placeholder="company@example.com"
                            required>
                        @error('company_email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text"
                            name="company_phone"
                            class="form-control"
                            value="{{ old('company_phone') }}"
                            placeholder="Optional">
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="company_address"
                            class="form-control"
                            rows="3"
                            placeholder="Optional">{{ old('company_address') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Select Plan <span class="text-danger">*</span></label>
                        <select name="plan_id"
                            class="form-control @error('plan_id') is-invalid @enderror"
                            required>
                            <option value="">-- Select Plan --</option>
                            @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} - ${{ number_format($plan->price, 2) }}/month
                            </option>
                            @endforeach
                        </select>
                        @error('plan_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="trial" {{ old('status', 'trial') == 'trial' ? 'selected' : '' }}>Trial</option>
                            <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>
                </div>

                <!-- Right Side: Admin Assignment -->
                <div class="col-md-6">
                    <h5 class="text-success">
                        <i class="fas fa-user-shield"></i> Assign Company Admin
                    </h5>
                    <hr>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Two Options:</strong>
                        <ol class="mb-0 pl-3">
                            <li>Search & assign existing user</li>
                            <li>Create new admin user</li>
                        </ol>
                    </div>

                    <!-- Search Existing User -->
                    <div class="card bg-light mb-3">
                        <div class="card-body">
                            <label class="font-weight-bold">
                                <i class="fas fa-search"></i> Search Existing User
                            </label>
                            <div class="input-group">
                                <input type="email"
                                    id="searchEmail"
                                    class="form-control"
                                    placeholder="Enter email to search...">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-info" id="btnSearchUser">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted">Check if user already exists</small>
                        </div>
                    </div>

                    <!-- Search Results -->
                    <div id="searchResults" style="display:none;"></div>

                    <div class="text-center my-2">
                        <strong class="text-muted">— OR —</strong>
                    </div>

                    <!-- Create New User Section -->
                    <div id="newUserSection">
                        <div class="card bg-light">
                            <div class="card-body">
                                <label class="font-weight-bold text-success">
                                    <i class="fas fa-user-plus"></i> Create New Admin
                                </label>

                                <input type="hidden" name="assignment_type" id="assignmentType" value="new">
                                <input type="hidden" name="existing_user_id" id="existingUserId" value="{{ old('existing_user_id') }}">

                                <div class="form-group">
                                    <label>Admin Name <span class="text-danger" id="nameRequired">*</span></label>
                                    <input type="text"
                                        name="admin_name"
                                        id="adminName"
                                        class="form-control @error('admin_name') is-invalid @enderror"
                                        value="{{ old('admin_name') }}"
                                        placeholder="Full name">
                                    @error('admin_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Admin Email <span class="text-danger" id="emailRequired">*</span></label>
                                    <input type="email"
                                        name="admin_email"
                                        id="adminEmail"
                                        class="form-control @error('admin_email') is-invalid @enderror"
                                        value="{{ old('admin_email') }}"
                                        placeholder="email@example.com">
                                    @error('admin_email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">
                                        <i class="fas fa-lock"></i> Password will be auto-generated
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Create Company & Assign Admin
            </button>
            <a href="{{ route('superadmin.companies.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Form submission with validation
        $('#companyForm').submit(function(e) {
            var assignmentType = $('#assignmentType').val();

            // Frontend validation
            if (assignmentType === 'new') {
                var adminName = $('#adminName').val().trim();
                var adminEmail = $('#adminEmail').val().trim();

                if (!adminName || !adminEmail) {
                    e.preventDefault();
                    toastr.error('Please fill in all admin details');
                    return false;
                }
            } else if (assignmentType === 'existing') {
                var userId = $('#existingUserId').val();

                if (!userId) {
                    e.preventDefault();
                    toastr.error('Please select a user or create new admin');
                    return false;
                }
            }

            // Show loading on submit button
            $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Creating...').prop('disabled', true);
        });

        // Search User
        $('#btnSearchUser').click(function() {
            const email = $('#searchEmail').val().trim();

            if (!email) {
                toastr.error('Please enter an email address');
                return;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                toastr.error('Please enter a valid email address');
                return;
            }

            // Show loading
            $(this).html('<i class="fas fa-spinner fa-spin"></i> Searching...').prop('disabled', true);

            $.ajax({
                url: '{{ route("superadmin.companies.search-user") }}',
                method: 'POST',
                data: {
                    email: email,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#btnSearchUser').html('<i class="fas fa-search"></i> Search').prop('disabled', false);

                    if (response.found) {
                        if (response.assigned) {
                            $('#searchResults').html(`
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>User Already Assigned!</strong>
                                <hr>
                                <p class="mb-1"><strong>Name:</strong> ${response.user.name}</p>
                                <p class="mb-1"><strong>Email:</strong> ${response.user.email}</p>
                                <p class="mb-0"><strong>Currently at:</strong> ${response.company}</p>
                            </div>
                        `).slideDown();
                            toastr.warning('User already assigned to another company');
                        } else {
                            $('#searchResults').html(`
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i>
                                <strong>User Found!</strong>
                                <hr>
                                <p class="mb-2">
                                    <strong>${response.user.name}</strong><br>
                                    <small>${response.user.email}</small>
                                </p>
                                <button type="button" class="btn btn-sm btn-success" onclick="assignExistingUser(${response.user.id}, '${response.user.name}', '${response.user.email}')">
                                    <i class="fas fa-user-check"></i> Assign as Company Admin
                                </button>
                            </div>
                        `).slideDown();
                            toastr.success('User found and available!');
                        }
                    } else {
                        $('#searchResults').html(`
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>User Not Found</strong>
                            <hr>
                            <p class="mb-2">No user with email: <code>${email}</code></p>
                            <button type="button" class="btn btn-sm btn-primary" onclick="createNewUser('${email}')">
                                <i class="fas fa-user-plus"></i> Create New User
                            </button>
                        </div>
                    `).slideDown();
                        toastr.info('User not found. You can create a new one.');
                    }
                },
                error: function(xhr) {
                    $('#btnSearchUser').html('<i class="fas fa-search"></i> Search').prop('disabled', false);

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        toastr.error(Object.values(xhr.responseJSON.errors)[0][0]);
                    } else {
                        toastr.error('Error searching user');
                    }
                }
            });
        });

        // Enter key support
        $('#searchEmail').keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                $('#btnSearchUser').click();
            }
        });
    });

    // Assign Existing User
    function assignExistingUser(userId, name, email) {
        $('#assignmentType').val('existing');
        $('#existingUserId').val(userId);

        $('#newUserSection').html(`
        <div class="alert alert-success">
            <i class="fas fa-user-check"></i>
            <strong>Selected User:</strong>
            <hr>
            <p class="mb-2">
                <strong>Name:</strong> ${name}<br>
                <strong>Email:</strong> ${email}
            </p>
            <button type="button" class="btn btn-sm btn-warning" onclick="resetForm()">
                <i class="fas fa-undo"></i> Change Selection
            </button>
        </div>
    `);

        $('#adminName').removeAttr('required');
        $('#adminEmail').removeAttr('required');
        $('#searchResults').slideUp();

        toastr.success('User selected for assignment!');
    }

    // Create New User
    function createNewUser(email) {
        $('#assignmentType').val('new');
        $('#adminEmail').val(email);
        $('#searchResults').slideUp();
        $('#adminName').focus();

        toastr.info('Please enter admin name');
    }

    // Reset Form
    function resetForm() {
        $('#assignmentType').val('new');
        $('#existingUserId').val('');
        $('#searchEmail').val('');
        $('#searchResults').hide();

        $('#newUserSection').html(`
        <div class="card bg-light">
            <div class="card-body">
                <label class="font-weight-bold text-success">
                    <i class="fas fa-user-plus"></i> Create New Admin
                </label>

                <div class="form-group">
                    <label>Admin Name <span class="text-danger">*</span></label>
                    <input type="text" name="admin_name" id="adminName" class="form-control" placeholder="Full name" required>
                </div>

                <div class="form-group">
                    <label>Admin Email <span class="text-danger">*</span></label>
                    <input type="email" name="admin_email" id="adminEmail" class="form-control" placeholder="email@example.com" required>
                    <small class="text-muted">
                        <i class="fas fa-lock"></i> Password will be auto-generated
                    </small>
                </div>
            </div>
        </div>
    `);

        toastr.info('Form reset to create new user');
    }
</script>
@endpush