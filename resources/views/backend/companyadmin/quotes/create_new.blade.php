@extends('layouts.app')

@section('page-title', 'Create Quote')

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('company.quotes.store') }}" method="POST" id="quoteForm" enctype="multipart/form-data">
            @csrf

            {{-- ═══ CARD 1: HEADER INFO ═══ --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-file-invoice mr-2"></i>Create Quote / Job Order</h3>
                        <a href="#" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">

                    {{-- Row 1: Type radios, Quote#, Mfg Method, Unit, Qty, Setup Price --}}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Type <span class="text-danger">*</span></label>
                                <div class="d-flex flex-wrap" style="gap:8px;">
                                    @foreach(['quote'=>'Quote','job_order'=>'Job Order','invoice'=>'Invoice'] as $val=>$lbl)
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="type_{{$val}}" name="type" value="{{$val}}"
                                               class="custom-control-input" {{ old('type','quote')==$val?'checked':'' }}>
                                        <label class="custom-control-label" for="type_{{$val}}">{{$lbl}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Quote # <span class="text-danger">*</span></label>
                                <input type="text" name="quote_number" class="form-control @error('quote_number') is-invalid @enderror"
                                       value="{{ old('quote_number', $quoteNumber) }}" readonly>
                                @error('quote_number')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Manufacturing Method <span class="text-danger">*</span></label>
                                <select name="manufacturing_method" class="form-control @error('manufacturing_method') is-invalid @enderror">
                                    <option value="manufacture_in_house" {{ old('manufacturing_method')=='manufacture_in_house'?'selected':'' }}>Manufacture In-House</option>
                                    <option value="outsource"            {{ old('manufacturing_method')=='outsource'?'selected':'' }}>Outsource</option>
                                    <option value="hybrid"               {{ old('manufacturing_method')=='hybrid'?'selected':'' }}>Hybrid</option>
                                </select>
                                @error('manufacturing_method')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Unit</label>
                                <select name="unit" id="globalUnit" class="form-control">
                                    <option value="inch" {{ old('unit','inch')=='inch'?'selected':'' }}>inch</option>
                                    <option value="mm"   {{ old('unit')=='mm'?'selected':'' }}>mm</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Qty <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" id="globalQty" class="form-control" value="{{ old('quantity',1) }}" min="1" onchange="recalcAll()">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Setup Price ($)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                    <input type="number" name="setup_price" step="0.01" class="form-control" value="{{ old('setup_price',0) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Row 2: Part#, Rev, Quote Date, Due Date, Valid Until --}}
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Part Number</label>
                                <input type="text" name="part_number" class="form-control" value="{{ old('part_number') }}" placeholder="P/N">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Rev</label>
                                <input type="text" name="revision" class="form-control" value="{{ old('revision') }}" placeholder="A">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Quote Date</label>
                                <input type="date" name="quote_date" class="form-control" value="{{ old('quote_date', date('Y-m-d')) }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Due Date</label>
                                <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valid Until</label>
                                <input type="date" name="valid_until" class="form-control" value="{{ old('valid_until') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ CARD 2: CUSTOMER & ADDRESSES ═══ --}}
            <div class="card">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-user mr-2"></i>Customer</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-1 d-flex align-items-center">
                            <div class="custom-control custom-switch mt-3">
                                <input type="checkbox" class="custom-control-input" id="isTempCustomer" onchange="toggleTempCustomer()">
                                <label class="custom-control-label" for="isTempCustomer"><small>Walk-in</small></label>
                            </div>
                        </div>
                        {{-- Existing customer --}}
                        <div class="col-md-4" id="customerSelectGroup">
                            <div class="form-group">
                                <label>Select Customer</label>
                                <select name="customer_id" id="customerSelect" class="form-control select2">
                                    <option value="">-- Select Customer --</option>
                                    @foreach($customers as $c)
                                        @php
                                            $ship = optional($c->defaultShippingAddress);
                                            $bill = optional($c->billingAddress);
                                            $shipStr = collect([$ship->street,$ship->city,$ship->state,$ship->zip])->filter()->implode(', ');
                                            $billStr = collect([$bill->street,$bill->city,$bill->state,$bill->zip])->filter()->implode(', ');
                                        @endphp
                                        <option value="{{ $c->id }}"
                                                data-ship="{{ $shipStr }}"
                                                data-bill="{{ $billStr }}"
                                                {{ old('customer_id')==$c->id?'selected':'' }}>
                                            {{ $c->name }} ({{ $c->customer_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- Walk-in fields --}}
                        <div class="col-md-5" id="tempCustomerFields" style="display:none;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" name="temp_customer_name" class="form-control" placeholder="Full name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="temp_customer_email" class="form-control" placeholder="email@...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="temp_customer_phone" class="form-control" placeholder="Phone">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Ship To / Bill To --}}
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Ship To</label>
                                        <textarea name="ship_to" id="shipTo" class="form-control" rows="2" placeholder="Shipping address...">{{ old('ship_to') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Bill To</label>
                                        <textarea name="bill_to" id="billTo" class="form-control" rows="2" placeholder="Billing address...">{{ old('bill_to') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ CARD 3: SHAPE & MATERIAL ═══ --}}
            <div class="card">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-cube mr-2"></i>Shape & Material</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Shape</label>
                                <select name="shape" id="shapeSelect" class="form-control" onchange="toggleShapeFields()">
                                    <option value="round">Round</option>
                                    <option value="square">Square</option>
                                    <option value="hexagon">Hexagon</option>
                                    <option value="width_length_height">W × L × H</option>
                                </select>
                            </div>
                        </div>
                        {{-- Pin dims --}}
                        <div class="col-md-2" id="pinDiameterField">
                            <div class="form-group">
                                <label>Diameter</label>
                                <input type="number" step="0.0001" name="pin_diameter" class="form-control" value="{{ old('pin_diameter') }}" placeholder="e.g. 1.5000" onchange="calcVolume()">
                            </div>
                        </div>
                        <div class="col-md-2" id="pinLengthField">
                            <div class="form-group">
                                <label>Length</label>
                                <input type="number" step="0.0001" name="pin_length" class="form-control" value="{{ old('pin_length') }}" placeholder="e.g. 4.2500" onchange="calcVolume()">
                            </div>
                        </div>
                        {{-- WLH dims --}}
                        <div class="col-md-2 d-none" id="wField">
                            <div class="form-group">
                                <label>Width</label>
                                <input type="number" step="0.0001" name="width" class="form-control" value="{{ old('width') }}" onchange="calcVolume()">
                            </div>
                        </div>
                        <div class="col-md-2 d-none" id="lField">
                            <div class="form-group">
                                <label>Length</label>
                                <input type="number" step="0.0001" name="length" class="form-control" value="{{ old('length') }}" onchange="calcVolume()">
                            </div>
                        </div>
                        <div class="col-md-2 d-none" id="hField">
                            <div class="form-group">
                                <label>Height</label>
                                <input type="number" step="0.0001" name="height" class="form-control" value="{{ old('height') }}" onchange="calcVolume()">
                            </div>
                        </div>
                        {{-- Alloy --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Metal Alloy</label>
                                <select name="metal_alloy" id="metalAlloySelect" class="form-control" onchange="updateMetalPrice()">
                                    <option value="">-- Select --</option>
                                    <option value="1018"  data-price="0.65"  data-density="0.284">1018 Steel</option>
                                    <option value="4140"  data-price="0.90"  data-density="0.284">4140 Steel</option>
                                    <option value="4340"  data-price="1.10"  data-density="0.284">4340 Steel</option>
                                    <option value="303ss" data-price="2.50"  data-density="0.290">303 Stainless</option>
                                    <option value="304ss" data-price="2.30"  data-density="0.290">304 Stainless</option>
                                    <option value="316ss" data-price="3.20"  data-density="0.290">316 Stainless</option>
                                    <option value="6061"  data-price="1.80"  data-density="0.098">6061 Aluminum</option>
                                    <option value="7075"  data-price="3.50"  data-density="0.102">7075 Aluminum</option>
                                    <option value="c360"  data-price="3.00"  data-density="0.307">C360 Brass</option>
                                    <option value="ti6al" data-price="18.00" data-density="0.160">Ti-6Al-4V Titanium</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>$/lb</label>
                                <input type="number" step="0.0001" name="block_price" id="blockPrice" class="form-control bg-light" readonly value="0">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Adj $/lb</label>
                                <input type="number" step="0.0001" name="metal_adjustment" id="metalAdjustment" class="form-control" value="0" onchange="calcMaterialTotal()">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Real $/lb</label>
                                <input type="number" step="0.0001" name="metal_real_price" id="metalRealPrice" class="form-control bg-light" readonly value="0">
                            </div>
                        </div>
                    </div>
                    {{-- Calculated weight row --}}
                    <div class="row" id="weightRow">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Weight / pc (lb)</label>
                                <input type="number" step="0.0001" name="weight_lb" id="weightLb" class="form-control bg-light" readonly value="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Weight / pc (kg)</label>
                                <input type="number" step="0.0001" name="weight_kg" id="weightKg" class="form-control bg-light" readonly value="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Total Weight (lb)</label>
                                <input type="number" step="0.0001" name="total_weight_lb" id="totalWeightLb" class="form-control bg-light" readonly value="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Total Weight (kg)</label>
                                <input type="number" step="0.0001" name="total_weight_kg" id="totalWeightKg" class="form-control bg-light" readonly value="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Material Each ($)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                    <input type="number" step="0.0001" name="each_pin_price" id="eachPinPrice" class="form-control bg-light" readonly value="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Material Total ($)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                    <input type="number" step="0.01" name="total_pin_price" id="totalPinPrice" class="form-control bg-light font-weight-bold" readonly value="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Attachments --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label><i class="fas fa-paperclip mr-1"></i>Attachments <small class="text-muted">(Drawings / Photos — drag & drop or click)</small></label>
                                <div id="dropZone" class="border rounded p-3 text-center" style="cursor:pointer;border-style:dashed!important;background:#f8f9fa;min-height:80px;">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-1"></i>
                                    <p class="text-muted mb-0">Drop files here or click to browse</p>
                                    <small class="text-muted">PDF, JPG, PNG, DWG, DXF, STEP, STL — max 20MB each</small>
                                    <input type="file" name="attachments[]" id="fileInput" multiple
                                           accept=".pdf,.jpg,.jpeg,.png,.dwg,.dxf,.step,.stp,.stl" style="display:none;">
                                </div>
                                <div id="filePreview" class="d-flex flex-wrap mt-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ═══ CARD 4: MACHINES ═══ --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-cog mr-2"></i>Machines</h3>
                        <button type="button" class="btn btn-primary btn-sm" onclick="addMachineRow()">
                            <i class="fas fa-plus mr-1"></i> Add Machine
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:180px;">Machine</th>
                                    <th style="min-width:130px;">Model</th>
                                    <th>Labor Mode</th>
                                    <th style="min-width:140px;">Labour</th>
                                    <th>Material</th>
                                    <th>Complexity</th>
                                    <th>Priority</th>
                                    <th>Time (min)</th>
                                    <th>Sub Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="machineTableBody">
                                <tr class="empty-row"><td colspan="11" class="text-center text-muted py-3">No machines added</td></tr>
                            </tbody>
                            <tfoot>
                                <tr class="thead-light">
                                    <td colspan="9" class="text-right font-weight-bold">Machine Total:</td>
                                    <td class="font-weight-bold">$<span id="machineTotal">0.00</span></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ═══ CARD 5: OPERATIONS ═══ --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-tools mr-2"></i>Operations</h3>
                        <button type="button" class="btn btn-primary btn-sm" onclick="addOperationRow()">
                            <i class="fas fa-plus mr-1"></i> Add Operation
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="min-width:180px;">Operation</th>
                                    <th style="min-width:140px;">Labour</th>
                                    <th>Time (min)</th>
                                    <th>Rate ($/hr)</th>
                                    <th>Sub Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="operationTableBody">
                                <tr class="empty-row"><td colspan="6" class="text-center text-muted py-3">No operations added</td></tr>
                            </tbody>
                            <tfoot>
                                <tr class="thead-light">
                                    <td colspan="4" class="text-right font-weight-bold">Operation Total:</td>
                                    <td class="font-weight-bold">$<span id="operationTotal">0.00</span></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ═══ CARD 6: ITEMS ═══ --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-box mr-2"></i>Items</h3>
                        <button type="button" class="btn btn-primary btn-sm" onclick="addItemRow()">
                            <i class="fas fa-plus mr-1"></i> Add Item
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="min-width:180px;">Item</th>
                                    <th>Description</th>
                                    <th style="width:70px;">Qty</th>
                                    <th>Rate ($)</th>
                                    <th>Sub Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="itemsTableBody">
                                <tr class="empty-row"><td colspan="6" class="text-center text-muted py-3">No items added</td></tr>
                            </tbody>
                            <tfoot>
                                <tr class="thead-light">
                                    <td colspan="4" class="text-right font-weight-bold">Items Total:</td>
                                    <td class="font-weight-bold">$<span id="itemsTotal">0.00</span></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ═══ CARD 7: HOLES ═══ --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-circle-notch mr-2"></i>Holes</h3>
                        <button type="button" class="btn btn-success btn-sm" onclick="addHoleRow()">
                            <i class="fas fa-plus mr-1"></i> Add Hole
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th style="width:60px;">Qty</th>
                                    <th style="min-width:150px;">Drilling Method</th>
                                    <th>Size</th>
                                    <th>Tol (+)</th>
                                    <th>Tol (-)</th>
                                    <th>Depth</th>
                                    <th>Hole $</th>
                                    <th style="min-width:140px;">Chamfer</th>
                                    <th>Ch. $</th>
                                    <th style="min-width:140px;">Debur</th>
                                    <th>Db. $</th>
                                    <th>Sub Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="holesTableBody">
                                <tr class="empty-row"><td colspan="14" class="text-center text-muted py-3">No holes added</td></tr>
                            </tbody>
                            <tfoot>
                                <tr class="thead-light">
                                    <td colspan="12" class="text-right font-weight-bold">Holes Total:</td>
                                    <td class="font-weight-bold">$<span id="holesTotal">0.00</span></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ═══ CARD 8: TAPS ═══ --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-screwdriver mr-2"></i>Taps</h3>
                        <button type="button" class="btn btn-danger btn-sm" onclick="addTapRow()">
                            <i class="fas fa-plus mr-1"></i> Add Tap
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:150px;">Tapped</th>
                                    <th>Tap $</th>
                                    <th>Thread Option</th>
                                    <th>Direction</th>
                                    <th>Thread Size</th>
                                    <th>Base $</th>
                                    <th style="min-width:130px;">Chamfer</th>
                                    <th>Ch. $</th>
                                    <th style="min-width:130px;">Debur</th>
                                    <th>Db. $</th>
                                    <th>Sub Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tapsTableBody">
                                <tr class="empty-row"><td colspan="13" class="text-center text-muted py-3">No taps added</td></tr>
                            </tbody>
                            <tfoot>
                                <tr class="thead-light">
                                    <td colspan="11" class="text-right font-weight-bold">Taps Total:</td>
                                    <td class="font-weight-bold">$<span id="tapsTotal">0.00</span></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ═══ CARD 9: THREADS ═══ --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-compress-arrows-alt mr-2"></i>Threads</h3>
                        <button type="button" class="btn btn-warning btn-sm" onclick="addThreadRow()">
                            <i class="fas fa-plus mr-1"></i> Add Thread
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Ref</th>
                                    <th style="min-width:130px;">Type</th>
                                    <th>Thread $</th>
                                    <th>Place</th>
                                    <th>Option</th>
                                    <th>Direction</th>
                                    <th>Size</th>
                                    <th>Base $</th>
                                    <th>Class $</th>
                                    <th>Sub Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="threadsTableBody">
                                <tr class="empty-row"><td colspan="11" class="text-center text-muted py-3">No threads added</td></tr>
                            </tbody>
                            <tfoot>
                                <tr class="thead-light">
                                    <td colspan="9" class="text-right font-weight-bold">Threads Total:</td>
                                    <td class="font-weight-bold">$<span id="threadsTotal">0.00</span></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ═══ CARD 10: SECONDARY OPS ═══ --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-layer-group mr-2"></i>Secondary Operations</h3>
                        <button type="button" class="btn btn-info btn-sm" onclick="addSecondaryRow()">
                            <i class="fas fa-plus mr-1"></i> Add Operation
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="min-width:160px;">Operation Name</th>
                                    <th style="min-width:160px;">Vendor</th>
                                    <th>Price Type</th>
                                    <th style="width:80px;">Qty</th>
                                    <th>Unit Price ($)</th>
                                    <th>Sub Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="secondaryTableBody">
                                <tr class="empty-row"><td colspan="7" class="text-center text-muted py-3">No secondary operations added</td></tr>
                            </tbody>
                            <tfoot>
                                <tr class="thead-light">
                                    <td colspan="5" class="text-right font-weight-bold">Secondary Total:</td>
                                    <td class="font-weight-bold">$<span id="secondaryTotal">0.00</span></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ═══ CARD 11: PLATING & HEAT ═══ --}}
            <div class="card">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-fire mr-2"></i>Plating &amp; Heat Treating</h3></div>
                <div class="card-body">
                    <div class="row">
                        {{-- PLATING --}}
                        <div class="col-md-6">
                            <h6 class="font-weight-bold border-bottom pb-1 mb-3">Plating</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Vendor</label>
                                        <select name="plating_vendor_id" class="form-control form-control-sm">
                                            <option value="">No Vendor</option>
                                            @foreach($vendors as $v)
                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Coating / Plating Type</label>
                                        <input type="text" name="plating_type" class="form-control form-control-sm" placeholder="e.g. Zinc, Hard Chrome">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pricing Type</label>
                                        <select name="plating_pricing_type" id="platingPricingType" class="form-control form-control-sm" onchange="togglePlatingFields()">
                                            <option value="per_each">Per Each</option>
                                            <option value="per_pound">Per Pound</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- Per Each --}}
                                <div class="col-md-3" id="platingEachCount">
                                    <div class="form-group">
                                        <label>Count</label>
                                        <input type="number" name="plating_count" class="form-control form-control-sm" value="0" onchange="calcPlatingTotal()">
                                    </div>
                                </div>
                                <div class="col-md-3" id="platingEachPrice">
                                    <div class="form-group">
                                        <label>$ / Each</label>
                                        <input type="number" step="0.0001" name="plating_price_each" class="form-control form-control-sm" value="0" onchange="calcPlatingTotal()">
                                    </div>
                                </div>
                                {{-- Per Pound --}}
                                <div class="col-md-3 d-none" id="platingPoundLbs">
                                    <div class="form-group">
                                        <label>Total lbs</label>
                                        <input type="number" step="0.0001" name="plating_total_pounds" class="form-control form-control-sm" value="0" onchange="calcPlatingTotal()">
                                    </div>
                                </div>
                                <div class="col-md-3 d-none" id="platingPoundLot">
                                    <div class="form-group">
                                        <label>Lot Charge $</label>
                                        <input type="number" step="0.01" name="plating_lot_charge" class="form-control form-control-sm" value="0" onchange="calcPlatingTotal()">
                                    </div>
                                </div>
                                <div class="col-md-3 d-none" id="platingPoundRate">
                                    <div class="form-group">
                                        <label>$ / lb (after 100)</label>
                                        <input type="number" step="0.0001" name="plating_per_pound" class="form-control form-control-sm" value="0" onchange="calcPlatingTotal()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Salt Testing $</label>
                                        <input type="number" step="0.01" name="plating_salt_testing" class="form-control form-control-sm" value="0" onchange="calcPlatingTotal()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Surcharge $</label>
                                        <input type="number" step="0.01" name="plating_surcharge" class="form-control form-control-sm" value="0" onchange="calcPlatingTotal()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Standards $</label>
                                        <input type="number" step="0.01" name="plating_standards_price" class="form-control form-control-sm" value="0" onchange="calcPlatingTotal()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><strong>Plating Total</strong></label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                            <input type="number" step="0.01" name="plating_total" id="platingTotal" class="form-control font-weight-bold bg-light" readonly value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- HEAT TREATING --}}
                        <div class="col-md-6 border-left">
                            <h6 class="font-weight-bold border-bottom pb-1 mb-3">Heat Treating</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Vendor</label>
                                        <select name="heat_vendor_id" class="form-control form-control-sm">
                                            <option value="">No Vendor</option>
                                            @foreach($vendors as $v)
                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Treatment Type</label>
                                        <input type="text" name="heat_type" class="form-control form-control-sm" placeholder="e.g. Anneal, Harden">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pricing Type</label>
                                        <select name="heat_pricing_type" id="heatPricingType" class="form-control form-control-sm" onchange="toggleHeatFields()">
                                            <option value="per_each">Per Each</option>
                                            <option value="per_pound">Per Pound</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3" id="heatEachCount">
                                    <div class="form-group">
                                        <label>Count</label>
                                        <input type="number" name="heat_count" class="form-control form-control-sm" value="0" onchange="calcHeatTotal()">
                                    </div>
                                </div>
                                <div class="col-md-3" id="heatEachPrice">
                                    <div class="form-group">
                                        <label>$ / Each</label>
                                        <input type="number" step="0.0001" name="heat_price_each" class="form-control form-control-sm" value="0" onchange="calcHeatTotal()">
                                    </div>
                                </div>
                                <div class="col-md-3 d-none" id="heatPoundLbs">
                                    <div class="form-group">
                                        <label>Total lbs</label>
                                        <input type="number" step="0.0001" name="heat_total_pounds" class="form-control form-control-sm" value="0" onchange="calcHeatTotal()">
                                    </div>
                                </div>
                                <div class="col-md-3 d-none" id="heatPoundLot">
                                    <div class="form-group">
                                        <label>Lot Charge $</label>
                                        <input type="number" step="0.01" name="heat_lot_charge" class="form-control form-control-sm" value="0" onchange="calcHeatTotal()">
                                    </div>
                                </div>
                                <div class="col-md-3 d-none" id="heatPoundRate">
                                    <div class="form-group">
                                        <label>$ / lb (after 100)</label>
                                        <input type="number" step="0.0001" name="heat_per_pound" class="form-control form-control-sm" value="0" onchange="calcHeatTotal()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Testing $</label>
                                        <input type="number" step="0.01" name="heat_testing" class="form-control form-control-sm" value="0" onchange="calcHeatTotal()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Surcharge $</label>
                                        <input type="number" step="0.01" name="heat_surcharge" class="form-control form-control-sm" value="0" onchange="calcHeatTotal()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><strong>Heat Total</strong></label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                            <input type="number" step="0.01" name="heat_total" id="heatTotal" class="form-control font-weight-bold bg-light" readonly value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ CARD 12: FINAL TOTALS & SUBMIT ═══ --}}
            <div class="card">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-calculator mr-2"></i>Final Pricing &amp; Notes</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            {{-- Cost summary table --}}
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light"><tr><th>Component</th><th>Each</th><th>Total (× qty)</th></tr></thead>
                                <tbody>
                                    @foreach([
                                        ['material','Material'],['machine','Machine'],['operation','Operation'],
                                        ['items','Items'],['holes','Holes'],['taps','Taps'],['threads','Threads'],
                                        ['secondary','Secondary'],['plating','Plating'],['heat','Heat Treat'],
                                    ] as [$k,$lbl])
                                    <tr>
                                        <td>{{ $lbl }}</td>
                                        <td>$<span id="sum_{{$k}}_each">0.00</span></td>
                                        <td>$<span id="sum_{{$k}}_total">0.00</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-dark font-weight-bold">
                                        <td>GRAND TOTAL</td>
                                        <td>$<span id="sum_grand_each">0.00</span></td>
                                        <td>$<span id="sum_grand_total">0.00</span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Break-In Charge ($)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                    <input type="number" step="0.01" name="break_in_charge" id="breakInCharge" class="form-control" value="0" onchange="recalcAll()">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Override Price Each ($) <small class="text-muted">0 = no override</small></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                    <input type="number" step="0.01" name="override_price" id="overridePrice" class="form-control" value="0" onchange="recalcAll()">
                                </div>
                            </div>
                            <div class="form-group">
                                <label><strong>Grand Each Price</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                    <input type="number" step="0.01" name="grand_each_price" id="grandEachPrice" class="form-control bg-light font-weight-bold" readonly value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label><strong>Grand Total Price</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                    <input type="number" step="0.01" name="grand_total_price" id="grandTotalPrice" class="form-control bg-success text-white font-weight-bold" readonly value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Engineer Notes</label>
                                <textarea name="engineer_notes" class="form-control" rows="3" placeholder="Notes for engineering...">{{ old('engineer_notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="#" class="btn btn-secondary">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check mr-1"></i> Save Quote
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
// ══════════════════════════════════════════════════════════
// DATA FROM BACKEND
// ══════════════════════════════════════════════════════════
var machinesData   = @json($machinesJs);
var operationsData = @json($operationsJs);
var itemsData      = @json($itemsJs);
var vendorsData    = @json($vendorsJs);
var tapsData       = @json($tapsJs);
var operatorsData  = @json($operatorsJs);

// ══════════════════════════════════════════════════════════
// INIT
// ══════════════════════════════════════════════════════════
$(document).ready(function(){
    // Select2 for customer
    $('#customerSelect').select2({theme:'bootstrap4',placeholder:'-- Select Customer --',allowClear:true,width:'100%'})
        .on('change',function(){
            var opt = $(this).find(':selected');
            $('#shipTo').val(opt.data('ship')||'');
            $('#billTo').val(opt.data('bill')||'');
        });

    // Drag & drop init
    var dz = document.getElementById('dropZone');
    dz.addEventListener('dragover',  function(e){e.preventDefault();dz.style.background='#d4edda';});
    dz.addEventListener('dragleave', function(){dz.style.background='#f8f9fa';});
    dz.addEventListener('drop',      function(e){e.preventDefault();dz.style.background='#f8f9fa';handleFiles(e.dataTransfer.files);});
    dz.addEventListener('click',     function(){document.getElementById('fileInput').click();});
    document.getElementById('fileInput').addEventListener('change',function(){handleFiles(this.files);});
});

// ══════════════════════════════════════════════════════════
// HELPERS
// ══════════════════════════════════════════════════════════
function fmtNum(v){return (parseFloat(v)||0).toFixed(2);}

function buildSelect(arr, nameKey, extraAttrs){
    // arr: [{id,name,...}], nameKey: display property, extraAttrs: fn(item) => 'data-x="y"'
    var html = '<option value="">Select</option>';
    arr.forEach(function(item){
        html += '<option value="'+item.id+'" '+(extraAttrs?extraAttrs(item):'')+'>'+item[nameKey]+'</option>';
    });
    return html;
}

function clearEmpty(tbodyId){ var t=$('#'+tbodyId); if(t.find('tr.empty-row').length)t.empty(); }
function rmRow(id){$('#'+id).remove();}

// ══════════════════════════════════════════════════════════
// CUSTOMER TOGGLE
// ══════════════════════════════════════════════════════════
function toggleTempCustomer(){
    var temp = $('#isTempCustomer').is(':checked');
    $('#customerSelectGroup').toggle(!temp);
    $('#tempCustomerFields').toggle(temp);
}

// ══════════════════════════════════════════════════════════
// ATTACHMENTS
// ══════════════════════════════════════════════════════════
var attachedFiles = [];
function handleFiles(files){
    Array.from(files).forEach(function(f){
        if(f.size > 20*1024*1024){toastr.error(f.name+' exceeds 20MB');return;}
        var idx = attachedFiles.length;
        attachedFiles.push(f);
        var preview = document.getElementById('filePreview');
        var w = document.createElement('div');
        w.id = 'att_'+idx;
        w.style.cssText = 'position:relative;margin:4px;text-align:center;width:80px;';
        if(f.type.startsWith('image/')){
            var r = new FileReader();
            r.onload=function(e){
                w.innerHTML='<img src="'+e.target.result+'" style="width:80px;height:60px;object-fit:cover;border:1px solid #dee2e6;border-radius:4px;">'
                    +'<button type="button" onclick="removeAtt('+idx+')" style="position:absolute;top:-5px;right:-5px;background:#dc3545;color:#fff;border:none;border-radius:50%;width:18px;height:18px;font-size:10px;cursor:pointer;">×</button>'
                    +'<div style="font-size:9px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;width:80px;">'+f.name+'</div>';
            };
            r.readAsDataURL(f);
        } else {
            w.innerHTML='<div style="width:80px;height:60px;background:#f8f9fa;border:1px solid #dee2e6;border-radius:4px;display:flex;align-items:center;justify-content:center;">'
                +'<span style="font-size:10px;font-weight:bold;">'+f.name.split('.').pop().toUpperCase()+'</span></div>'
                +'<button type="button" onclick="removeAtt('+idx+')" style="position:absolute;top:-5px;right:-5px;background:#dc3545;color:#fff;border:none;border-radius:50%;width:18px;height:18px;font-size:10px;cursor:pointer;">×</button>'
                +'<div style="font-size:9px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;width:80px;">'+f.name+'</div>';
        }
        preview.appendChild(w);
        syncFileInput();
    });
}
function removeAtt(idx){attachedFiles.splice(idx,1);var el=document.getElementById('att_'+idx);if(el)el.remove();syncFileInput();}
function syncFileInput(){var dt=new DataTransfer();attachedFiles.forEach(function(f){dt.items.add(f);});document.getElementById('fileInput').files=dt.files;}

// ══════════════════════════════════════════════════════════
// SHAPE & MATERIAL
// ══════════════════════════════════════════════════════════
function toggleShapeFields(){
    var s = $('#shapeSelect').val();
    var isWLH = (s === 'width_length_height');
    $('#pinDiameterField,#pinLengthField').toggle(!isWLH);
    $('#wField,#lField,#hField').toggle(isWLH);
    calcVolume();
}
function updateMetalPrice(){
    var opt = $('#metalAlloySelect').find(':selected');
    $('#blockPrice').val(parseFloat(opt.data('price')||0).toFixed(4));
    calcMaterialTotal();
}
function calcMaterialTotal(){
    var block = parseFloat($('#blockPrice').val())||0;
    var adj   = parseFloat($('#metalAdjustment').val())||0;
    $('#metalRealPrice').val((block+adj).toFixed(4));
    calcVolume();
}
function calcVolume(){
    var shape   = $('#shapeSelect').val();
    var density = parseFloat($('#metalAlloySelect').find(':selected').data('density'))||0.284;
    var unit    = $('#globalUnit').val();
    var qty     = parseInt($('#globalQty').val())||1;
    var real    = parseFloat($('#metalRealPrice').val())||0;
    var weightLb=0;

    if(shape==='width_length_height'){
        var w=parseFloat($('input[name="width"]').val())||0;
        var l=parseFloat($('input[name="length"]').val())||0;
        var h=parseFloat($('input[name="height"]').val())||0;
        var vol = unit==='mm' ? (w*l*h)/16387.064 : w*l*h;
        weightLb = vol * density;
    } else {
        var d  = parseFloat($('input[name="pin_diameter"]').val())||0;
        var pl = parseFloat($('input[name="pin_length"]').val())||0;
        var r  = d/2;
        var vol = unit==='mm' ? (Math.PI*r*r*pl)/16387.064 : Math.PI*r*r*pl;
        weightLb = vol * density;
    }

    var weightKg = weightLb * 0.453592;
    var each     = weightLb * real;
    var total    = each * qty;

    $('#weightLb').val(weightLb.toFixed(4));
    $('#weightKg').val(weightKg.toFixed(4));
    $('#totalWeightLb').val((weightLb*qty).toFixed(4));
    $('#totalWeightKg').val((weightKg*qty).toFixed(4));
    $('#eachPinPrice').val(each.toFixed(4));
    $('#totalPinPrice').val(total.toFixed(2));
    recalcAll();
}

// ══════════════════════════════════════════════════════════
// MACHINES
// ══════════════════════════════════════════════════════════
var mCnt=0;
function addMachineRow(){
    mCnt++;
    clearEmpty('machineTableBody');
    var mOpts='<option value="">Select Machine</option>';
    machinesData.forEach(function(m){mOpts+='<option value="'+m.id+'" data-model="'+(m.model||'')+'">'+m.name+' ('+m.code+')</option>';});
    var lOpts='<option value="">Select Labour</option>';
    operatorsData.forEach(function(o){lOpts+='<option value="'+o.id+'" data-rate="'+(o.rate||0)+'">'+o.name+'</option>';});
    var r=mCnt;
    $('#machineTableBody').append(
        '<tr id="mr_'+r+'">'
        +'<td class="text-center">'+r+'</td>'
        +'<td><select name="machines['+r+'][machine_id]" class="form-control form-control-sm">'+mOpts+'</select></td>'
        +'<td><input type="text" name="machines['+r+'][model]" class="form-control form-control-sm" placeholder="Model"></td>'
        +'<td><select name="machines['+r+'][labor_mode]" class="form-control form-control-sm">'
        +'<option>Attended</option><option>Unattended</option><option>Semi-Attended</option></select></td>'
        +'<td><select name="machines['+r+'][labour_id]" class="form-control form-control-sm m-labour" onchange="updateMSub('+r+')">'+lOpts+'</select></td>'
        +'<td><select name="machines['+r+'][material]" class="form-control form-control-sm">'
        +'<option>Steel</option><option>Aluminum</option><option>Stainless</option><option>Brass</option><option>Titanium</option></select></td>'
        +'<td><select name="machines['+r+'][complexity]" class="form-control form-control-sm">'
        +'<option>Simple</option><option>Moderate</option><option>Complex</option><option>Very Complex</option></select></td>'
        +'<td><select name="machines['+r+'][priority]" class="form-control form-control-sm">'
        +'<option>Normal</option><option>Rush</option><option>Urgent</option></select></td>'
        +'<td><input type="number" step="0.01" name="machines['+r+'][time]" class="form-control form-control-sm m-time" value="0" onchange="updateMSub('+r+')"></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="machines['+r+'][sub_total]" id="mst_'+r+'" class="form-control bg-light m-sub" value="0.00" readonly></div></td>'
        +'<td><button type="button" class="btn btn-sm btn-danger" onclick="rmRow(\'mr_'+r+'\');calcMachineTotal()"><i class="fas fa-trash"></i></button></td>'
        +'</tr>'
    );
}
function updateMSub(r){
    var time = parseFloat($('#mr_'+r+' .m-time').val())||0;
    var rate = parseFloat($('#mr_'+r+' .m-labour').find(':selected').data('rate'))||0;
    $('#mst_'+r).val(((time/60)*rate).toFixed(2));
    calcMachineTotal();
}
function calcMachineTotal(){
    var t=0; $('.m-sub').each(function(){t+=parseFloat($(this).val())||0;});
    $('#machineTotal').text(t.toFixed(2));
    recalcAll();
}

// ══════════════════════════════════════════════════════════
// OPERATIONS
// ══════════════════════════════════════════════════════════
var opCnt=0;
function addOperationRow(){
    opCnt++;
    clearEmpty('operationTableBody');
    var oOpts='<option value="">Select Operation</option>';
    operationsData.forEach(function(o){oOpts+='<option value="'+o.id+'" data-rate="'+(o.rate||0)+'">'+o.name+'</option>';});
    var lOpts='<option value="">Select Labour</option>';
    operatorsData.forEach(function(o){lOpts+='<option value="'+o.id+'" data-rate="'+(o.rate||0)+'">'+o.name+'</option>';});
    var r=opCnt;
    $('#operationTableBody').append(
        '<tr id="opr_'+r+'">'
        +'<td><select name="operations['+r+'][operation_id]" class="form-control form-control-sm op-sel" onchange="updateOpSub('+r+')">'+oOpts+'</select></td>'
        +'<td><select name="operations['+r+'][labour_id]" class="form-control form-control-sm op-lab" onchange="updateOpSub('+r+')">'+lOpts+'</select></td>'
        +'<td><input type="number" step="0.01" name="operations['+r+'][time]" class="form-control form-control-sm op-time" value="0" onchange="updateOpSub('+r+')"></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="operations['+r+'][rate]" id="oprate_'+r+'" class="form-control bg-light" value="0" readonly></div></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="operations['+r+'][sub_total]" id="opst_'+r+'" class="form-control bg-light op-sub" value="0.00" readonly></div></td>'
        +'<td><button type="button" class="btn btn-sm btn-danger" onclick="rmRow(\'opr_'+r+'\');calcOpTotal()"><i class="fas fa-trash"></i></button></td>'
        +'</tr>'
    );
}
function updateOpSub(r){
    var time  = parseFloat($('#opr_'+r+' .op-time').val())||0;
    var lRate = parseFloat($('#opr_'+r+' .op-lab').find(':selected').data('rate'))||0;
    var oRate = parseFloat($('#opr_'+r+' .op-sel').find(':selected').data('rate'))||0;
    var rate  = lRate || oRate;
    $('#oprate_'+r).val(rate.toFixed(2));
    $('#opst_'+r).val(((time/60)*rate).toFixed(2));
    calcOpTotal();
}
function calcOpTotal(){
    var t=0; $('.op-sub').each(function(){t+=parseFloat($(this).val())||0;});
    $('#operationTotal').text(t.toFixed(2)); recalcAll();
}

// ══════════════════════════════════════════════════════════
// ITEMS
// ══════════════════════════════════════════════════════════
var itCnt=0;
function addItemRow(){
    itCnt++;
    clearEmpty('itemsTableBody');
    var iOpts='<option value="">Select Item</option>';
    itemsData.forEach(function(i){iOpts+='<option value="'+i.id+'" data-rate="'+(i.sell_price||0)+'" data-desc="'+(i.description||'')+'">'+i.name+'</option>';});
    var r=itCnt;
    $('#itemsTableBody').append(
        '<tr id="itr_'+r+'">'
        +'<td><select name="items['+r+'][item_id]" class="form-control form-control-sm it-sel" onchange="itemChanged(this,'+r+')">'+iOpts+'</select></td>'
        +'<td><input type="text" name="items['+r+'][description]" id="itdesc_'+r+'" class="form-control form-control-sm" placeholder="—"></td>'
        +'<td><input type="number" name="items['+r+'][qty]" class="form-control form-control-sm it-qty" value="1" onchange="updateItSub('+r+')"></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="items['+r+'][rate]" class="form-control it-rate" value="0.00" onchange="updateItSub('+r+')"></div></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="items['+r+'][sub_total]" id="itst_'+r+'" class="form-control bg-light it-sub" value="0.00" readonly></div></td>'
        +'<td><button type="button" class="btn btn-sm btn-danger" onclick="rmRow(\'itr_'+r+'\');calcItemTotal()"><i class="fas fa-trash"></i></button></td>'
        +'</tr>'
    );
}
function itemChanged(sel,r){
    var opt=$(sel).find(':selected');
    $('#itr_'+r+' .it-rate').val(fmtNum(opt.data('rate')||0));
    $('#itdesc_'+r).val(opt.data('desc')||'');
    updateItSub(r);
}
function updateItSub(r){
    var qty  = parseFloat($('#itr_'+r+' .it-qty').val())||0;
    var rate = parseFloat($('#itr_'+r+' .it-rate').val())||0;
    $('#itst_'+r).val((qty*rate).toFixed(2)); calcItemTotal();
}
function calcItemTotal(){
    var t=0; $('.it-sub').each(function(){t+=parseFloat($(this).val())||0;});
    $('#itemsTotal').text(t.toFixed(2)); recalcAll();
}

// ══════════════════════════════════════════════════════════
// HOLES
// ══════════════════════════════════════════════════════════
var hCnt=0;
var chamferOpts='<option value="" data-price="0">No Chamfer</option><option value="0.5x45" data-price="2.50">0.5mm×45°</option><option value="1.0x45" data-price="3.00">1.0mm×45°</option><option value="1.5x45" data-price="3.50">1.5mm×45°</option>';
var deburOpts='<option value="" data-price="0">No Debur</option><option value="standard" data-price="1.50">Standard</option><option value="sharp" data-price="2.00">Sharp Edge</option><option value="heavy" data-price="2.50">Heavy</option>';
function addHoleRow(){
    hCnt++;
    clearEmpty('holesTableBody');
    var r=hCnt;
    $('#holesTableBody').append(
        '<tr id="hr_'+r+'">'
        +'<td class="text-center font-weight-bold">H'+r+'</td>'
        +'<td><input type="number" name="holes['+r+'][qty]" class="form-control form-control-sm h-qty" value="1" style="width:55px;" onchange="calcHoleSub('+r+')"></td>'
        +'<td><select name="holes['+r+'][drilling_method]" class="form-control form-control-sm"><option>Drill</option><option>Ream</option><option>Bore</option><option>Counter Bore</option><option>Counter Sink</option></select></td>'
        +'<td><input type="number" step="0.001" name="holes['+r+'][hole_size]" class="form-control form-control-sm" style="width:80px;" placeholder="2.505"></td>'
        +'<td><input type="number" step="0.001" name="holes['+r+'][tol_plus]" class="form-control form-control-sm" style="width:70px;" value="0.005"></td>'
        +'<td><input type="number" step="0.001" name="holes['+r+'][tol_minus]" class="form-control form-control-sm" style="width:70px;" value="0.005"></td>'
        +'<td><select name="holes['+r+'][depth_type]" class="form-control form-control-sm" style="width:90px;" onchange="toggleHoleDepth('+r+')">'
        +'<option value="through">Through</option><option value="other">Other</option></select>'
        +'<div id="hdepth_'+r+'" style="display:none;"><input type="number" step="0.01" name="holes['+r+'][depth_size]" class="form-control form-control-sm mt-1" placeholder="Depth"></div></td>'
        +'<td><input type="number" step="0.01" name="holes['+r+'][hole_price]" class="form-control form-control-sm h-hp" value="0" style="width:80px;" onchange="calcHoleSub('+r+')"></td>'
        +'<td><select name="holes['+r+'][chamfer]" class="form-control form-control-sm" onchange="updateHoleChamfer('+r+')">'+chamferOpts+'</select></td>'
        +'<td><input type="number" step="0.01" name="holes['+r+'][chamfer_price]" id="hcp_'+r+'" class="form-control form-control-sm bg-light" style="width:70px;" readonly value="0"></td>'
        +'<td><select name="holes['+r+'][debur]" class="form-control form-control-sm" onchange="updateHoleDebur('+r+')">'+deburOpts+'</select></td>'
        +'<td><input type="number" step="0.01" name="holes['+r+'][debur_price]" id="hdp_'+r+'" class="form-control form-control-sm bg-light" style="width:70px;" readonly value="0"></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="holes['+r+'][sub_total]" id="hst_'+r+'" class="form-control bg-light h-sub font-weight-bold" style="width:80px;" readonly value="0.00"></div></td>'
        +'<td><button type="button" class="btn btn-sm btn-danger" onclick="rmRow(\'hr_'+r+'\');calcHoleTotal()"><i class="fas fa-trash"></i></button></td>'
        +'</tr>'
    );
}
function toggleHoleDepth(r){$('#hdepth_'+r).toggle($('select[name="holes['+r+'][depth_type]"]').val()==='other');}
function updateHoleChamfer(r){var p=parseFloat($('select[name="holes['+r+'][chamfer]"]').find(':selected').data('price'))||0;$('#hcp_'+r).val(p.toFixed(2));calcHoleSub(r);}
function updateHoleDebur(r){var p=parseFloat($('select[name="holes['+r+'][debur]"]').find(':selected').data('price'))||0;$('#hdp_'+r).val(p.toFixed(2));calcHoleSub(r);}
function calcHoleSub(r){
    var hp  = parseFloat($('input[name="holes['+r+'][hole_price]"]').val())||0;
    var ch  = parseFloat($('#hcp_'+r).val())||0;
    var db  = parseFloat($('#hdp_'+r).val())||0;
    var qty = parseFloat($('input[name="holes['+r+'][qty]"]').val())||1;
    $('#hst_'+r).val(((hp+ch+db)*qty).toFixed(2)); calcHoleTotal();
}
function calcHoleTotal(){var t=0;$('.h-sub').each(function(){t+=parseFloat($(this).val())||0;});$('#holesTotal').text(t.toFixed(2));recalcAll();}

// ══════════════════════════════════════════════════════════
// TAPS
// ══════════════════════════════════════════════════════════
var tpCnt=0;
function addTapRow(){
    tpCnt++;
    clearEmpty('tapsTableBody');
    var tOpts='<option value="">Select Tapped</option>';
    if(tapsData.length){tapsData.forEach(function(t){tOpts+='<option value="'+t.id+'" data-price="'+(t.tap_price||0)+'">'+t.name+'</option>';});}
    else{tOpts+='<option value="1" data-price="11.00">M6×1.0</option><option value="2" data-price="12.50">M8×1.25</option><option value="3" data-price="15.50">1/4-20</option>';}
    var r=tpCnt;
    $('#tapsTableBody').append(
        '<tr id="tpr_'+r+'">'
        +'<td class="text-center font-weight-bold text-danger">T'+r+'</td>'
        +'<td><select name="taps['+r+'][tap_id]" class="form-control form-control-sm" onchange="tapChanged(this,'+r+')">'+tOpts+'</select></td>'
        +'<td><input type="number" step="0.01" name="taps['+r+'][tap_price]" id="tpp_'+r+'" class="form-control form-control-sm bg-light" style="width:80px;" readonly value="0"></td>'
        +'<td><select name="taps['+r+'][thread_option]" class="form-control form-control-sm" onchange="calcTapSub('+r+')">'
        +'<option value="" data-price="0">--</option><option value="internal" data-price="2.50">Internal</option><option value="external" data-price="3.00">External</option></select></td>'
        +'<td><select name="taps['+r+'][direction]" class="form-control form-control-sm"><option value="right">Right</option><option value="left">Left</option></select></td>'
        +'<td><input type="text" name="taps['+r+'][thread_size]" class="form-control form-control-sm" placeholder="M6×1.0"></td>'
        +'<td><input type="number" step="0.01" name="taps['+r+'][base_price]" class="form-control form-control-sm tp-base" style="width:80px;" value="0" onchange="calcTapSub('+r+')"></td>'
        +'<td><select name="taps['+r+'][chamfer]" class="form-control form-control-sm" onchange="updateTapChamfer('+r+')">'+chamferOpts+'</select></td>'
        +'<td><input type="number" step="0.01" name="taps['+r+'][chamfer_price]" id="tcpr_'+r+'" class="form-control form-control-sm bg-light" style="width:70px;" readonly value="0"></td>'
        +'<td><select name="taps['+r+'][debur]" class="form-control form-control-sm" onchange="updateTapDebur('+r+')">'+deburOpts+'</select></td>'
        +'<td><input type="number" step="0.01" name="taps['+r+'][debur_price]" id="tdpr_'+r+'" class="form-control form-control-sm bg-light" style="width:70px;" readonly value="0"></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="taps['+r+'][sub_total]" id="tst_'+r+'" class="form-control bg-light tp-sub font-weight-bold" style="width:80px;" readonly value="0.00"></div></td>'
        +'<td><button type="button" class="btn btn-sm btn-danger" onclick="rmRow(\'tpr_'+r+'\');calcTapTotal()"><i class="fas fa-trash"></i></button></td>'
        +'</tr>'
    );
}
function tapChanged(sel,r){var p=parseFloat($(sel).find(':selected').data('price'))||0;$('#tpp_'+r).val(p.toFixed(2));calcTapSub(r);}
function updateTapChamfer(r){var p=parseFloat($('select[name="taps['+r+'][chamfer]"]').find(':selected').data('price'))||0;$('#tcpr_'+r).val(p.toFixed(2));calcTapSub(r);}
function updateTapDebur(r){var p=parseFloat($('select[name="taps['+r+'][debur]"]').find(':selected').data('price'))||0;$('#tdpr_'+r).val(p.toFixed(2));calcTapSub(r);}
function calcTapSub(r){
    var tap  = parseFloat($('#tpp_'+r).val())||0;
    var opt  = parseFloat($('select[name="taps['+r+'][thread_option]"]').find(':selected').data('price'))||0;
    var base = parseFloat($('#tpr_'+r+' .tp-base').val())||0;
    var ch   = parseFloat($('#tcpr_'+r).val())||0;
    var db   = parseFloat($('#tdpr_'+r).val())||0;
    $('#tst_'+r).val((tap+opt+base+ch+db).toFixed(2)); calcTapTotal();
}
function calcTapTotal(){var t=0;$('.tp-sub').each(function(){t+=parseFloat($(this).val())||0;});$('#tapsTotal').text(t.toFixed(2));recalcAll();}

// ══════════════════════════════════════════════════════════
// THREADS
// ══════════════════════════════════════════════════════════
var thCnt=0;
function addThreadRow(){
    thCnt++;
    clearEmpty('threadsTableBody');
    var r=thCnt;
    $('#threadsTableBody').append(
        '<tr id="thr_'+r+'">'
        +'<td><input type="text" name="threads['+r+'][id]" class="form-control form-control-sm" value="TH'+r+'" style="width:55px;"></td>'
        +'<td><select name="threads['+r+'][type]" class="form-control form-control-sm" onchange="calcThSub('+r+')">'
        +'<option value="">Select</option><option value="external">External</option><option value="internal">Internal</option></select></td>'
        +'<td><input type="number" step="0.01" name="threads['+r+'][thread_price]" class="form-control form-control-sm th-tp" style="width:80px;" value="0" onchange="calcThSub('+r+')"></td>'
        +'<td><input type="text" name="threads['+r+'][processed_place]" class="form-control form-control-sm" placeholder="OD/ID" style="width:70px;"></td>'
        +'<td><select name="threads['+r+'][option]" class="form-control form-control-sm" onchange="calcThSub('+r+')">'
        +'<option value="" data-price="0">--</option><option value="full" data-price="2.00">Full</option><option value="partial" data-price="1.50">Partial</option></select></td>'
        +'<td><select name="threads['+r+'][direction]" class="form-control form-control-sm"><option>Right</option><option>Left</option></select></td>'
        +'<td><input type="text" name="threads['+r+'][thread_size]" class="form-control form-control-sm" placeholder="M10×1.5" style="width:80px;"></td>'
        +'<td><input type="number" step="0.01" name="threads['+r+'][base_price]" class="form-control form-control-sm th-bp" style="width:80px;" value="0" onchange="calcThSub('+r+')"></td>'
        +'<td><input type="number" step="0.01" name="threads['+r+'][class_price]" class="form-control form-control-sm th-cp" style="width:80px;" value="0" onchange="calcThSub('+r+')"></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="threads['+r+'][sub_total]" id="thst_'+r+'" class="form-control bg-light th-sub font-weight-bold" style="width:80px;" readonly value="0.00"></div></td>'
        +'<td><button type="button" class="btn btn-sm btn-danger" onclick="rmRow(\'thr_'+r+'\');calcThTotal()"><i class="fas fa-trash"></i></button></td>'
        +'</tr>'
    );
}
function calcThSub(r){
    var tp  = parseFloat($('#thr_'+r+' .th-tp').val())||0;
    var opt = parseFloat($('select[name="threads['+r+'][option]"]').find(':selected').data('price'))||0;
    var bp  = parseFloat($('#thr_'+r+' .th-bp').val())||0;
    var cp  = parseFloat($('#thr_'+r+' .th-cp').val())||0;
    $('#thst_'+r).val((tp+opt+bp+cp).toFixed(2)); calcThTotal();
}
function calcThTotal(){var t=0;$('.th-sub').each(function(){t+=parseFloat($(this).val())||0;});$('#threadsTotal').text(t.toFixed(2));recalcAll();}

// ══════════════════════════════════════════════════════════
// SECONDARY OPS
// ══════════════════════════════════════════════════════════
var scCnt=0;
function addSecondaryRow(){
    scCnt++;
    clearEmpty('secondaryTableBody');
    var vOpts='<option value="">No Vendor</option>';
    vendorsData.forEach(function(v){vOpts+='<option value="'+v.id+'">'+v.name+'</option>';});
    var r=scCnt;
    $('#secondaryTableBody').append(
        '<tr id="scr_'+r+'">'
        +'<td><input type="text" name="secondary['+r+'][name]" class="form-control form-control-sm" placeholder="e.g. Grinding"></td>'
        +'<td><select name="secondary['+r+'][vendor_id]" class="form-control form-control-sm">'+vOpts+'</select></td>'
        +'<td><select name="secondary['+r+'][price_type]" class="form-control form-control-sm sc-type" onchange="updateScSub('+r+')">'
        +'<option value="lot">Lot</option><option value="per_piece">Per Piece</option><option value="per_pound">Per Pound</option></select></td>'
        +'<td><input type="number" name="secondary['+r+'][qty]" class="form-control form-control-sm sc-qty" value="1" onchange="updateScSub('+r+')"></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="secondary['+r+'][unit_price]" class="form-control sc-unit" value="0" onchange="updateScSub('+r+')"></div></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="secondary['+r+'][sub_total]" id="scst_'+r+'" class="form-control bg-light sc-sub font-weight-bold" value="0.00" readonly></div></td>'
        +'<td><button type="button" class="btn btn-sm btn-danger" onclick="rmRow(\'scr_'+r+'\');calcSecTotal()"><i class="fas fa-trash"></i></button></td>'
        +'</tr>'
    );
}
function updateScSub(r){
    var type = $('select[name="secondary['+r+'][price_type]"]').val();
    var qty  = parseFloat($('input[name="secondary['+r+'][qty]"]').val())||1;
    var unit = parseFloat($('input[name="secondary['+r+'][unit_price]"]').val())||0;
    $('#scst_'+r).val((type==='lot'?unit:qty*unit).toFixed(2)); calcSecTotal();
}
function calcSecTotal(){var t=0;$('.sc-sub').each(function(){t+=parseFloat($(this).val())||0;});$('#secondaryTotal').text(t.toFixed(2));recalcAll();}

// ══════════════════════════════════════════════════════════
// PLATING & HEAT
// ══════════════════════════════════════════════════════════
function togglePlatingFields(){
    var pp = $('#platingPricingType').val()==='per_pound';
    $('#platingEachCount,#platingEachPrice').toggleClass('d-none',pp);
    $('#platingPoundLbs,#platingPoundLot,#platingPoundRate').toggleClass('d-none',!pp);
    calcPlatingTotal();
}
function toggleHeatFields(){
    var pp = $('#heatPricingType').val()==='per_pound';
    $('#heatEachCount,#heatEachPrice').toggleClass('d-none',pp);
    $('#heatPoundLbs,#heatPoundLot,#heatPoundRate').toggleClass('d-none',!pp);
    calcHeatTotal();
}
function calcPlatingTotal(){
    var type = $('#platingPricingType').val();
    var base = 0;
    if(type==='per_each'){
        base = (parseFloat($('input[name="plating_count"]').val())||0) * (parseFloat($('input[name="plating_price_each"]').val())||0);
    } else {
        var lbs = parseFloat($('input[name="plating_total_pounds"]').val())||0;
        var lot = parseFloat($('input[name="plating_lot_charge"]').val())||0;
        var ppl = parseFloat($('input[name="plating_per_pound"]').val())||0;
        base = lbs<=100 ? lot : lot+(lbs-100)*ppl;
    }
    var total = base + (parseFloat($('input[name="plating_salt_testing"]').val())||0)
                     + (parseFloat($('input[name="plating_surcharge"]').val())||0)
                     + (parseFloat($('input[name="plating_standards_price"]').val())||0);
    $('#platingTotal').val(total.toFixed(2)); recalcAll();
}
function calcHeatTotal(){
    var type = $('#heatPricingType').val();
    var base = 0;
    if(type==='per_each'){
        base = (parseFloat($('input[name="heat_count"]').val())||0) * (parseFloat($('input[name="heat_price_each"]').val())||0);
    } else {
        var lbs = parseFloat($('input[name="heat_total_pounds"]').val())||0;
        var lot = parseFloat($('input[name="heat_lot_charge"]').val())||0;
        var ppl = parseFloat($('input[name="heat_per_pound"]').val())||0;
        base = lbs<=100 ? lot : lot+(lbs-100)*ppl;
    }
    var total = base + (parseFloat($('input[name="heat_testing"]').val())||0)
                     + (parseFloat($('input[name="heat_surcharge"]').val())||0);
    $('#heatTotal').val(total.toFixed(2)); recalcAll();
}

// ══════════════════════════════════════════════════════════
// GRAND TOTAL
// ══════════════════════════════════════════════════════════
function recalcAll(){
    var qty = parseInt($('#globalQty').val())||1;
    var parts = {
        material  : parseFloat($('#totalPinPrice').val())||0,
        machine   : parseFloat($('#machineTotal').text())||0,
        operation : parseFloat($('#operationTotal').text())||0,
        items     : parseFloat($('#itemsTotal').text())||0,
        holes     : parseFloat($('#holesTotal').text())||0,
        taps      : parseFloat($('#tapsTotal').text())||0,
        threads   : parseFloat($('#threadsTotal').text())||0,
        secondary : parseFloat($('#secondaryTotal').text())||0,
        plating   : parseFloat($('#platingTotal').val())||0,
        heat      : parseFloat($('#heatTotal').val())||0,
    };
    var sum = 0;
    for(var k in parts){
        sum += parts[k];
        $('#sum_'+k+'_each').text((parts[k]/qty).toFixed(2));
        $('#sum_'+k+'_total').text(parts[k].toFixed(2));
    }
    sum += parseFloat($('#breakInCharge').val())||0;
    var override = parseFloat($('#overridePrice').val())||0;
    var grandEach  = override>0 ? override : (sum/qty);
    // re-add break-in to each as it's already in sum
    var grandTotal = grandEach * qty;
    $('#sum_grand_each').text(grandEach.toFixed(2));
    $('#sum_grand_total').text(grandTotal.toFixed(2));
    $('#grandEachPrice').val(grandEach.toFixed(2));
    $('#grandTotalPrice').val(grandTotal.toFixed(2));
}
</script>
@endpush