@extends('layouts.app')

@section('title', 'CNC Quote & Order')
@section('page-title', 'CNC Quote & Order')

@section('content')

<form id="quoteForm" method="POST" action="#" enctype="multipart/form-data">
    @csrf

    <div class="row">
        {{-- FULL WIDTH COLUMN (No more right sidebar) --}}
        <div class="col-md-12">
            
            {{-- CUSTOMER & BASIC INFO --}}
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Select Customer</label>
                                <select name="customer_id" class="form-control select2">
                                    <option value="">Select Customer</option>
                                    <option value="1">Company One</option>
                                    <option value="2">ABC Manufacturing</option>
                                </select>
                            </div>
                        </div>
     <div class="col-md-4">
                            <div class="form-group">
                                <label>Temp Customer</label><br>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="temp_customer">
                                    <label class="custom-control-label" for="temp_customer">Temp Customer</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Ship To / Bill To Address Cards --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div style="border:1px solid rgba(0,0,0,.08);border-radius:.5rem;padding:12px;background:#fff;min-height:100px;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div style="width:100%">
                                        <div style="font-size:11px;letter-spacing:.6px;font-weight:700;text-transform:uppercase;color:#6c757d;">Ship To</div>
                                        <div id="ship_preview" style="white-space:pre-line;font-size:13px;margin-top:6px;line-height:1.4;color:#333;">—</div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" title="Edit Ship To">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="ship_address_id" id="ship_address_id">
                        </div>
                        <div class="col-md-4">
                            <div style="border:1px solid rgba(0,0,0,.08);border-radius:.5rem;padding:12px;background:#fff;min-height:100px;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div style="width:100%">
                                        <div style="font-size:11px;letter-spacing:.6px;font-weight:700;text-transform:uppercase;color:#6c757d;">Bill To</div>
                                        <div id="bill_preview" style="white-space:pre-line;font-size:13px;margin-top:6px;line-height:1.4;color:#333;">—</div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" title="Edit Bill To">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="bill_address_id" id="bill_address_id">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Manufacturing Method</label>
                                <select name="manufacturing_method" class="form-control">
                                    <option value="">Select</option>
                                    <option value="manufacture_in_house">Manufacture in house</option>
                                    <option value="farm_out">Farm out</option>
                                    <option value="toll">Toll</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Customer Part # Alias</label>
                                <input type="text" name="customer_part_alias" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cage Number</label>
                                <input type="text" name="cage_number" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Type</label>
                                <select name="type" class="form-control">
                                    <option value="">Select</option>
                                    <option value="quote">Quote</option>
                                    <option value="job">Job Order</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Order/Quote #</label>
                                <input type="text" name="quote_number" class="form-control" value="0216202600027" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Unit</label>
                                <select name="unit" class="form-control">
                                    <option value="">Select</option>
                                    <option value="mm">Millimeters (mm)</option>
                                    <option value="inch">Inches (in)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Setup Price</label>
                                <select name="setup_price_type" class="form-control">
                                    <option value="not_charge">Not Charge</option>
                                    <option value="fixed">Fixed</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" step="0.01" name="setup_price" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quantity / Pieces</label>
                                <input type="number" name="quantity" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ATTACHMENTS (Moved here - under customer section, full width) --}}
            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Attachments</h6>
                    <small class="text-muted">Drawings / Photos (Drag & Drop)</small>
                </div>
                <div class="card-body text-center">
                    <p class="text-muted">Drag files here to upload</p>
                    <input type="file" name="attachments[]" multiple class="d-none" id="fileInput">
                    <button type="button" class="btn btn-sm btn-secondary" onclick="$('#fileInput').click()">
                        <i class="fas fa-upload"></i> Browse
                    </button>
                </div>
            </div>

            {{-- SHAPE SECTION --}}
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Shape</label>
                                <select name="shape" class="form-control" id="shapeSelect">
                                    <option value="">Select</option>
                                    <option value="round">Round</option>
                                    <option value="square">Square</option>
                                    <option value="hexagon">Hexagon</option>
                                    <option value="width_length_height">width x length x height</option>
                                </select>
                            </div>
                        </div>

                        {{-- Pin Size Diameter: shown for round, square, hexagonal ONLY --}}
                        <div class="col-md-3" id="pinDiameterField">
                            <div class="form-group">
                                <label>Pin Size Diameter</label>
                                <input type="number" step="0.001" name="pin_diameter" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Diameter Adjustment</label>
                                <input type="number" step="0.001" name="diameter_adjustment" class="form-control" value="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MATERIAL SECTION --}}
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Material Type</label>
                                <select name="material_type" class="form-control">
                                    <option value="metal_alloy">Metal Alloy</option>
                                    <option value="plastic">Plastic</option>
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
                                <input type="number" step="0.01" name="pin_length" class="form-control">
                            </div>
                        </div>
                    </div>

                    {{-- WIDTH × LENGTH × HEIGHT (Only visible when shape = width_length_height) --}}
                    <div id="wlhFields" style="display: none;">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Width</label>
                                    <input type="number" step="0.001" name="width" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Length</label>
                                    <input type="number" step="0.001" name="length" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Height</label>
                                    <input type="number" step="0.001" name="height" class="form-control">
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
                </div>
            </div>

            {{-- PROCESSES SECTION --}}
        <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Processes</h5>
                </div>
                <div class="card-body">

                    {{-- ══════ MACHINE (Always Open) ══════ --}}
                 <div id="machineSection" class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0"><i class="fas fa-industry text-dark"></i> Machine</h6>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-dark" onclick="addMachineRow()"><i class="fas fa-plus"></i> Add Row</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="$('#machineSection').slideUp(200)"><i class="fas fa-times"></i> Close</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="40">#</th>
                                        <th>Machine</th>
                                        <th>Labor Mode</th>
                                        <th>Utilization</th>
                                        <th>Material</th>
                                        <th>Complexity</th>
                                        <th>Priority</th>
                                        <th width="80">Time</th>
                                        <th width="90">Sub Total</th>
                                        <th width="50">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="machineTableBody">
                                    <tr><td colspan="10" class="text-center text-muted">No machines added</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ══════ OPERATION (Always Open) ══════ --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0"><i class="fas fa-cogs text-primary"></i> Operation</h6>
        <div>
            <span class="badge badge-primary mr-2" style="font-size:14px;">$0.00</span>
            <button type="button" class="btn btn-sm btn-primary" onclick="addOperationRow()"><i class="fas fa-plus"></i> Add Operation</button>
        </div>
    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Operation</th>
                                    <th>Process</th>
                                    <th>Time</th>
                                    <th>Rate</th>
                                    <th>Sub Total</th>
                                    <th width="60">Action</th>
                                </tr>
                            </thead>
                            <tbody id="operationTableBody">
                                <tr><td colspan="6" class="text-center text-muted">No operations</td></tr>
                            </tbody>
                            <tfoot class="thead-light">
                                <tr>
                                    <th colspan="4" class="text-right">Operation Total:</th>
                                    <th>$0.00</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{-- ══════ ITEMS (Always Open) ══════ --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0"><i class="fas fa-cube text-info"></i> Items</h6>
        <div>
            <span class="badge badge-info mr-2" style="font-size:14px;">$0.00</span>
            <button type="button" class="btn btn-sm btn-info" onclick="addItemRow()"><i class="fas fa-plus"></i> Add Item</button>
        </div>
    </div>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Select Item</th>
                                    <th>Qty</th>
                                    <th>Rate</th>
                                    <th>Sub Total</th>
                                    <th width="60">Action</th>
                                </tr>
                            </thead>
                            <tbody id="itemsTableBody">
                                <tr><td colspan="5" class="text-center text-muted">No items</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    {{-- ══════ HORIZONTAL BUTTON BAR ══════ --}}
                    <div class="mb-3">
                            <button type="button" class="btn btn-outline-dark btn-sm" onclick="$('#machineSection').slideToggle(200)">
                            <i class="fas fa-industry"></i> Machine
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="$('#holesPanel').slideToggle(200)">
                            <i class="fas fa-circle"></i> Holes
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="$('#tapsPanel').slideToggle(200)">
                            <i class="fas fa-screwdriver"></i> Taps
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" style="border-color:#6f42c1;color:#6f42c1;" onclick="$('#threadsPanel').slideToggle(200)">
                            <i class="fas fa-spinner"></i> Threads
                        </button>
                        <button type="button" class="btn btn-outline-warning btn-sm" onclick="$('#secondaryPanel').slideToggle(200)">
                            <i class="fas fa-wrench"></i> Secondary Ops
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="$('#platingPanel').slideToggle(200)">
                            <i class="fas fa-fire"></i> Plating & Heat
                        </button>
                    </div>

                    {{-- ══════ HOLES (Hidden, opens on click) ══════ --}}
                    <div id="holesPanel" style="display:none;" class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0"><i class="fas fa-circle text-success"></i> Holes</h6>
                        <div>
                            <span class="badge badge-success mr-2" style="font-size:14px;">$0.00</span>
                            <button type="button" class="btn btn-sm btn-success" onclick="addHoleRow()"><i class="fas fa-plus"></i> Add Hole</button>
                        </div>
                    </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="80">ID</th>
                                        <th>Quantity</th>
                                        <th>Drilling Method</th>
                                        <th>Hole Size</th>
                                        <th>Tolerance</th>
                                        <th>Depth</th>
                                        <th>Hole Price</th>
                                        <th>Chamfer</th>
                                        <th>Chamfer Size</th>
                                        <th>Chamfer Price</th>
                                        <th>Debur</th>
                                        <th>Debur Size</th>
                                        <th>Debur Price</th>
                                        <th>Hole Sub Total</th>
                                        <th width="60">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="holesTableBody">
                                    <tr><td colspan="14" class="text-center text-muted">No holes</td></tr>
                                </tbody>
                                <tfoot class="thead-light">
                                    <tr>
                                        <th colspan="13" class="text-right">Hole Total:</th>
                                        <th>$0</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- ══════ TAPS (Hidden, opens on click) ══════ --}}
                    <div id="tapsPanel" style="display:none;" class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0"><i class="fas fa-screwdriver text-danger"></i> Taps</h6>
        <div>
            <span class="badge badge-danger mr-2" style="font-size:14px;">$0.00</span>
            <button type="button" class="btn btn-sm btn-danger" onclick="addTapRow()"><i class="fas fa-plus"></i> Add Tap</button>
        </div>
    </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="80">ID</th>
                                        <th>Select Tapped</th>
                                        <th>Tap Price</th>
                                        <th>Thread Option</th>
                                        <th>Thread Price</th>
                                        <th>Direction</th>
                                        <th>Thread Size</th>
                                        <th>Base Price</th>
                                        <th>Chamfer</th>
                                        <th>Chamfer Price</th>
                                        <th>Debur Price</th>
                                        <th width="60">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tapsTableBody">
                                    <tr><td colspan="12" class="text-center text-muted">No taps</td></tr>
                                </tbody>
                                <tfoot class="thead-light">
                                    <tr>
                                        <th colspan="10" class="text-right">Tap Total:</th>
                                        <th>$0</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- ══════ THREADS (Hidden, opens on click) ══════ --}}
                    <div id="threadsPanel" style="display:none;" class="mb-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0"><i class="fas fa-spinner" style="color:#6f42c1;"></i> Threads</h6>
        <div>
            <span class="badge mr-2" style="background:#6f42c1;color:#fff;font-size:14px;">$0.00</span>
            <button type="button" class="btn btn-sm" style="background:#6f42c1;color:#fff;" onclick="addThreadRow()"><i class="fas fa-plus"></i> Add Thread</button>
        </div>
    </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Thread Type</th>
                                        <th>Thread Price</th>
                                        <th>Processed Place</th>
                                        <th>Option</th>
                                        <th>Thread Price</th>
                                        <th>Direction</th>
                                        <th>Thread Size</th>
                                        <th>Base Price</th>
                                        <th>Class Price</th>
                                        <th width="60">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="threadsTableBody">
                                    <tr><td colspan="11" class="text-center text-muted">No threads</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ══════ SECONDARY (Hidden, opens on click) ══════ --}}
                    <div id="secondaryPanel" style="display:none;" class="mb-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0"><i class="fas fa-wrench text-warning"></i> Secondary Operations</h6>
        <div>
            <span class="badge badge-warning mr-2" style="font-size:14px;">$0.00</span>
            <button type="button" class="btn btn-sm btn-warning" onclick="addSecondaryRow()"><i class="fas fa-plus"></i> Add Secondary</button>
        </div>
    </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Secondary Operation</th>
                                        <th>Price Type</th>
                                        <th>Percentage</th>
                                        <th>Price</th>
                                        <th width="60">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="secondaryTableBody">
                                    <tr><td colspan="5" class="text-center text-muted">No secondary operations</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ══════ PLATING & HEAT (Hidden, opens on click) ══════ --}}
                    <div id="platingPanel" style="display:none;" class="mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-paint-brush"></i> Plating & Heat Treating
                            <small class="text-muted">Vendors, lot charge, per-pound, certs</small>
                        </h6>
                        
                        {{-- PLATING SECTION --}}
                        <div class="border rounded p-3 mb-3 bg-light">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Plating Vendor</label>
                                    <div class="input-group input-group-sm">
                                        <select class="form-control">
                                            <option>Select Vendor</option>
                                            <option>Vendor A</option>
                                            <option>Vendor B</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-warning" type="button"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Plating / Coating</label>
                                    <select class="form-control form-control-sm">
                                        <option>Select Plating / Coating</option>
                                        <option>Zinc Plating</option>
                                        <option>Chrome Plating</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Pricing Type</label>
                                    <select class="form-control form-control-sm" id="platingPricingType" onchange="togglePlatingFields()">
                                        <option value="per_each">Per Each</option>
                                        <option value="per_pound">Per Pound</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3" id="platingPerEachFields">
                                <div class="col-md-3">
                                    <label>Count (pcs)</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">pcs</span></div>
                                        <input type="number" class="form-control" placeholder="e.g. 120">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Price Each</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                        <input type="number" step="0.01" class="form-control" placeholder="e.g. 2">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3" id="platingPerPoundFields" style="display: none;">
                                <div class="col-md-3">
                                    <label>Plating Total Pound</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                        <input type="number" step="0.01" class="form-control" placeholder="e.g. 2">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Lot Charge (first 100 lbs)</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                        <input type="number" step="0.01" class="form-control" placeholder="e.g. 80">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Per Pound Price (after 100 lbs)</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                        <input type="number" step="0.01" class="form-control" placeholder="e.g. 2">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label>Salt Testing</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                        <input type="number" step="0.01" class="form-control" placeholder="e.g. 5">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Surcharge</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                        <input type="number" step="0.01" class="form-control" placeholder="e.g. 10">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Plating Price</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                        <input type="number" step="0.01" class="form-control bg-light" value="0" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Standards /Specifications</label>
                                    <select class="form-control form-control-sm">
                                        <option>Select Standards /Specifi</option>
                                        <option>ASTM A123</option>
                                        <option>ASTM B633</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Standards /Specifications Price</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                        <input type="number" step="0.01" class="form-control" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- HEAT TREATING SECTION --}}
                        <div class="border rounded p-3 bg-light">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Heat Treating Vendor</label>
                                    <div class="input-group input-group-sm">
                                        <select class="form-control">
                                            <option>Select Vendor</option>
                                            <option>Vendor C</option>
                                            <option>Vendor D</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-warning" type="button"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Heat Treating</label>
                                    <select class="form-control form-control-sm">
                                        <option>Select Heat Treating</option>
                                        <option>Annealing</option>
                                        <option>Hardening</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Pricing Type</label>
                                    <select class="form-control form-control-sm" id="heatPricingType" onchange="toggleHeatFields()">
                                        <option value="per_each">Per Each</option>
                                        <option value="per_pound">Per Pound</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3" id="heatPerEachFields">
                                <div class="col-md-3">
                                    <label>Count (pcs)</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">pcs</span></div>
                                        <input type="number" class="form-control" placeholder="e.g. 120">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Price Each</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                        <input type="number" step="0.01" class="form-control" placeholder="e.g. 2">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3" id="heatPerPoundFields" style="display: none;">
                                <div class="col-md-3">
                                    <label>Heat Total Pound</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                        <input type="number" step="0.01" class="form-control" placeholder="e.g. 2">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Lot Charge (first 100 lbs)</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                        <input type="number" step="0.01" class="form-control" placeholder="e.g. 80">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Per Pound Price (after 100 lbs)</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                        <input type="number" step="0.01" class="form-control" placeholder="e.g. 2">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label>Testing & Certs</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                        <input type="number" step="0.01" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Surcharge</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                        <input type="number" step="0.01" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Heat Treating Price</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                        <input type="number" step="0.01" class="form-control bg-light" value="0" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- BOTTOM SECTION --}}
            <div class="card">
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
                                <label>Part Number</label>
                                <input type="text" name="part_number" class="form-control" placeholder="e.g., TH-001">
                            </div>
                        </div>
                    </div>

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
                                <input type="date" name="due_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Lead Time (Start)</label>
                                <input type="date" name="lead_time_start" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Lead Time (End)</label>
                                <input type="date" name="lead_time_end" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Special Engineer Notes</label>
                        <textarea name="engineer_notes" class="form-control" rows="3" placeholder="Anything the shop should know?"></textarea>
                    </div>
                </div>
            </div>

            {{-- LIVE COST SUMMARY --}}
            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Live Cost Summary</h6>
                    <small class="text-muted">Auto-updates as you edit</small>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Component</th>
                                <th class="text-right">Each</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Material</td>
                                <td class="text-right">$0.00</td>
                                <td class="text-right">$0.00</td>
                            </tr>
                            <tr>
                                <td>Operation</td>
                                <td class="text-right">$0.00</td>
                                <td class="text-right">$0.00</td>
                            </tr>
                            <tr>
                                <td>Items</td>
                                <td class="text-right">$0.00</td>
                                <td class="text-right">$0.00</td>
                            </tr>
                            <tr>
                                <td>Holes</td>
                                <td class="text-right">$0.00</td>
                                <td class="text-right">$0.00</td>
                            </tr>
                            <tr>
                                <td>Taps</td>
                                <td class="text-right">$0.00</td>
                                <td class="text-right">$0.00</td>
                            </tr>
                            <tr>
                                <td>Threads</td>
                                <td class="text-right">$0.00</td>
                                <td class="text-right">$0.00</td>
                            </tr>
                            <tr>
                                <td>Plating / Coating</td>
                                <td class="text-right">$0.00</td>
                                <td class="text-right">$0.00</td>
                            </tr>
                            <tr>
                                <td>Standards / Specifications (ASTM)</td>
                                <td class="text-right">$0.00</td>
                                <td class="text-right">$0.00</td>
                            </tr>
                            <tr>
                                <td>Heat Treat</td>
                                <td class="text-right">$0.00</td>
                                <td class="text-right">$0.00</td>
                            </tr>
                            <tr>
                                <td>Secondary Operations</td>
                                <td class="text-right">$0.00</td>
                                <td class="text-right">$0.00</td>
                            </tr>
                            <tr>
                                <td>Break-In Charge</td>
                                <td class="text-right">$0.00</td>
                                <td class="text-right">$0.00</td>
                            </tr>
                            <tr class="table-active">
                                <th>GRAND TOTAL</th>
                                <th class="text-right">$0.00</th>
                                <th class="text-right">$0.00</th>
                            </tr>
                        </tbody>
                    </table>
                    <div class="p-2">
                        <small class="text-muted"><em>If "Override Price" is set, it replaces the Grand Total.</em></small>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- SUBMIT BUTTONS --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Submit
                    </button>
                    <button type="button" class="btn btn-success">
                        <i class="fas fa-save"></i> Save As Template
                    </button>
                    <button type="button" class="btn btn-info">
                        <i class="fas fa-check"></i> Submit & Markup
                    </button>
                    <button type="button" class="btn btn-warning">
                        <i class="fas fa-flask"></i> Test Data
                    </button>
                    <button type="reset" class="btn btn-danger">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>

@endsection

@push('styles')
<style>
.cursor-pointer {
    cursor: pointer;
}
.cursor-pointer:hover {
    background-color: #e9ecef !important;
}
</style>
@endpush
@push('scripts')
<script>
$(document).ready(function() {
    $('.select2').select2({ theme: 'bootstrap4' });
});

// ✅ SHAPE TOGGLE - Using vanilla JS (works immediately)
function toggleShapeFields() {
    var shape = document.getElementById('shapeSelect').value;
    var isWLH = (shape === 'width_length_height');
    
    // WLH fields: show for "width_length_height", hide for others
    document.getElementById('wlhFields').style.display = isWLH ? '' : 'none';
    
    // Pin Size Diameter: hide for WLH, show for round/square/hexagon
    document.getElementById('pinDiameterField').style.display = isWLH ? 'none' : '';
}

// Bind and run on load
document.getElementById('shapeSelect').addEventListener('change', toggleShapeFields);
document.addEventListener('DOMContentLoaded', toggleShapeFields);

// Toggle Plating Pricing Type Fields
function togglePlatingFields() {
    var type = document.getElementById('platingPricingType').value;
    document.getElementById('platingPerEachFields').style.display = (type === 'per_pound') ? 'none' : '';
    document.getElementById('platingPerPoundFields').style.display = (type === 'per_pound') ? '' : 'none';
}

// Toggle Heat Pricing Type Fields
function toggleHeatFields() {
    var type = document.getElementById('heatPricingType').value;
    document.getElementById('heatPerEachFields').style.display = (type === 'per_pound') ? 'none' : '';
    document.getElementById('heatPerPoundFields').style.display = (type === 'per_pound') ? '' : 'none';
}

// ── Helper: clear "No rows" placeholder ──
function clearEmpty(tbodyId) {
    var $t = $('#' + tbodyId);
    if ($t.find('tr').length === 1 && $t.find('tr td').attr('colspan')) {
        $t.empty();
    }
}


// ── Add Machine Row ──
let machineRowCounter = 0;
function addMachineRow() {
    machineRowCounter++;
    clearEmpty('machineTableBody');
    $('#machineTableBody').append(`
        <tr>
            <td class="text-center align-middle">${machineRowCounter}</td>
            <td>
                <select name="machines[${machineRowCounter}][machine]" class="form-control form-control-sm">
                    <option value="">Select Mode</option>
                    <option value="cnc_lathe">CNC Lathe</option>
                    <option value="cnc_mill">CNC Mill</option>
                    <option value="manual_lathe">Manual Lathe</option>
                    <option value="manual_mill">Manual Mill</option>
                    <option value="grinder">Grinder</option>
                    <option value="drill_press">Drill Press</option>
                </select>
            </td>
            <td>
                <select name="machines[${machineRowCounter}][labor_mode]" class="form-control form-control-sm">
                    <option value="">Select Mode</option>
                    <option value="attended">Attended</option>
                    <option value="unattended">Unattended</option>
                    <option value="semi">Semi-Attended</option>
                </select>
            </td>
            <td>
                <select name="machines[${machineRowCounter}][utilization]" class="form-control form-control-sm">
                    <option value="">Select Level</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="full">Full</option>
                </select>
            </td>
            <td>
                <select name="machines[${machineRowCounter}][material]" class="form-control form-control-sm">
                    <option value="">Select Material</option>
                    <option value="steel">Steel</option>
                    <option value="aluminum">Aluminum</option>
                    <option value="brass">Brass</option>
                    <option value="stainless">Stainless Steel</option>
                    <option value="plastic">Plastic</option>
                </select>
            </td>
            <td>
                <select name="machines[${machineRowCounter}][complexity]" class="form-control form-control-sm">
                    <option value="">Select Complexity</option>
                    <option value="simple">Simple</option>
                    <option value="moderate">Moderate</option>
                    <option value="complex">Complex</option>
                    <option value="very_complex">Very Complex</option>
                </select>
            </td>
            <td>
                <select name="machines[${machineRowCounter}][priority]" class="form-control form-control-sm">
                    <option value="">Select Priority</option>
                    <option value="normal">Normal</option>
                    <option value="rush">Rush</option>
                    <option value="urgent">Urgent</option>
                </select>
            </td>
            <td><input type="number" step="0.01" name="machines[${machineRowCounter}][time]" class="form-control form-control-sm" value="0.00"></td>
            <td><input type="number" step="0.01" name="machines[${machineRowCounter}][sub_total]" class="form-control form-control-sm bg-light" value="0.00" readonly></td>
            <td class="text-center">
                <button type="button" class="btn btn-xs btn-danger" onclick="removeMachineRow(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `);
}

function removeMachineRow(btn) {
    $(btn).closest('tr').remove();
    // Re-number rows
    $('#machineTableBody tr').each(function(i) {
        $(this).find('td:first').text(i + 1);
    });
    machineRowCounter = $('#machineTableBody tr').length;
    if (machineRowCounter === 0) {
        $('#machineTableBody').html('<tr><td colspan="10" class="text-center text-muted">No machines added</td></tr>');
        machineRowCounter = 0;
    }
}

// ── Add Operation Row ──
let operationRowCounter = 0;
function addOperationRow() {
    operationRowCounter++;
    clearEmpty('operationTableBody');
    $('#operationTableBody').append(`
        <tr>
            <td>
                <select name="operations[${operationRowCounter}][operation]" class="form-control form-control-sm">
                    <option value="">Select Operation</option>
                    <option value="face">Face</option>
                    <option value="drill">Drill</option>
                </select>
            </td>
            <td>
                <select name="operations[${operationRowCounter}][labour]" class="form-control form-control-sm">
                    <option value="">Select Labour</option>
                    <option value="manual">Engineer</option>
                    <option value="cnc">Operator</option>
                </select>
            </td>
            <td><input type="number" step="0.01" class="form-control form-control-sm" value="0.00"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm" value="0.00"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" value="0.00" readonly></td>
            <td><button type="button" class="btn btn-xs btn-danger" onclick="$(this).closest('tr').remove()"><i class="fas fa-trash"></i></button></td>
        </tr>
    `);
}

// ── Add Item Row ──
let itemRowCounter = 0;
function addItemRow() {
    itemRowCounter++;
    clearEmpty('itemsTableBody');
    $('#itemsTableBody').append(`
        <tr>
            <td>
                <select name="items[${itemRowCounter}][item_id]" class="form-control form-control-sm">
                    <option value="">Select Item</option>
                    <option value="1">Cutting Tool</option>
                    <option value="2">Drill Bit</option>
                    <option value="3">End Mill</option>
                </select>
            </td>
            <td><input type="number" class="form-control form-control-sm" value="1"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm" value="0.00"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" value="0.00" readonly></td>
            <td><button type="button" class="btn btn-xs btn-danger" onclick="$(this).closest('tr').remove()"><i class="fas fa-trash"></i></button></td>
        </tr>
    `);
}

// ── Add Hole Row ──
let holeRowCounter = 0;
function addHoleRow() {
    holeRowCounter++;
    clearEmpty('holesTableBody');
    $('#holesTableBody').append(`
        <tr>
            <td><input type="text" class="form-control form-control-sm" placeholder="ID"></td>
            <td><input type="text" class="form-control form-control-sm bg-light" readonly value=""></td>
            <td><select class="form-control form-control-sm"><option value="">Select</option><option value="1">Drill</option> <option value="2">Ream</option><option value="2">Bore</option></select></td>
            <td><input type="text" class="form-control form-control-sm bg-light" readonly value=""></td>
            <td><input type="text" class="form-control form-control-sm bg-light" readonly value=""></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value=""></td>
            <td><select class="form-control form-control-sm"><option value="">Select</option><option value="1">0.5mm × 45°</option></select></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="0"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="0"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="0"></td>
            <td><select class="form-control form-control-sm"><option value="">Select</option><option value="1">Standard</option></select></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="0"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="0"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="0"></td>
            <td><button type="button" class="btn btn-xs btn-danger" onclick="$(this).closest('tr').remove()"><i class="fas fa-trash"></i></button></td>
        </tr>
    `);
}

// ── Add Tap Row ──
let tapRowCounter = 0;
function addTapRow() {
    tapRowCounter++;
    clearEmpty('tapsTableBody');
    $('#tapsTableBody').append(`
        <tr>
            <td><input type="text" class="form-control form-control-sm" placeholder="ID"></td>
            <td><select class="form-control form-control-sm"><option value="">Select</option><option value="1">M6×1.0 Tap</option></select></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="11.00"></td>
            <td><select class="form-control form-control-sm"><option value="internal">Internal</option><option value="external">External</option></select></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm bg-light" readonly value="2.50"></td>
            <td><select class="form-control form-control-sm"><option value="right">Right</option><option value="left">Left</option></select></td>
            <td><input type="text" class="form-control form-control-sm" placeholder="M6×1.0"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm" value="0"></td>
            <td><input type="text" class="form-control form-control-sm" placeholder="Chamfer"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm" value="0"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm" value="0"></td>
            <td><button type="button" class="btn btn-xs btn-danger" onclick="$(this).closest('tr').remove()"><i class="fas fa-trash"></i></button></td>
        </tr>
    `);
}

// ── Add Thread Row ──
let threadRowCounter = 0;
function addThreadRow() {
    threadRowCounter++;
    clearEmpty('threadsTableBody');
    $('#threadsTableBody').append(`
        <tr>
            <td><input type="text" class="form-control form-control-sm" placeholder="ID"></td>
            <td><select class="form-control form-control-sm"><option value="external">External</option><option value="internal">Internal</option></select></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm" value="0"></td>
            <td><input type="text" class="form-control form-control-sm" placeholder="Place"></td>
            <td><input type="text" class="form-control form-control-sm" placeholder="Option"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm" value="0"></td>
            <td><select class="form-control form-control-sm"><option value="right">Right</option><option value="left">Left</option></select></td>
            <td><input type="text" class="form-control form-control-sm" placeholder="Size"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm" value="0"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm" value="0"></td>
            <td><button type="button" class="btn btn-xs btn-danger" onclick="$(this).closest('tr').remove()"><i class="fas fa-trash"></i></button></td>
        </tr>
    `);
}

// ── Add Secondary Row ──
let secondaryRowCounter = 0;
function addSecondaryRow() {
    secondaryRowCounter++;
    clearEmpty('secondaryTableBody');
    $('#secondaryTableBody').append(`
        <tr>
            <td><input type="text" class="form-control form-control-sm" placeholder="e.g., Plating / Vendors"></td>
            <td><select class="form-control form-control-sm"><option value="lot">Lot</option><option value="piece">Per Piece</option></select></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm" value="0"></td>
            <td><input type="number" step="0.01" class="form-control form-control-sm" value="0"></td>
            <td><button type="button" class="btn btn-xs btn-danger" onclick="$(this).closest('tr').remove()"><i class="fas fa-trash"></i></button></td>
        </tr>
    `);
}
</script>
@endpush