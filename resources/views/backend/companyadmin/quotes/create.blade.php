@extends('layouts.app')

@section('title', 'Create Quote/Job')
@section('page-title', 'New Quote / Job Order')

@section('content')

<form id="quoteForm" method="POST" action="#" enctype="multipart/form-data">
    @csrf

    {{-- CUSTOMER SECTION --}}
    <div class="card">
        <div class="card-header bg-white">
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
    <div class="card">
        <div class="card-header bg-white">
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
                <button type="button" class="btn btn-secondary" onclick="$('#fileInput').click()">
                    <i class="fas fa-upload"></i> Browse Files
                </button>
            </div>
        </div>
    </div>

    {{-- MATERIAL SECTION --}}
    <div class="card">
        <div class="card-header bg-white">
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
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Cubic inch volume</label>
                        <input type="number" step="0.001" name="cubic_inch" class="form-control bg-light" value="0" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Cubic mm volume</label>
                        <input type="number" step="0.001" name="cubic_mm" class="form-control bg-light" value="0" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Weight LB</label>
                        <input type="number" step="0.001" name="weight_lb" class="form-control bg-light" value="0" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Weight KG</label>
                        <input type="number" step="0.001" name="weight_kg_calc" class="form-control bg-light" value="0" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ADD PROCESS BUTTONS SECTION --}}
    <div class="card">
        <div class="card-header bg-white">
            <h3 class="card-title">
                <i class="fas fa-tools"></i> Add Process Components
            </h3>
        </div>
        <div class="card-body">
            <p class="text-muted mb-3 text-center">Click a button below to add process rows:</p>
            
            <div class="row">
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-secondary btn-block btn-lg" onclick="showSection('machine')">
                        <i class="fas fa-industry fa-2x d-block mb-2"></i>
                        <span class="d-block">Machine</span>
                    </button>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-secondary btn-block btn-lg" onclick="showSection('operation')">
                        <i class="fas fa-cogs fa-2x d-block mb-2"></i>
                        <span class="d-block">Operation</span>
                    </button>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-secondary btn-block btn-lg" onclick="showSection('item')">
                        <i class="fas fa-cube fa-2x d-block mb-2"></i>
                        <span class="d-block">Item</span>
                    </button>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-secondary btn-block btn-lg" onclick="showSection('hole')">
                        <i class="fas fa-circle fa-2x d-block mb-2"></i>
                        <span class="d-block">Hole</span>
                    </button>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-secondary btn-block btn-lg" onclick="showSection('tap')">
                        <i class="fas fa-screwdriver fa-2x d-block mb-2"></i>
                        <span class="d-block">Tap</span>
                    </button>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-secondary btn-block btn-lg" onclick="showSection('thread')">
                        <i class="fas fa-spinner fa-2x d-block mb-2"></i>
                        <span class="d-block">Thread</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- MACHINE SECTION (Hidden by default) --}}
    <div class="card" id="machineCard" style="display: none;">
        <div class="card-header bg-white">
            <h3 class="card-title">
                <i class="fas fa-industry"></i> Machine
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-default" onclick="addMachineRow()">
                    <i class="fas fa-plus"></i> Add Row
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="$('#machineCard').slideUp()">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="30">#</th>
                            <th>Machine</th>
                            <th>Labor Mode</th>
                            <th>Utilization</th>
                            <th>Material</th>
                            <th>Complexity</th>
                            <th>Priority</th>
                            <th width="100">Time</th>
                            <th width="120">Sub Total</th>
                            <th width="60">Action</th>
                        </tr>
                    </thead>
                    <tbody id="machineTableBody">
                        <tr>
                            <td colspan="10" class="text-center text-muted py-3">
                                No machines added. Click "Add Row" to add.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- OPERATION SECTION (Hidden by default) --}}
    <div class="card" id="operationCard" style="display: none;">
        <div class="card-header bg-white">
            <h3 class="card-title">
                <i class="fas fa-cogs"></i> Operation
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-default" onclick="addOperationRow()">
                    <i class="fas fa-plus"></i> Add Row
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="$('#operationCard').slideUp()">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="30">#</th>
                            <th>Operation</th>
                            <th>Labor Level</th>
                            <th width="100">Time</th>
                            <th width="100">Rate</th>
                            <th width="100">Rate</th>
                            <th width="120">Sub Total</th>
                            <th width="60">Action</th>
                        </tr>
                    </thead>
                    <tbody id="operationTableBody">
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">
                                No operations added. Click "Add Row" to add.
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="thead-light">
                        <tr>
                            <th colspan="6" class="text-right">Operation Total:</th>
                            <th>$0.00</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- ITEMS SECTION (Hidden by default) --}}
    <div class="card" id="itemCard" style="display: none;">
        <div class="card-header bg-white">
            <h3 class="card-title">
                <i class="fas fa-cube"></i> Items
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-default" onclick="addItemRow()">
                    <i class="fas fa-plus"></i> Add Row
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="$('#itemCard').slideUp()">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="30">#</th>
                            <th>Item Name</th>
                            <th width="120">Quantity</th>
                            <th width="120">Unit Price</th>
                            <th width="120">Sub Total</th>
                            <th width="60">Action</th>
                        </tr>
                    </thead>
                    <tbody id="itemsTableBody">
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                No items added. Click "Add Row" to add.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- HOLES SECTION (Hidden by default) --}}
    <div class="card" id="holesCard" style="display: none;">
        <div class="card-header bg-white">
            <h3 class="card-title">
                <i class="fas fa-circle"></i> Holes
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-default" onclick="addHoleRow()">
                    <i class="fas fa-plus"></i> Add Row
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="$('#holesCard').slideUp()">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="30">#</th>
                            <th>Select Hole</th>
                            <th width="100">Hole Size</th>
                            <th width="100">Hole Price</th>
                            <th>Chamfer</th>
                            <th width="100">Chamfer Price</th>
                            <th>Debur</th>
                            <th width="100">Debur Price</th>
                            <th width="100">Sub Total</th>
                            <th width="60">Action</th>
                        </tr>
                    </thead>
                    <tbody id="holesTableBody">
                        <tr>
                            <td colspan="10" class="text-center text-muted py-3">
                                No holes added. Click "Add Row" to add.
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="thead-light">
                        <tr>
                            <th colspan="8" class="text-right">Holes Total:</th>
                            <th>$0.00</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- TAPS SECTION (Hidden by default) --}}
    <div class="card" id="tapsCard" style="display: none;">
        <div class="card-header bg-white">
            <h3 class="card-title">
                <i class="fas fa-screwdriver"></i> Taps
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-default" onclick="addTapRow()">
                    <i class="fas fa-plus"></i> Add Row
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="$('#tapsCard').slideUp()">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="30">#</th>
                            <th>Select Tapped</th>
                            <th width="100">Tap Price</th>
                            <th>Thread Option</th>
                            <th width="100">Thread Price</th>
                            <th>Direction</th>
                            <th>Thread Size</th>
                            <th>Standard</th>
                            <th>Pitch</th>
                            <th>Class</th>
                            <th width="100">Sub Total</th>
                            <th width="60">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tapsTableBody">
                        <tr>
                            <td colspan="12" class="text-center text-muted py-3">
                                No taps added. Click "Add Row" to add.
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="thead-light">
                        <tr>
                            <th colspan="10" class="text-right">Taps Total:</th>
                            <th>$0.00</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- THREADS SECTION (Hidden by default) --}}
    <div class="card" id="threadsCard" style="display: none;">
        <div class="card-header bg-white">
            <h3 class="card-title">
                <i class="fas fa-spinner"></i> Threads
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-default" onclick="addThreadRow()">
                    <i class="fas fa-plus"></i> Add Row
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="$('#threadsCard').slideUp()">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="30">#</th>
                            <th>Thread Type</th>
                            <th>Select Thread</th>
                            <th width="100">Thread Price</th>
                            <th>Option</th>
                            <th>Thread Size</th>
                            <th>Standard</th>
                            <th>Pitch</th>
                            <th>Class</th>
                            <th>Direction</th>
                            <th width="100">Sub Total</th>
                            <th width="60">Action</th>
                        </tr>
                    </thead>
                    <tbody id="threadsTableBody">
                        <tr>
                            <td colspan="12" class="text-center text-muted py-3">
                                No threads added. Click "Add Row" to add.
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="thead-light">
                        <tr>
                            <th colspan="10" class="text-right">Threads Total:</th>
                            <th>$0.00</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- ADDITIONAL COSTS --}}
    <div class="card">
        <div class="card-header bg-white">
            <h3 class="card-title">
                <i class="fas fa-dollar-sign"></i> Additional Costs
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Break-In Charge</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" step="0.01" name="break_in_charge" class="form-control" value="0">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Override Price (Total)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" step="0.01" name="override_price" class="form-control" placeholder="Optional">
                        </div>
                        <small class="text-muted">If set, replaces Grand Total.</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Grand Each Price</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" step="0.01" name="grand_each_price" class="form-control" value="0">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Grand Total Price</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" step="0.01" name="grand_total_price" class="form-control bg-light" value="0" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Part Number</label>
                        <input type="text" name="part_number" class="form-control" placeholder="e.g., TH-001">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- DATES & NOTES --}}
    <div class="card">
        <div class="card-header bg-white">
            <h3 class="card-title">
                <i class="fas fa-calendar"></i> Dates & Notes
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="quote_date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Due Date</label>
                        <input type="date" name="due_date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Lead Time (Start)</label>
                        <input type="date" name="lead_time_start" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Lead Time (End)</label>
                        <input type="date" name="lead_time_end" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Special Engineer Notes</label>
                <textarea name="engineer_notes" class="form-control" rows="4" placeholder="Anything the shop should know?"></textarea>
            </div>
        </div>
    </div>

    {{-- SUBMIT BUTTONS --}}
    <div class="card">
        <div class="card-footer text-right bg-white">
            <button type="button" class="btn btn-primary btn-lg">
                <i class="fas fa-paper-plane"></i> Submit
            </button>
            <button type="button" class="btn btn-success btn-lg">
                <i class="fas fa-save"></i> Save As Template
            </button>
            <button type="button" class="btn btn-info btn-lg">
                <i class="fas fa-check"></i> Submit & Markup
            </button>
            <button type="button" class="btn btn-warning btn-lg">
                <i class="fas fa-flask"></i> Test Data
            </button>
            <button type="reset" class="btn btn-danger btn-lg">
                <i class="fas fa-redo"></i> Reset
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

// Show section
function showSection(section) {
    if (section === 'machine') {
        $('#machineCard').slideDown();
    } else if (section === 'operation') {
        $('#operationCard').slideDown();
    } else if (section === 'item') {
        $('#itemCard').slideDown();
    } else if (section === 'hole') {
        $('#holesCard').slideDown();
    } else if (section === 'tap') {
        $('#tapsCard').slideDown();
    } else if (section === 'thread') {
        $('#threadsCard').slideDown();
    }
}

// Add Machine Row
let machineRowCounter = 0;
function addMachineRow() {
    machineRowCounter++;
    const row = `
        <tr>
            <td>${machineRowCounter}</td>
            <td>
                <select name="machines[${machineRowCounter}][machine]" class="form-control form-control-sm">
                    <option value="">Select Mode</option>
                    <option value="cnc_mill">CNC Mill</option>
                    <option value="cnc_lathe">CNC Lathe</option>
                </select>
            </td>
            <td>
                <select name="machines[${machineRowCounter}][labor_mode]" class="form-control form-control-sm">
                    <option value="">Select Mode</option>
                    <option value="automatic">Automatic</option>
                    <option value="manual">Manual</option>
                </select>
            </td>
            <td>
                <select name="machines[${machineRowCounter}][utilization]" class="form-control form-control-sm">
                    <option value="">Select Level</option>
                    <option value="fully_automated">Fully Automated</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                </select>
            </td>
            <td>
                <select name="machines[${machineRowCounter}][material]" class="form-control form-control-sm">
                    <option value="">Select Material</option>
                    <option value="aluminum">Aluminum</option>
                    <option value="steel">Steel</option>
                </select>
            </td>
            <td>
                <select name="machines[${machineRowCounter}][complexity]" class="form-control form-control-sm">
                    <option value="">Select Complexity</option>
                    <option value="simple">Simple</option>
                    <option value="complex">Complex</option>
                </select>
            </td>
            <td>
                <select name="machines[${machineRowCounter}][priority]" class="form-control form-control-sm">
                    <option value="">Select Priority</option>
                    <option value="normal">Normal</option>
                    <option value="rush">Rush</option>
                </select>
            </td>
            <td><input type="number" step="0.01" name="machines[${machineRowCounter}][time]" class="form-control form-control-sm" value="0.00"></td>
            <td><input type="number" step="0.01" name="machines[${machineRowCounter}][subtotal]" class="form-control form-control-sm bg-light" value="0.00" readonly></td>
            <td>
                <button type="button" class="btn btn-xs btn-danger" onclick="$(this).closest('tr').remove()">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `;
    
    if ($('#machineTableBody tr').length === 1 && $('#machineTableBody tr td').attr('colspan')) {
        $('#machineTableBody').html(row);
    } else {
        $('#machineTableBody').append(row);
    }
}

// Add Operation Row
let operationRowCounter = 0;
function addOperationRow() {
    operationRowCounter++;
    const row = `
        <tr>
            <td>${operationRowCounter}</td>
            <td>
                <select name="operations[${operationRowCounter}][operation]" class="form-control form-control-sm">
                    <option value="">Select Operation</option>
                    <option value="face">Face</option>
                    <option value="rough_mill">Rough Mill</option>
                    <option value="finish_mill">Finish Mill</option>
                    <option value="drill">Drill</option>
                    <option value="tap">Tap</option>
                    <option value="bore">Bore</option>
                </select>
            </td>
            <td>
                <select name="operations[${operationRowCounter}][labor_level]" class="form-control form-control-sm">
                    <option value="">Select Labor Level</option>
                    <option value="basic_operator">Basic Operator</option>
                    <option value="skilled_operator">Skilled Operator</option>
                    <option value="setup_senior">Setup / Senior</option>
                    <option value="programmer">Programmer / Engineer</option>
                    <option value="quality">Quality</option>
                    <option value="engineering_review">Engineering Review</option>
                </select>
            </td>
            <td><input type="number" step="0.01" name="operations[${operationRowCounter}][time]" class="form-control form-control-sm" value="0.00"></td>
            <td><input type="number" step="0.01" name="operations[${operationRowCounter}][rate]" class="form-control form-control-sm" value="0.00"></td>
            <td><input type="number" step="0.01" name="operations[${operationRowCounter}][rate2]" class="form-control form-control-sm" value="0.00"></td>
            <td><input type="number" step="0.01" name="operations[${operationRowCounter}][subtotal]" class="form-control form-control-sm bg-light" value="0.00" readonly></td>
            <td>
                <button type="button" class="btn btn-xs btn-danger" onclick="$(this).closest('tr').remove()">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `;
    
    if ($('#operationTableBody tr').length === 1 && $('#operationTableBody tr td').attr('colspan')) {
        $('#operationTableBody').html(row);
    } else {
        $('#operationTableBody').append(row);
    }
}

// Add Item Row
let itemRowCounter = 0;
function addItemRow() {
    itemRowCounter++;
    const row = `
        <tr>
            <td>${itemRowCounter}</td>
            <td><input type="text" name="items[${itemRowCounter}][name]" class="form-control form-control-sm" placeholder="Item name"></td>
            <td><input type="number" step="1" name="items[${itemRowCounter}][quantity]" class="form-control form-control-sm" value="1"></td>
            <td><input type="number" step="0.01" name="items[${itemRowCounter}][unit_price]" class="form-control form-control-sm" value="0.00"></td>
            <td><input type="number" step="0.01" name="items[${itemRowCounter}][subtotal]" class="form-control form-control-sm bg-light" value="0.00" readonly></td>
            <td>
                <button type="button" class="btn btn-xs btn-danger" onclick="$(this).closest('tr').remove()">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `;
    
    if ($('#itemsTableBody tr').length === 1 && $('#itemsTableBody tr td').attr('colspan')) {
        $('#itemsTableBody').html(row);
    } else {
        $('#itemsTableBody').append(row);
    }
}

// Add Hole Row
let holeRowCounter = 0;
function addHoleRow() {
    holeRowCounter++;
    const row = `
        <tr>
            <td>${holeRowCounter}</td>
            <td>
                <select name="holes[${holeRowCounter}][hole_id]" class="form-control form-control-sm">
                    <option value="">Select Hole</option>
                    <option value="1">Ø5.0mm Through Hole</option>
                    <option value="2">Ø6.8mm Through Hole</option>
                    <option value="3">Ø8.5mm Through Hole</option>
                </select>
            </td>
            <td><input type="text" class="form-control form-control-sm bg-light" readonly value="5.0"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="3.50"></td>
            <td>
                <select name="holes[${holeRowCounter}][chamfer_id]" class="form-control form-control-sm">
                    <option value="">No Chamfer</option>
                    <option value="1">0.5mm × 45°</option>
                    <option value="2">1.0mm × 45°</option>
                </select>
            </td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="0"></td>
            <td>
                <select name="holes[${holeRowCounter}][debur_id]" class="form-control form-control-sm">
                    <option value="">No Debur</option>
                    <option value="1">Standard Debur</option>
                    <option value="2">Heavy Debur</option>
                </select>
            </td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="0"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="3.50"></td>
            <td>
                <button type="button" class="btn btn-xs btn-danger" onclick="$(this).closest('tr').remove()">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `;
    
    if ($('#holesTableBody tr').length === 1 && $('#holesTableBody tr td').attr('colspan')) {
        $('#holesTableBody').html(row);
    } else {
        $('#holesTableBody').append(row);
    }
}

// Add Tap Row
let tapRowCounter = 0;
function addTapRow() {
    tapRowCounter++;
    const row = `
        <tr>
            <td>${tapRowCounter}</td>
            <td>
                <select name="taps[${tapRowCounter}][tap_id]" class="form-control form-control-sm">
                    <option value="">Select Tap</option>
                    <option value="1">M6×1.0 Tap</option>
                    <option value="2">M8×1.25 Tap</option>
                    <option value="3">M10×1.5 Tap</option>
                </select>
            </td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="11.00"></td>
            <td>
                <select name="taps[${tapRowCounter}][thread_option]" class="form-control form-control-sm">
                    <option value="internal">Internal</option>
                    <option value="external">External</option>
                </select>
            </td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="2.50"></td>
            <td>
                <select name="taps[${tapRowCounter}][direction]" class="form-control form-control-sm">
                    <option value="right">Right-Hand</option>
                    <option value="left">Left-Hand</option>
                </select>
            </td>
            <td><input type="text" class="form-control form-control-sm" placeholder="M6×1.0"></td>
            <td><input type="text" class="form-control form-control-sm" placeholder="Metric"></td>
            <td><input type="text" class="form-control form-control-sm" placeholder="1.0"></td>
            <td><input type="text" class="form-control form-control-sm" placeholder="6H"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="13.50"></td>
            <td>
                <button type="button" class="btn btn-xs btn-danger" onclick="$(this).closest('tr').remove()">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `;
    
    if ($('#tapsTableBody tr').length === 1 && $('#tapsTableBody tr td').attr('colspan')) {
        $('#tapsTableBody').html(row);
    } else {
        $('#tapsTableBody').append(row);
    }
}

// Add Thread Row
let threadRowCounter = 0;
function addThreadRow() {
    threadRowCounter++;
    const row = `
        <tr>
            <td>${threadRowCounter}</td>
            <td>
                <select name="threads[${threadRowCounter}][thread_type]" class="form-control form-control-sm">
                    <option value="external">External</option>
                    <option value="internal">Internal</option>
                </select>
            </td>
            <td>
                <select name="threads[${threadRowCounter}][thread_id]" class="form-control form-control-sm">
                    <option value="">Select Thread</option>
                    <option value="1">M8×1.25 External</option>
                    <option value="2">M10×1.5 External</option>
                    <option value="3">M8×1.25 Internal</option>
                </select>
            </td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="6.00"></td>
            <td><input type="text" class="form-control form-control-sm" placeholder="Standard"></td>
            <td><input type="text" class="form-control form-control-sm" placeholder="M8×1.25"></td>
            <td><input type="text" class="form-control form-control-sm" placeholder="Metric"></td>
            <td><input type="text" class="form-control form-control-sm" placeholder="1.25"></td>
            <td><input type="text" class="form-control form-control-sm" placeholder="6g"></td>
            <td>
                <select name="threads[${threadRowCounter}][direction]" class="form-control form-control-sm">
                    <option value="right">Right-Hand</option>
                    <option value="left">Left-Hand</option>
                </select>
            </td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="6.00"></td>
            <td>
                <button type="button" class="btn btn-xs btn-danger" onclick="$(this).closest('tr').remove()">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `;
    
    if ($('#threadsTableBody tr').length === 1 && $('#threadsTableBody tr td').attr('colspan')) {
        $('#threadsTableBody').html(row);
    } else {
        $('#threadsTableBody').append(row);
    }
}
</script>
@endpush