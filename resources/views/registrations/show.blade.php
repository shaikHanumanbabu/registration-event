<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 30px 0;
        }

        .details-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            margin: -40px -40px 30px -40px;
        }

        .detail-row {
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-label {
            font-weight: 600;
            color: #666;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 1.1rem;
            color: #333;
        }


        .qr-code-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
        }

        .qr-code-img {
            max-width: 300px;
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            background: white;
        }

        .receipt-img {
            max-width: 400px;
            border: 2px solid #ddd;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="details-card">
            <div class="card-header">
                <h2 class="mb-0"><i class="fas fa-file-alt me-2"></i>Registration Details</h2>
                <p class="mb-0 mt-2 opacity-75">Customer No: {{ $registration->customer_no }}</p>
            </div>

            <div class="mb-4">
                <a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
                <a href="{{ route('registrations.edit', $registration->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="detail-label">Customer Number</div>
                        <div class="detail-value text-primary fw-bold">{{ $registration->customer_no }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="detail-label">Customer Type</div>
                        <div class="detail-value">
                            <span class="badge bg-{{ $registration->customer_type == 'new' ? 'success' : 'info' }} fs-6">
                                {{ ucfirst($registration->customer_type) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="detail-label">Family Members Included</div>
                        <div class="detail-value">
                            <span class="badge bg-{{ $registration->family_included == 'yes' ? 'primary' : 'secondary' }} fs-6">
                                {{ ucfirst($registration->family_included) }}
                            </span>
                        </div>
                    </div>
                </div>

                @if ($registration->family_included == 'yes' && ($registration->adults_count || $registration->child_count))
                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="detail-label">Family Count</div>
                        <div class="detail-value">
                            Adults: <strong>{{ $registration->adults_count ?? 0 }}</strong>,
                            Children: <strong>{{ $registration->child_count ?? 0 }}</strong>
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-md-12">
                    <div class="detail-row">
                        <div class="detail-label">Full Name</div>
                        <div class="detail-value">{{ $registration->name }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="detail-label">Email</div>
                        <div class="detail-value">{{ $registration->email }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="detail-label">Phone</div>
                        <div class="detail-value">{{ $registration->phone }}</div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="detail-row">
                        <div class="detail-label">Address</div>
                        <div class="detail-value">{{ $registration->address }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-row">
                        <div class="detail-label">State</div>
                        <div class="detail-value">{{ $registration->state }}</div>
                    </div>
                </div>

                @if ($registration->notes)
                <div class="col-md-12">
                    <div class="detail-row">
                        <div class="detail-label">Notes</div>
                        <div class="detail-value">{{ $registration->notes }}</div>
                    </div>
                </div>
                @endif

                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="detail-label">Total Amount</div>
                        <div class="detail-value text-success fw-bold fs-4">₹{{ number_format($registration->total_amount, 2) }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="detail-label">Payment Type</div>
                        <div class="detail-value">
                            <span class="badge bg-warning text-dark fs-6">{{ ucfirst($registration->payment_type) }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="detail-label">Registration Date</div>
                        <div class="detail-value">{{ $registration->created_at->format('d F Y, h:i A') }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="detail-label">Last Updated</div>
                        <div class="detail-value">{{ $registration->updated_at->format('d F Y, h:i A') }}</div>
                    </div>
                </div>
            </div>

            @if ($registration->qr_code)
            <div class="qr-code-section mt-4">
                <h5 class="mb-3"><i class="fas fa-qrcode me-2"></i>Registration QR Code</h5>
                <img src="{{ asset('storage/' . $registration->qr_code) }}" class="qr-code-img" alt="QR Code">
                <p class="text-muted mt-3 mb-0">Scan this QR code to view registration details</p>
            </div>
            @endif

            @if ($registration->payment_receipt)
            <div class="mt-4">
                <h5 class="mb-3"><i class="fas fa-receipt me-2"></i>Payment Receipt</h5>
                <img src="{{ asset('storage/' . $registration->payment_receipt) }}" class="receipt-img" alt="Payment Receipt">
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>