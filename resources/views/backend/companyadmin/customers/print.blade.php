<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Customer Details - {{ $customer->name }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #667eea;
        }

        .header h1 {
            color: #667eea;
            font-size: 24pt;
            margin-bottom: 5px;
        }

        .header .subtitle {
            color: #666;
            font-size: 10pt;
        }

        .customer-info {
            display: flex;
            margin-bottom: 30px;
        }

        .customer-logo {
            width: 120px;
            margin-right: 30px;
        }

        .customer-logo img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #667eea;
        }

        .customer-details {
            flex: 1;
        }

        .info-row {
            display: flex;
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: bold;
            width: 150px;
            color: #667eea;
        }

        .info-value {
            flex: 1;
        }

        .section-title {
            background: #667eea;
            color: white;
            padding: 8px 15px;
            margin: 25px 0 15px 0;
            font-size: 13pt;
            font-weight: bold;
        }

        .address-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .address-box {
            border: 2px solid #e0e0e0;
            padding: 15px;
            border-radius: 5px;
        }

        .address-box h4 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 11pt;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9pt;
            font-weight: bold;
        }

        .badge-primary {
            background: #667eea;
            color: white;
        }

        .badge-success {
            background: #28a745;
            color: white;
        }

        .badge-warning {
            background: #ffc107;
            color: #333;
        }

        .badge-info {
            background: #17a2b8;
            color: white;
        }

        .badge-secondary {
            background: #6c757d;
            color: white;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 9pt;
            color: #999;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }

        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12pt;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .print-btn:hover {
            background: #5568d3;
        }
    </style>
</head>

<body>

    <button class="print-btn no-print" onclick="window.print()">
        🖨️ Print
    </button>

    <div class="header">
        <h1>CUSTOMER DETAILS</h1>
        <div class="subtitle">{{ Auth::user()->company->name }}</div>
        <div class="subtitle">Generated on {{ now()->format('F d, Y h:i A') }}</div>
    </div>

    <div class="customer-info">
        <div class="customer-logo">
            <img src="{{ $customer->logo_url }}" alt="{{ $customer->name }}">
        </div>
        <div class="customer-details">
            <h2 style="color: #667eea; margin-bottom: 15px;">{{ $customer->name }}</h2>

            <div class="info-row">
                <div class="info-label">Customer Code:</div>
                <div class="info-value"><strong>{{ $customer->customer_code }}</strong></div>
            </div>

            <div class="info-row">
                <div class="info-label">Type:</div>
                <div class="info-value">
                    <span class="badge badge-{{ $customer->customer_type == 'company' ? 'primary' : 'info' }}">
                        {{ ucfirst($customer->customer_type) }}
                    </span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Status:</div>
                <div class="info-value">
                    <span class="badge badge-{{ $customer->status == 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($customer->status) }}
                    </span>
                </div>
            </div>

            @if ($customer->email)
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $customer->email }}</div>
                </div>
            @endif

            @if ($customer->phone)
                <div class="info-row">
                    <div class="info-label">Phone:</div>
                    <div class="info-value">{{ $customer->phone }}</div>
                </div>
            @endif
        </div>
    </div>

    <div class="section-title">FINANCIAL INFORMATION</div>

    <div class="info-row">
        <div class="info-label">Credit Limit:</div>
        <div class="info-value">
            @if ($customer->credit_limit)
                ${{ number_format($customer->credit_limit, 2) }}
            @else
                Not set
            @endif
        </div>
    </div>

    <div class="info-row">
        <div class="info-label">Payment Terms:</div>
        <div class="info-value">Net {{ $customer->payment_terms_days }} days</div>
    </div>

    @if ($customer->tax_id)
        <div class="info-row">
            <div class="info-label">Tax ID:</div>
            <div class="info-value">{{ $customer->tax_id }}</div>
        </div>
    @endif

    @if ($customer->addresses->count() > 0)
        <div class="section-title">ADDRESSES</div>

        <div class="address-grid">
            @foreach ($customer->addresses as $address)
                <div class="address-box">
                    <h4>
                        {{ ucfirst(str_replace('_', ' ', $address->address_type)) }}
                        @if ($address->is_default)
                            <span class="badge badge-warning">Default</span>
                        @endif
                    </h4>

                    @if ($address->contact_person)
                        <div><strong>{{ $address->contact_person }}</strong></div>
                    @endif

                    <div>{{ $address->address_line_1 }}</div>
                    @if ($address->address_line_2)
                        <div>{{ $address->address_line_2 }}</div>
                    @endif
                    <div>{{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}</div>
                    <div>{{ $address->country }}</div>

                    @if ($address->phone)
                        <div style="margin-top: 5px;">📞 {{ $address->phone }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    @if ($customer->notes)
        <div class="section-title">NOTES</div>
        <div style="padding: 15px; background: #f8f9fa; border-radius: 5px;">
            {{ $customer->notes }}
        </div>
    @endif

    <div class="footer no-print">
        <p>{{ Auth::user()->company->name }} • Customer Management System</p>
        <p>This is a system-generated document</p>
    </div>

</body>

</html>
