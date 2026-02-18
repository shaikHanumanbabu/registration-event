<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 30px 0;
        }

        .registration-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 700px;
            margin: 0 auto;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            padding: 10px 15px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 40px;
            font-weight: 600;
            border-radius: 8px;
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            margin: -40px -40px 30px -40px;
        }

        .current-receipt {
            max-width: 200px;
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="registration-card">
            <div class="card-header">
                <h2 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Registration</h2>
                <p class="mb-0 mt-2 opacity-75">Customer No: {{ $registration->customer_no }}</p>
            </div>

            <div class="mb-3">
                <a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('registrations.update', $registration->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Customer Type <span class="text-danger">*</span></label>
                        <select name="customer_type" id="customer_type" class="form-select" required>
                            <option value="new" {{ old('customer_type', $registration->customer_type) == 'new' ? 'selected' : '' }}>New</option>
                            <option value="existing" {{ old('customer_type', $registration->customer_type) == 'existing' ? 'selected' : '' }}>Existing</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Is Family Members Included? <span class="text-danger">*</span></label>
                        <select name="family_included" id="family_included" class="form-select" required>
                            <option value="yes" {{ old('family_included', $registration->family_included) == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('family_included', $registration->family_included) == 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>

                <div id="familyCountSection" style="display: none;">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Adults Count</label>
                            <input type="number" name="adults_count" id="adults_count" class="form-control" min="0" value="{{ old('adults_count', $registration->adults_count) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Child Count</label>
                            <input type="number" name="child_count" id="child_count" class="form-control" min="0" value="{{ old('child_count', $registration->child_count) }}">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $registration->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $registration->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $registration->phone) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $registration->address) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">State <span class="text-danger">*</span></label>
                        <input type="text" name="state" class="form-control" value="{{ old('state', $registration->state) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Any Text / Notes</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $registration->notes) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Total Amount <span class="text-danger">*</span></label>
                    <input type="number" name="total_amount" class="form-control" step="0.01" min="0" value="{{ old('total_amount', $registration->total_amount) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Payment Type <span class="text-danger">*</span></label>
                    <select name="payment_type" class="form-select" required>
                        <option value="phonepe" {{ old('payment_type', $registration->payment_type) == 'phonepe' ? 'selected' : '' }}>PhonePe</option>
                        <option value="gpay" {{ old('payment_type', $registration->payment_type) == 'gpay' ? 'selected' : '' }}>GPay</option>
                        <option value="others" {{ old('payment_type', $registration->payment_type) == 'others' ? 'selected' : '' }}>Others</option>
                    </select>
                </div>

                @if ($registration->payment_receipt)
                <div class="mb-3">
                    <label class="form-label">Current Payment Receipt</label>
                    <div>
                        <img src="{{ asset('storage/' . $registration->payment_receipt) }}" class="current-receipt" alt="Receipt">
                    </div>
                </div>
                @endif

                <div class="mb-4">
                    <label class="form-label">Upload New Payment Receipt (Optional)</label>
                    <input type="file" name="payment_receipt" class="form-control" accept="image/*">
                    <small class="text-muted">Leave blank to keep existing receipt</small>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-submit">
                        <i class="fas fa-save me-2"></i>Update Registration
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const customerType = document.getElementById('customer_type');
        const familyIncluded = document.getElementById('family_included');
        const familyCountSection = document.getElementById('familyCountSection');
        const adultsCount = document.getElementById('adults_count');
        const childCount = document.getElementById('child_count');

        function updateFamilyFields() {
            const type = customerType.value;
            const family = familyIncluded.value;


            if (family === 'yes' && type === 'existing') {
                familyCountSection.style.display = 'block';
            } else if (family === 'no' && type === 'new') {
                familyCountSection.style.display = 'none';
                adultsCount.value = '';
                childCount.value = '';
            } else if (family === 'yes') {
                familyCountSection.style.display = 'block';
            } else {
                familyCountSection.style.display = 'none';
                adultsCount.value = '';
                childCount.value = '';
            }
        }

        customerType.addEventListener('change', updateFamilyFields);
        familyIncluded.addEventListener('change', updateFamilyFields);
        updateFamilyFields();
    </script>
</body>

</html>