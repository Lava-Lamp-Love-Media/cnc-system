@extends('layouts.app')

@section('title', 'Vendor Details')
@section('page-title', $vendor->name)

@section('content')

<div class="row">
    <!-- Left Column: Vendor Profile -->
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{ $vendor->logo_url }}"
                         alt="{{ $vendor->name }}"
                         style="width: 128px; height: 128px; object-fit: cover;">
                </div>

                <h3 class="profile-username text-center">{{ $vendor->name }}</h3>

                <p class="text-muted text-center">
                    <span class="badge badge-light border">
                        <code>{{ $vendor->vendor_code }}</code>
                    </span>
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Type</b>
                        <span class="float-right">{!! $vendor->type_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b>
                        <span class="float-right">{!! $vendor->status_badge !!}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Payment Terms</b>
                        <span class="float-right">Net {{ $vendor->payment_terms_days }} days</span>
                    </li>
                    @if($vendor->lead_time_days)
                    <li class="list-group-item">
                        <b>Lead Time</b>
                        <span class="float-right">{{ $vendor->lead_time_days }} days</span>
                    </li>
                    @endif
                </ul>

                <a href="{{ route('company.vendors.edit', $vendor->id) }}" class="btn btn-warning btn-block">
                    <i class="fas fa-edit"></i> Edit Vendor
                </a>
                <a href="{{ route('company.vendors.print', $vendor->id) }}" target="_blank" class="btn btn-info btn-block">
                    <i class="fas fa-print"></i> Print Details
                </a>
                <a href="{{ route('company.vendors.index') }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Quick Stats</h3>
            </div>
            <div class="card-body p-0">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <span class="nav-link">
                            Addresses <span class="float-right badge badge-primary">{{ $vendor->addresses->count() }}</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            Certificates <span class="float-right badge badge-success">{{ $vendor->certificates->count() }}</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">
                            Vendor Since <span class="float-right badge badge-info">{{ $vendor->created_at->diffForHumans() }}</span>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Right Column: Details -->
    <div class="col-md-8">
        <!-- Contact Information -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-address-book"></i> Contact Information
                </h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Vendor Code:</dt>
                    <dd class="col-sm-8"><code>{{ $vendor->vendor_code }}</code></dd>

                    <dt class="col-sm-4">Vendor Name:</dt>
                    <dd class="col-sm-8">{{ $vendor->name }}</dd>

                    <dt class="col-sm-4">Email:</dt>
                    <dd class="col-sm-8">
                        @if($vendor->email)
                        <a href="mailto:{{ $vendor->email }}">{{ $vendor->email }}</a>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Phone:</dt>
                    <dd class="col-sm-8">
                        @if($vendor->phone)
                        <a href="tel:{{ $vendor->phone }}">{{ $vendor->phone }}</a>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Tax ID:</dt>
                    <dd class="col-sm-8">{{ $vendor->tax_id ?? '—' }}</dd>

                    @if($vendor->notes)
                    <dt class="col-sm-4">Notes:</dt>
                    <dd class="col-sm-8">{{ $vendor->notes }}</dd>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Addresses -->
        <div class="card card-success card-outline">
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
                @forelse($vendor->addresses as $address)
                <div class="callout callout-{{ $address->address_type == 'billing' ? 'primary' : 'warning' }}">
                    <div class="float-right">
                        <form method="POST" action="{{ route('company.vendors.delete-address', [$vendor->id, $address->id]) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs btn-delete">
                                <i class="fas fa-trash fa-xs"></i>
                            </button>
                        </form>
                    </div>
                    <h5>
                        {!! $address->type_badge !!}
                        @if($address->is_default)
                        <span class="badge badge-warning">Default</span>
                        @endif
                    </h5>
                    @if($address->contact_person)
                    <p class="mb-1"><strong>{{ $address->contact_person }}</strong></p>
                    @endif
                    <p class="mb-0">
                        {{ $address->address_line_1 }}<br>
                        @if($address->address_line_2){{ $address->address_line_2 }}<br>@endif
                        {{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}<br>
                        {{ $address->country }}
                    </p>
                    @if($address->phone)
                    <p class="mb-0 mt-2">
                        <i class="fas fa-phone"></i> {{ $address->phone }}
                    </p>
                    @endif
                </div>
                @empty
                <p class="text-muted text-center py-3">No addresses found.</p>
                @endforelse
            </div>
        </div>

        <!-- Certificates & Documents -->
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-certificate"></i> Certificates & Documents
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#uploadModal">
                        <i class="fas fa-upload"></i> Upload Document
                    </button>
                </div>
            </div>
            <div class="card-body">
                @forelse($vendor->media as $media)
                <div class="row mb-3 pb-3 border-bottom">
                    <div class="col-md-1">
                        <i class="{{ $media->icon }} fa-2x"></i>
                    </div>
                    <div class="col-md-7">
                        <strong>{{ $media->file_name }}</strong><br>
                        <small class="text-muted">
                            {!! $media->category_badge !!}
                            {{ $media->file_size_human }} • 
                            {{ $media->created_at->diffForHumans() }}
                        </small>
                        @if($media->title)
                        <br><small>{{ $media->title }}</small>
                        @endif
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ $media->full_url }}" target="_blank" class="btn btn-info btn-sm">
                            <i class="fas fa-download"></i> Download
                        </a>
                        <form method="POST" action="{{ route('company.vendors.delete-media', [$vendor->id, $media->id]) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center py-3">No documents uploaded.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('company.vendors.add-address', $vendor->id) }}">
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
                                    <option value="warehouse" selected>Warehouse</option>
                                    <option value="shipping">Shipping</option>
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
                        <input type="checkbox" class="custom-control-input" id="is_default" name="is_default" value="1">
                        <label class="custom-control-label" for="is_default">Set as default for this type</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Add Address</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Upload Document Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('company.vendors.upload-document', $vendor->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Upload Document</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Document Category</label>
                        <select name="category" class="form-control" required>
                            <option value="certificate">Certificate</option>
                            <option value="contract">Contract</option>
                            <option value="tax_document">Tax Document</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Title (Optional)</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>File</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="document" required>
                            <label class="custom-file-label">Choose file</label>
                        </div>
                        <small class="text-muted">Max 5MB (PDF, DOC, DOCX, JPG, PNG)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$('.custom-file-input').on('change', function() {
    var fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').html(fileName);
});
</script>
@endpush