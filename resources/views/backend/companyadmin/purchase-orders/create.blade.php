@extends('layouts.app')

@section('page-title', 'Create Purchase Order')

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('company.purchase-orders.store') }}" method="POST" id="purchaseOrderForm" enctype="multipart/form-data">
            @csrf
            
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Create Purchase Order</h3>
                        <a href="{{ route('company.purchase-orders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Vendor & Basic Info -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="vendor_id">Vendor <span class="text-danger">*</span></label>
                                <select name="vendor_id" id="vendor_id" class="form-control @error('vendor_id') is-invalid @enderror" required>
                                    <option value="">Select Vendor</option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                            {{ $vendor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('vendor_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="po_number">Purchase Order Number <span class="text-danger">*</span></label>
                                <input type="text" name="po_number" id="po_number" 
                                       class="form-control @error('po_number') is-invalid @enderror" 
                                       value="{{ old('po_number', $poNumber) }}" required readonly>
                                @error('po_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type">Type <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="type_draft" name="type" value="draft" 
                                                   class="custom-control-input" {{ old('type', 'draft') == 'draft' ? 'checked' : '' }} required>
                                            <label class="custom-control-label" for="type_draft">Draft</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="type_first_article" name="type" value="first_article" 
                                                   class="custom-control-input" {{ old('type') == 'first_article' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="type_first_article">First Article</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="type_production" name="type" value="production" 
                                                   class="custom-control-input" {{ old('type') == 'production' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="type_production">Production</label>
                                        </div>
                                    </div>
                                </div>
                                @error('type')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="order_date">Order Date <span class="text-danger">*</span></label>
                                <input type="date" name="order_date" id="order_date" 
                                       class="form-control @error('order_date') is-invalid @enderror" 
                                       value="{{ old('order_date', date('Y-m-d')) }}" required>
                                @error('order_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="expected_received_date">Expected Received Date</label>
                                <input type="date" name="expected_received_date" id="expected_received_date" 
                                       class="form-control @error('expected_received_date') is-invalid @enderror" 
                                       value="{{ old('expected_received_date') }}">
                                @error('expected_received_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="payment_terms">Payment Terms</label>
                                <select name="payment_terms" id="payment_terms" class="form-control @error('payment_terms') is-invalid @enderror">
                                    <option value="">Select Payment Terms</option>
                                    <option value="net_15" {{ old('payment_terms') == 'net_15' ? 'selected' : '' }}>Net 15</option>
                                    <option value="net_30" {{ old('payment_terms') == 'net_30' ? 'selected' : '' }}>Net 30</option>
                                    <option value="net_45" {{ old('payment_terms') == 'net_45' ? 'selected' : '' }}>Net 45</option>
                                    <option value="net_60" {{ old('payment_terms') == 'net_60' ? 'selected' : '' }}>Net 60</option>
                                    <option value="due_on_receipt" {{ old('payment_terms') == 'due_on_receipt' ? 'selected' : '' }}>Due on Receipt</option>
                                </select>
                                @error('payment_terms')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cage_number">Cage Number</label>
                                <input type="text" name="cage_number" id="cage_number" 
                                       class="form-control @error('cage_number') is-invalid @enderror" 
                                       value="{{ old('cage_number') }}">
                                @error('cage_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ship_to">Ship To</label>
                                <textarea name="ship_to" id="ship_to" rows="3" 
                                          class="form-control @error('ship_to') is-invalid @enderror" 
                                          placeholder="Shipping address...">{{ old('ship_to') }}</textarea>
                                @error('ship_to')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
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
                    </div>

                    <hr>

                    <!-- Items Section -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Items</h5>
                                <button type="button" class="btn btn-primary" id="addItemBtn">
                                    <i class="fas fa-plus mr-1"></i> Add Item
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="itemsTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 20%;">Select Item</th>
                                            <th style="width: 10%;">Item SKU</th>
                                            <th style="width: 8%;">Count Of</th>
                                            <th style="width: 10%;">Unit</th>
                                            <th style="width: 8%;">Count Price</th>
                                            <th style="width: 8%;">Unit Price</th>
                                            <th style="width: 8%;">Quantity</th>
                                            <th style="width: 10%;">Total</th>
                                            <th style="width: 8%;">Inventory</th>
                                            <th style="width: 5%;">Taxable</th>
                                            <th style="width: 5%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsContainer">
                                        <!-- Items will be added here dynamically -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7" class="text-right"><strong>Item Total:</strong></td>
                                            <td><strong>$<span id="itemTotal">0.00</span></strong></td>
                                            <td colspan="3"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Discount & Tax -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="discount_type">Discount Type</label>
                                <select name="discount_type" id="discount_type" class="form-control" onchange="calculateTotals()">
                                    <option value="flat">Flat</option>
                                    <option value="percentage">Percentage</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="discount">Discount</label>
                                <input type="number" name="discount" id="discount" step="0.01" 
                                       class="form-control" value="0" onchange="calculateTotals()">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tax">Tax (%)</label>
                                <input type="number" name="tax" id="tax" step="0.01" 
                                       class="form-control" value="0" onchange="calculateTotals()">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Grand Total</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" id="grandTotal" class="form-control" readonly value="0.00">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Description & Notes -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" rows="3" 
                                          class="form-control" placeholder="Purchase order description...">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="current_stock_level">Current Stock Level</label>
                                <input type="text" name="current_stock_level" id="current_stock_level" 
                                       class="form-control" value="{{ old('current_stock_level') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="additional_notes">Additional Notes</label>
                                <textarea name="additional_notes" id="additional_notes" rows="3" 
                                          class="form-control" placeholder="Any additional notes...">{{ old('additional_notes') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="purchase_level">Purchase Level</label>
                                <input type="text" name="purchase_level" id="purchase_level" 
                                       class="form-control" value="{{ old('purchase_level') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Attachments -->
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Attachments</label>
                                <small class="text-muted">Drawings / Photos (Drag & Drop or Click)</small>
                                <div class="custom-file">
                                    <input type="file" name="attachments[]" id="attachments" 
                                           class="custom-file-input" multiple 
                                           accept=".pdf,.jpg,.jpeg,.png,.dwg,.dxf">
                                    <label class="custom-file-label" for="attachments">Choose files</label>
                                </div>
                                <small class="form-text text-muted">Max 10MB per file. Formats: PDF, JPG, PNG, DWG, DXF</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('company.purchase-orders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check mr-1"></i> Create Purchase Order
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="quickAddItemModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="quickAddItemForm">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle mr-2"></i> Quick Add Item
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="quickAddItemError" class="alert alert-danger d-none"></div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quick_name">Item Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="quick_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quick_sku">SKU <span class="text-danger">*</span></label>
                                <input type="text" name="sku" id="quick_sku" class="form-control" required>
                                <small class="text-muted">Must be unique</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="quick_description">Description</label>
                                <textarea name="description" id="quick_description" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quick_class">Class <span class="text-danger">*</span></label>
                                <select name="class" id="quick_class" class="form-control" required>
                                    <option value="">Select Class</option>
                                    <option value="tooling">Tooling</option>
                                    <option value="sellable">Sellable</option>
                                    <option value="raw_stock">Raw Stock</option>
                                    <option value="consommable">Consumable</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quick_unit">Unit <span class="text-danger">*</span></label>
                                <select name="unit" id="quick_unit" class="form-control" required>
                                    <option value="">Select Unit</option>
                                    <option value="each">Each</option>
                                    <option value="kg">Kilogram (kg)</option>
                                    <option value="lb">Pound (lb)</option>
                                    <option value="meter">Meter</option>
                                    <option value="foot">Foot</option>
                                    <option value="liter">Liter</option>
                                    <option value="gallon">Gallon</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quick_cost_price">Cost Price</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="cost_price" id="quick_cost_price" 
                                           step="0.01" class="form-control" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quick_warehouse_id">Warehouse</label>
                                <select name="warehouse_id" id="quick_warehouse_id" class="form-control">
                                    <option value="">Select Warehouse</option>
                                    @foreach($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quick_stock_min">Minimum Stock</label>
                                <input type="number" name="stock_min" id="quick_stock_min" 
                                       class="form-control" value="0" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quick_reorder_level">Re-order Level</label>
                                <input type="number" name="reorder_level" id="quick_reorder_level" 
                                       class="form-control" value="0" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="is_inventory" id="quick_is_inventory" 
                                       class="custom-control-input" value="1" checked>
                                <label class="custom-control-label" for="quick_is_inventory">
                                    Track inventory for this item
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="quickAddItemBtn">
                        <i class="fas fa-check mr-1"></i> Add Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    let itemIndex = 0;
    let items = @json($items); // Convert to array for easier manipulation

    // Add Item Row
    document.getElementById('addItemBtn').addEventListener('click', function() {
        itemIndex++;
        
        let itemOptions = '<option value="">Select Item</option>';
        items.forEach(item => {
            itemOptions += `<option value="${item.id}" 
                                    data-sku="${item.sku}" 
                                    data-unit="${item.unit}" 
                                    data-price="${item.cost_price}">
                                ${item.name}
                            </option>`;
        });

        const row = `
            <tr id="item-${itemIndex}">
                <td>
                    <div class="input-group">
                        <select name="items[${itemIndex}][item_id]" class="form-control item-select" onchange="updateItemRow(${itemIndex})" required>
                            ${itemOptions}
                        </select>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-success btn-sm" onclick="openQuickAddModal(${itemIndex})" title="Add New Item">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </td>
                <td><input type="text" name="items[${itemIndex}][item_sku]" class="form-control form-control-sm item-sku" readonly></td>
                <td><input type="number" name="items[${itemIndex}][count_of]" class="form-control form-control-sm" value="1" min="1"></td>
                <td>
                    <select name="items[${itemIndex}][unit]" class="form-control form-control-sm item-unit">
                        <option value="each">Each</option>
                        <option value="kg">Kg</option>
                        <option value="lb">Lb</option>
                    </select>
                </td>
                <td><input type="number" name="items[${itemIndex}][count_price]" class="form-control form-control-sm" step="0.01" value="0"></td>
                <td><input type="number" name="items[${itemIndex}][unit_price]" class="form-control form-control-sm item-price" step="0.01" onchange="calculateItemTotal(${itemIndex})" required></td>
                <td><input type="number" name="items[${itemIndex}][quantity]" class="form-control form-control-sm item-qty" value="1" min="1" onchange="calculateItemTotal(${itemIndex})" required></td>
                <td><input type="text" class="form-control form-control-sm item-total" readonly value="0.00"></td>
                <td class="text-center">
                    <input type="checkbox" name="items[${itemIndex}][inventory]" value="1" checked>
                </td>
                <td class="text-center">
                    <input type="checkbox" name="items[${itemIndex}][taxable]" value="1" checked>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(${itemIndex})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            <tr id="item-${itemIndex}-extra" class="bg-light">
                <td colspan="11">
                    <div class="row">
                        <div class="col-md-2">
                            <label class="small">Discount Type</label>
                            <select name="items[${itemIndex}][discount_type]" class="form-control form-control-sm">
                                <option value="flat">Flat</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="small">Discount</label>
                            <input type="number" name="items[${itemIndex}][discount]" class="form-control form-control-sm" step="0.01" value="0" onchange="calculateItemTotal(${itemIndex})">
                        </div>
                        <div class="col-md-2">
                            <label class="small">Receiving Status</label>
                            <select name="items[${itemIndex}][receiving_status]" class="form-control form-control-sm">
                                <option value="">Select</option>
                                <option value="pending">Pending</option>
                                <option value="partial">Partial</option>
                                <option value="received">Received</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="small">Commodity/Class</label>
                            <input type="text" name="items[${itemIndex}][commodity_class]" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-4">
                            <label class="small">Notes</label>
                            <input type="text" name="items[${itemIndex}][notes]" class="form-control form-control-sm" placeholder="Item notes...">
                        </div>
                    </div>
                </td>
            </tr>
        `;

        document.getElementById('itemsContainer').insertAdjacentHTML('beforeend', row);
        calculateTotals();
    });

    // Store current row index for quick add
    let currentQuickAddRowIndex = null;

    // Open Quick Add Modal
    function openQuickAddModal(rowIndex) {
        currentQuickAddRowIndex = rowIndex;
        $('#quickAddItemModal').modal('show');
        // Reset form
        document.getElementById('quickAddItemForm').reset();
        document.getElementById('quickAddItemError').classList.add('d-none');
    }

    // Quick Add Item Form Submit
    document.getElementById('quickAddItemForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = document.getElementById('quickAddItemBtn');
        const errorDiv = document.getElementById('quickAddItemError');
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Adding...';
        errorDiv.classList.add('d-none');
        
        // AJAX request to create item
        fetch('{{ route("company.items.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add new item to items array
                items.push(data.item);
                
                // Update all item dropdowns
                updateAllItemDropdowns();
                
                // Auto-select the new item in current row
                if (currentQuickAddRowIndex !== null) {
                    const selectElement = document.querySelector(`#item-${currentQuickAddRowIndex} .item-select`);
                    if (selectElement) {
                        selectElement.value = data.item.id;
                        updateItemRow(currentQuickAddRowIndex);
                    }
                }
                
                // Close modal
                $('#quickAddItemModal').modal('hide');
                
                // Show success message
                toastr.success(data.message || 'Item added successfully!');
                
                // Reset form
                document.getElementById('quickAddItemForm').reset();
            } else {
                // Show error
                errorDiv.textContent = data.message || 'Failed to add item';
                errorDiv.classList.remove('d-none');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            errorDiv.textContent = 'An error occurred while adding the item';
            errorDiv.classList.remove('d-none');
        })
        .finally(() => {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check mr-1"></i> Add Item';
        });
    });

    // Update all item dropdowns with new item
    function updateAllItemDropdowns() {
        document.querySelectorAll('.item-select').forEach(select => {
            const currentValue = select.value;
            
            // Rebuild options
            let itemOptions = '<option value="">Select Item</option>';
            items.forEach(item => {
                itemOptions += `<option value="${item.id}" 
                                        data-sku="${item.sku}" 
                                        data-unit="${item.unit}" 
                                        data-price="${item.cost_price}">
                                    ${item.name}
                                </option>`;
            });
            
            select.innerHTML = itemOptions;
            
            // Restore previous selection if it exists
            if (currentValue) {
                select.value = currentValue;
            }
        });
    }

    // Update Item Row when item is selected
    function updateItemRow(index) {
        const select = document.querySelector(`#item-${index} .item-select`);
        const option = select.options[select.selectedIndex];
        
        if (option.value) {
            document.querySelector(`#item-${index} .item-sku`).value = option.dataset.sku;
            document.querySelector(`#item-${index} .item-unit`).value = option.dataset.unit;
            document.querySelector(`#item-${index} .item-price`).value = option.dataset.price;
            calculateItemTotal(index);
        }
    }

    // Calculate Item Total
    function calculateItemTotal(index) {
        const row = document.getElementById(`item-${index}`);
        const price = parseFloat(row.querySelector('.item-price').value) || 0;
        const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
        const total = price * qty;
        
        row.querySelector('.item-total').value = total.toFixed(2);
        calculateTotals();
    }

    // Remove Item
    function removeItem(index) {
        document.getElementById(`item-${index}`).remove();
        document.getElementById(`item-${index}-extra`).remove();
        calculateTotals();
    }

    // Calculate Totals
    function calculateTotals() {
        let subtotal = 0;
        
        document.querySelectorAll('.item-total').forEach(input => {
            subtotal += parseFloat(input.value) || 0;
        });

        const discountType = document.getElementById('discount_type').value;
        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const taxRate = parseFloat(document.getElementById('tax').value) || 0;

        let discountAmount = 0;
        if (discountType === 'percentage') {
            discountAmount = (subtotal * discount) / 100;
        } else {
            discountAmount = discount;
        }

        const afterDiscount = subtotal - discountAmount;
        const taxAmount = (afterDiscount * taxRate) / 100;
        const grandTotal = afterDiscount + taxAmount;

        document.getElementById('itemTotal').textContent = subtotal.toFixed(2);
        document.getElementById('grandTotal').value = grandTotal.toFixed(2);
    }

    // Custom file input label
    document.getElementById('attachments')?.addEventListener('change', function() {
        const fileCount = this.files.length;
        const label = this.nextElementSibling;
        label.textContent = fileCount > 0 ? `${fileCount} file(s) selected` : 'Choose files';
    });

    // Add at least one item on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addItemBtn').click();
    });
</script>
@endpush