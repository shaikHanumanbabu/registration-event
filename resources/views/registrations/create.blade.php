@extends('layouts.app')

@section('title', 'New Registration')

@section('content')
<div class="container">
    <div class="registration-card">
        <div class="card-header">
            <h2 class="mb-0">
                <i class="fas fa-user-plus me-2"></i>New Registration
            </h2>
        </div>

        <div class="nav-buttons">
            <a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list me-2"></i>View All Registrations
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

        <form action="{{ route('registrations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- KEEP ALL YOUR FORM HTML HERE --}}
            {{-- (Everything inside <form> from your original file goes here unchanged) --}}

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Customer Type <span class="text-danger">*</span></label>
                    <select name="customer_type" id="customer_type" class="form-select" required>
                        <option value="">Select Type</option>
                        <option value="new" {{ old('customer_type') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="existing" {{ old('customer_type') == 'existing' ? 'selected' : '' }}>Existing</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Is Family Members Included? <span class="text-danger">*</span></label>
                    <select name="family_included" id="family_included" class="form-select" required>
                        <option value="">Select Option</option>
                        <option value="yes" {{ old('family_included') == 'yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ old('family_included') == 'no' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>

            <!-- create a form -->


            <!-- Family Count Fields (Conditionally shown) -->
            <div id="familyCountSection" style="display: none;">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Adults Count</label>
                        <input type="number" name="adults_count" id="adults_count" class="form-control" min="0" value="{{ old('adults_count') }}" placeholder="Enter number of adults">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Child Count</label>
                        <input type="number" name="child_count" id="child_count" class="form-control" min="0" value="{{ old('child_count') }}" placeholder="Enter number of children">
                    </div>
                </div>
            </div>

            <!-- if customer type is existing we need to display this input -->
            <div class="mb-3" id="customerIdSection" style="display: none;">
                <label class="form-label">Enter Customer Id </label>
                <input type="text" name="customer_id" id="customer_id" class="form-control" value="{{ old('customer_id') }}" placeholder="Enter customer id">
            </div>

            <div class="mb-3">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter full name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Enter email address" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone <span class="text-danger">*</span></label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Enter phone number" required>
            </div>

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Address <span class="text-danger">*</span></label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Enter complete address" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">State <span class="text-danger">*</span></label>
                    <input type="text" name="state" class="form-control" value="{{ old('state') }}" placeholder="Enter state" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Any Text / Notes</label>
                <textarea name="notes" class="form-control" rows="3" placeholder="Enter any additional notes">{{ old('notes') }}</textarea>
            </div>
            <!-- QR Code and Payment Section -->
            <div class="qr-section">
                <h5 class="mb-3"><i class="fas fa-qrcode me-2"></i>Payment Information</h5>
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="qr-placeholder">
                            <div class="text-center">
                                @if(file_exists(public_path('images/payment-qr2.png')))
                                <img src="{{ asset('images/payment-qr2.png') }}"
                                    alt="Payment QR Code"
                                    class="img-fluid"
                                    style="max-width: 100%; max-height: 200px; width: auto; height: auto; object-fit: contain;">
                                <p class="mt-2 mb-0 text-muted small">Scan to Pay<br>PhonePe / GPay</p>
                                @else
                                <i class="fas fa-qrcode fa-4x text-muted"></i>
                                <p class="mt-2 mb-0 text-muted small">Scan to Pay<br>PhonePe / GPay</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Total Amount </label>
                            <input type="text" readonly id="total_amount" name="total_amount" class="form-control" step="0.01" min="0" value="{{ old('total_amount') }}" placeholder="Enter amount" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Payment Receipt</label>
                <input type="file" name="payment_receipt" class="form-control" accept="image/*">
                <small class="text-muted">Upload screenshot of payment (JPEG, PNG - Max 2MB)</small>
            </div>

            <div class="mb-4">
                <label class="form-label">Payment Type <span class="text-danger">*</span></label>
                <select name="payment_type" class="form-select" required>
                    <option value="">Select Payment Method</option>
                    <option value="phonepe" {{ old('payment_type') == 'phonepe' ? 'selected' : '' }}>PhonePe</option>
                    <option value="gpay" {{ old('payment_type') == 'gpay' ? 'selected' : '' }}>GPay</option>
                    <option value="others" {{ old('payment_type') == 'others' ? 'selected' : '' }}>Others</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-submit">
                <i class="fas fa-paper-plane me-2"></i>Submit Registration
            </button>
        </form>



    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const customerTypeSelect = document.getElementById('customer_type');
        const familyIncludedSelect = document.getElementById('family_included');
        const customerIdSection = document.getElementById('customerIdSection');
        const familyCountSection = document.getElementById('familyCountSection');

        // Handle Customer Type change
        customerTypeSelect.addEventListener('change', function() {
            if (this.value === 'existing') {
                customerIdSection.style.display = 'block';
            } else {
                customerIdSection.style.display = 'none';
            }
        });

        // Handle Family Included change
        familyIncludedSelect.addEventListener('change', function() {
            if (this.value === 'yes') {
                familyCountSection.style.display = 'block';
            } else {
                familyCountSection.style.display = 'none';
            }
        });

        // Initialize on page load
        if (customerTypeSelect.value === 'existing') {
            customerIdSection.style.display = 'block';
        }

        if (familyIncludedSelect.value === 'yes') {
            familyCountSection.style.display = 'block';
        }

    });
</script>
@endpush