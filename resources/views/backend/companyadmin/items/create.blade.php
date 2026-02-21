@extends('layouts.app')

@section('page-title', 'Create Item')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Create Item</h3>
                    <a href="{{ route('company.items.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to List
                    </a>
                </div>
            </div>

            <form action="{{ route('company.items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs mb-4" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#basic-info">
                                <i class="fas fa-info-circle mr-1"></i> Basic Info
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pricing">
                                <i class="fas fa-dollar-sign mr-1"></i> Pricing
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#inventory">
                                <i class="fas fa-warehouse mr-1"></i> Inventory
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">

                        <!-- Basic Info Tab -->
                        <div class="tab-pane fade show active" id="basic-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Item Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sku">SKU <span class="text-danger">*</span></label>
                                        <input type="text" name="sku" id="sku"
                                               class="form-control @error('sku') is-invalid @enderror"
                                               value="{{ old('sku') }}" required>
                                        @error('sku')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" rows="3"
                                                  class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="class">Class <span class="text-danger">*</span></label>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="class_tooling" name="class" value="tooling"
                                                           class="custom-control-input" {{ old('class') == 'tooling' ? 'checked' : '' }} required>
                                                    <label class="custom-control-label" for="class_tooling">
                                                        <i class="fas fa-tools text-info"></i> Tooling
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="class_sellable" name="class" value="sellable"
                                                           class="custom-control-input" {{ old('class') == 'sellable' ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="class_sellable">
                                                        <i class="fas fa-shopping-cart text-success"></i> Sellable
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="class_raw_stock" name="class" value="raw_stock"
                                                           class="custom-control-input" {{ old('class') == 'raw_stock' ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="class_raw_stock">
                                                        <i class="fas fa-cubes text-warning"></i> Raw Stock
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="class_consommable" name="class" value="consommable"
                                                           class="custom-control-input" {{ old('class') == 'consommable' ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="class_consommable">
                                                        <i class="fas fa-box text-primary"></i> Consommable
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @error('class')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="unit">Unit <span class="text-danger">*</span></label>
                                        <select name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror" required>
                                            <option value="">Select Unit</option>
                                            <option value="each"   {{ old('unit') == 'each'   ? 'selected' : '' }}>Each</option>
                                            <option value="kg"     {{ old('unit') == 'kg'     ? 'selected' : '' }}>Kilogram (kg)</option>
                                            <option value="lb"     {{ old('unit') == 'lb'     ? 'selected' : '' }}>Pound (lb)</option>
                                            <option value="meter"  {{ old('unit') == 'meter'  ? 'selected' : '' }}>Meter</option>
                                            <option value="foot"   {{ old('unit') == 'foot'   ? 'selected' : '' }}>Foot</option>
                                            <option value="liter"  {{ old('unit') == 'liter'  ? 'selected' : '' }}>Liter</option>
                                            <option value="gallon" {{ old('unit') == 'gallon' ? 'selected' : '' }}>Gallon</option>
                                        </select>
                                        @error('unit')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- ── STATUS ── -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                            <option value="active"       {{ old('status', 'active') == 'active'       ? 'selected' : '' }}>Active</option>
                                            <option value="inactive"     {{ old('status') == 'inactive'               ? 'selected' : '' }}>Inactive</option>
                                            <option value="discontinued" {{ old('status') == 'discontinued'           ? 'selected' : '' }}>Discontinued</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="image">Item Image</label>
                                        <div class="custom-file">
                                            <input type="file" name="image" id="image"
                                                   class="custom-file-input @error('image') is-invalid @enderror"
                                                   accept="image/*">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                        <small class="form-text text-muted">Max size: 2MB. Formats: JPG, PNG, GIF</small>
                                        @error('image')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div id="imagePreview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Tab -->
                        <div class="tab-pane fade" id="pricing">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cost_price">Cost Price</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" name="cost_price" id="cost_price" step="0.01"
                                                   class="form-control @error('cost_price') is-invalid @enderror"
                                                   value="{{ old('cost_price', 0) }}">
                                        </div>
                                        @error('cost_price')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sell_price">Sell Price</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" name="sell_price" id="sell_price" step="0.01"
                                                   class="form-control @error('sell_price') is-invalid @enderror"
                                                   value="{{ old('sell_price', 0) }}">
                                        </div>
                                        @error('sell_price')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="is_taxable" id="is_taxable"
                                               class="custom-control-input" value="1"
                                               {{ old('is_taxable', true) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_taxable">
                                            This item is taxable
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Inventory Tab -->
                        <div class="tab-pane fade" id="inventory">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="custom-control custom-switch mb-3">
                                        <input type="checkbox" name="is_inventory" id="is_inventory"
                                               class="custom-control-input" value="1"
                                               {{ old('is_inventory', true) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_inventory">
                                            <strong>Track inventory for this item</strong>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="warehouse_id">Warehouse</label>
                                        <select name="warehouse_id" id="warehouse_id" class="form-control @error('warehouse_id') is-invalid @enderror">
                                            <option value="">Select Warehouse</option>
                                            @foreach($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                                    {{ $warehouse->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('warehouse_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="count">Initial Stock Count</label>
                                        <input type="number" name="count" id="count"
                                               class="form-control @error('count') is-invalid @enderror"
                                               value="{{ old('count', 0) }}" min="0">
                                        @error('count')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stock_min">Minimum Stock</label>
                                        <input type="number" name="stock_min" id="stock_min"
                                               class="form-control @error('stock_min') is-invalid @enderror"
                                               value="{{ old('stock_min', 0) }}" min="0">
                                        <small class="form-text text-muted">Alert when stock reaches this level</small>
                                        @error('stock_min')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reorder_level">Re-order Level</label>
                                        <input type="number" name="reorder_level" id="reorder_level"
                                               class="form-control @error('reorder_level') is-invalid @enderror"
                                               value="{{ old('reorder_level', 0) }}" min="0">
                                        <small class="form-text text-muted">Automatically create purchase order</small>
                                        @error('reorder_level')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes">Notes</label>
                                        <textarea name="notes" id="notes" rows="3"
                                                  class="form-control @error('notes') is-invalid @enderror"
                                                  placeholder="Additional notes about this item...">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>{{-- /tab-content --}}
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('company.items.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check mr-1"></i> Create Item
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagePreview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px;">`;
            };
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '';
        }
    });

    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });
</script>
@endpush