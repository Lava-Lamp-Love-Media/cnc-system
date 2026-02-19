@extends('layouts.app')

@section('title', 'Create Material')
@section('page-title', 'Add New Material Specification')

@section('content')

<form method="POST" action="{{ route('company.materials.store') }}" id="materialForm">
    @csrf

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-layer-group"></i> Material Information
            </h3>
        </div>
        <div class="card-body">

            {{-- Row 1: Code + Name --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Material Code <span class="text-danger">*</span></label>
                        <input type="text" name="material_code"
                            class="form-control @error('material_code') is-invalid @enderror"
                            value="{{ old('material_code') }}"
                            placeholder="e.g., MAT-1018-MM" required>
                        @error('material_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Unique identifier for this material specification</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Material Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="e.g., 1018-1022 Steel" required>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Row 2: Type + Unit + Code --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Material Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                            <option value="">-- Select Type --</option>
                            <option value="metal_alloy" {{ old('type') == 'metal_alloy' ? 'selected' : '' }}>Metal / Alloy</option>
                            <option value="plastic"     {{ old('type') == 'plastic'     ? 'selected' : '' }}>Plastic</option>
                            <option value="composite"   {{ old('type') == 'composite'   ? 'selected' : '' }}>Composite</option>
                            <option value="other"       {{ old('type') == 'other'       ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('type')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Unit <span class="text-danger">*</span></label>
                        <select name="unit" class="form-control @error('unit') is-invalid @enderror" required>
                            <option value="">-- Select Unit --</option>
                            <option value="mm"   {{ old('unit') == 'mm'   ? 'selected' : '' }}>mm</option>
                            <option value="inch" {{ old('unit') == 'inch' ? 'selected' : '' }}>inch</option>
                        </select>
                        @error('unit')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Short Code</label>
                        <input type="text" name="code"
                            class="form-control @error('code') is-invalid @enderror"
                            value="{{ old('code') }}"
                            placeholder="e.g., V" maxlength="20">
                        @error('code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Short reference code used in reports</small>
                    </div>
                </div>
            </div>

            {{-- Row 3: Diameter From + To + Density --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Diameter From <span class="text-danger">*</span></label>
                        <input type="number" step="0.00001" name="diameter_from"
                            class="form-control @error('diameter_from') is-invalid @enderror"
                            value="{{ old('diameter_from', '0.00000') }}"
                            placeholder="e.g., 1.60000" required>
                        @error('diameter_from')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Minimum diameter this price applies to</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Diameter To <span class="text-danger">*</span></label>
                        <input type="number" step="0.00001" name="diameter_to"
                            class="form-control @error('diameter_to') is-invalid @enderror"
                            value="{{ old('diameter_to', '0.00000') }}"
                            placeholder="e.g., 3.50000" required>
                        @error('diameter_to')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Maximum diameter this price applies to</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Density (kg/m³) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="density"
                            class="form-control @error('density') is-invalid @enderror"
                            value="{{ old('density', '0.00') }}"
                            placeholder="e.g., 7930.00" required>
                        @error('density')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Material density used for weight calculations</small>
                    </div>
                </div>
            </div>

            {{-- Row 4: Price + Adj Type + Adj + Real Price --}}
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Price (USD) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                            <input type="number" step="0.0001" name="price" id="priceInput"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', '0.00') }}"
                                placeholder="e.g., 4.0000" required onchange="calcRealPrice()">
                        </div>
                        @error('price')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Adj Type <span class="text-danger">*</span></label>
                        <select name="adj_type" id="adjType"
                            class="form-control @error('adj_type') is-invalid @enderror"
                            required onchange="calcRealPrice()">
                            <option value="amount"  {{ old('adj_type', 'amount')  == 'amount'  ? 'selected' : '' }}>Amount ($)</option>
                            <option value="percent" {{ old('adj_type') == 'percent' ? 'selected' : '' }}>Percent (%)</option>
                        </select>
                        @error('adj_type')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Adjustment</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="adjSymbol">$</span>
                            </div>
                            <input type="number" step="0.0001" name="adj" id="adjInput"
                                class="form-control @error('adj') is-invalid @enderror"
                                value="{{ old('adj', '0.00') }}"
                                placeholder="e.g., 2.50" onchange="calcRealPrice()">
                        </div>
                        @error('adj')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Added to price to get real price</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Real Price <small class="text-muted">(auto-calculated)</small></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text bg-success text-white">$</span></div>
                            <input type="text" id="realPriceDisplay"
                                class="form-control bg-light font-weight-bold text-success"
                                readonly value="{{ old('price', '0.00') }}">
                        </div>
                        <input type="hidden" name="real_price" id="realPriceInput" value="{{ old('real_price', '0') }}">
                        <small class="text-muted">Price + Adjustment = Real Price</small>
                    </div>
                </div>
            </div>

            {{-- Row 5: Sort Order + Status --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order"
                            class="form-control"
                            value="{{ old('sort_order', 0) }}"
                            placeholder="0">
                        <small class="text-muted">Display order in dropdowns (lower numbers appear first)</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="active"   {{ old('status', 'active') == 'active'   ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status')           == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            <div class="form-group">
                <label>Notes</label>
                <textarea name="notes" class="form-control" rows="3"
                    placeholder="Optional notes about this material specification">{{ old('notes') }}</textarea>
                <small class="text-muted">e.g., "1018-1022 grade carbon steel, suitable for general machining"</small>
            </div>

        </div>
    </div>

    <div class="card">
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                <i class="fas fa-save"></i> Create Material
            </button>
            <a href="{{ route('company.materials.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
function calcRealPrice() {
    var price   = parseFloat(document.getElementById('priceInput').value)  || 0;
    var adj     = parseFloat(document.getElementById('adjInput').value)    || 0;
    var adjType = document.getElementById('adjType').value;
    var sym     = document.getElementById('adjSymbol');
    var real;

    if (adjType === 'percent') {
        sym.textContent = '%';
        real = price * (1 + adj / 100);
    } else {
        sym.textContent = '$';
        real = price + adj;
    }

    document.getElementById('realPriceDisplay').value = real.toFixed(4);
    document.getElementById('realPriceInput').value   = real.toFixed(4);
}

$(document).ready(function() {
    calcRealPrice();

    $('#materialForm').submit(function() {
        $('#submitBtn').html('<i class="fas fa-spinner fa-spin"></i> Creating...').prop('disabled', true);
    });
});
</script>
@endpush