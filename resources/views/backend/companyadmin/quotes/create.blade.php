@extends('layouts.app')

@section('title', 'Create Quote/Job')
@section('page-title', 'New Quote / Job Order')

@section('content')

<form id="quoteForm" method="POST" action="#" enctype="multipart/form-data">
    @csrf

    {{-- CUSTOMER SECTION --}}
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user"></i> Customer Information
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Select Customer <span class="text-danger">*</span></label>
                        <select name="customer_id" class="form-control select2" required>
                            <option value="">Select Customer</option>
                            <option value="1">Company One</option>
                            <option value="2">ABC Manufacturing</option>
                            <option value="3">XYZ Industries</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="custom-control custom-checkbox mt-4 pt-2">
                        <input type="checkbox" class="custom-control-input" id="temp_customer">
                        <label class="custom-control-label" for="temp_customer">Temp Customer</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h4 class="card-title mb-0">
                                SHIP TO
                                <button type="button" class="btn btn-xs btn-default float-right">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </h4>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">—</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h4 class="card-title mb-0">
                                BILL TO
                                <button type="button" class="btn btn-xs btn-default float-right">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </h4>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">—</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Manufacturing Method</label>
                        <select name="manufacturing_method" class="form-control">
                            <option value="">Select</option>
                            <option value="cnc_milling">CNC Milling</option>
                            <option value="cnc_turning">CNC Turning</option>
                            <option value="manual_machining">Manual Machining</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Customer Part # Alias</label>
                        <input type="text" name="customer_part_alias" class="form-control" placeholder="Enter part number">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cage Number</label>
                        <input type="text" name="cage_number" class="form-control" placeholder="Enter cage number">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="">Select</option>
                            <option value="quote">Quote</option>
                            <option value="job">Job Order</option>
                            <option value="rework">Rework</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Order/Quote #</label>
                        <input type="text" name="quote_number" class="form-control" value="0215202600027" readonly>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Unit</label>
                        <select name="unit" class="form-control">
                            <option value="">Select</option>
                            <option value="mm">Millimeters (mm)</option>
                            <option value="inch">Inches (in)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Setup Price</label>
                        <select name="setup_price_type" class="form-control">
                            <option value="not_charge">Not Charge</option>
                            <option value="fixed">Fixed Amount</option>
                            <option value="percentage">Percentage</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" step="0.01" name="setup_price" class="form-control" value="0" placeholder="0">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Quantity / Pieces</label>
                        <input type="number" name="quantity" class="form-control" placeholder="Enter quantity">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ATTACHMENTS SECTION --}}
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-paperclip"></i> Attachments
            </h3>
        </div>
        <div class="card-body">
            <p class="text-muted">Drawings / Photos (Drag & Drop)</p>
            <div class="border rounded p-5 text-center" style="border-style: dashed !important;">
                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                <h5>Drop files here...</h5>
                <p class="text-muted">Drop files here to upload</p>
                <input type="file" name="attachments[]" multiple class="d-none" id="fileInput">
                <button type="button" class="btn btn-primary" onclick="$('#fileInput').click()">
                    <i class="fas fa-upload"></i> Browse Files
                </button>
            </div>
        </div>
    </div>

    {{-- MATERIAL SECTION --}}
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-cube"></i> Material Information
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Shape <span class="text-danger">*</span></label>
                        <select name="shape" class="form-control" id="shapeSelect">
                            <option value="">Select Shape</option>
                            <option value="round">Round</option>
                            <option value="width_length_height">Width × Length × Height</option>
                            <option value="square">Square</option>
                            <option value="hexagon">Hexagon</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Pin Size Diameter</label>
                        <input type="number" step="0.001" name="pin_size_diameter" class="form-control" placeholder="Enter diameter">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Diameter Adjustment</label>
                        <input type="number" step="0.001" name="diameter_adjustment" class="form-control" value="0" placeholder="0">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Material Type</label>
                        <select name="material_type" class="form-control">
                            <option value="">Select Type</option>
                            <option value="metal_alloy">Metal Alloy</option>
                            <option value="plastic">Plastic</option>
                            <option value="composite">Composite</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Metal Alloy</label>
                        <select name="metal_alloy" class="form-control">
                            <option value="">Select Metal</option>
                            <option value="1018">1018-1022</option>
                            <option value="6061">Aluminum 6061</option>
                            <option value="304">Stainless 304</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Block price per LB/Kg</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" step="0.01" name="block_price" class="form-control" value="0" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Metal Adjustment Price</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" step="0.01" name="metal_adjustment" class="form-control" value="0" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Metal Real Price</label>
                        <input type="number" step="0.01" name="metal_real_price" class="form-control bg-light" value="0" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Over All Pin Length</label>
                        <input type="number" step="0.01" name="pin_length" class="form-control" placeholder="Enter length">
                    </div>
                </div>
            </div>

            {{-- WIDTH × LENGTH × HEIGHT FIELDS (Hidden by default) --}}
            <div class="row" id="dimensionFields" style="display: none;">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Width</label>
                        <input type="number" step="0.001" name="width" class="form-control" placeholder="Enter width">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Length</label>
                        <input type="number" step="0.001" name="length" class="form-control" placeholder="Enter length">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Height</label>
                        <input type="number" step="0.001" name="height" class="form-control" placeholder="Enter height">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Each Pin Price</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" step="0.01" name="each_pin_price" class="form-control bg-light" value="0" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Total Pin Price</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" step="0.01" name="total_pin_price" class="form-control bg-light" value="0" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Calculated Weight (kg)</label>
                        <input type="number" step="0.001" name="weight_kg" class="form-control bg-light" value="0" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Calculated Weight (lbs)</label>
                        <input type="number" step="0.001" name="weight_lbs" class="form-control bg-light" value="0" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Total Calculated Weight (kg)</label>
                        <input type="number" step="0.001" name="total_weight_kg" class="form-control bg-light" value="0" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Total Calculated Weight (lbs)</label>
                        <input type="number" step="0.001" name="total_weight_lbs" class="form-control bg-light" value="0" readonly>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Cubic inch volume</label>
                        <input type="number" step="0.001" name="cubic_inch" class="form-control bg-light" value="0" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Cubic mm volume</label>
                        <input type="number" step="0.001" name="cubic_mm" class="form-control bg-light" value="0" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Weight LB</label>
                        <input type="number" step="0.001" name="weight_lb" class="form-control bg-light" value="0" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Weight KG</label>
                        <input type="number" step="0.001" name="weight_kg_calc" class="form-control bg-light" value="0" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTINUE TO NEXT SECTION BUTTON --}}
    <div class="card">
        <div class="card-footer text-right">
            <button type="button" class="btn btn-primary btn-lg" onclick="showProcesses()">
                Continue to Processes <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </div>

</form>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4'
    });

    // Shape change handler
    $('#shapeSelect').on('change', function() {
        if ($(this).val() === 'width_length_height') {
            $('#dimensionFields').slideDown();
        } else {
            $('#dimensionFields').slideUp();
        }
    });
});

function showProcesses() {
    alert('Processes section coming next!');
}
</script>
@endpush