@extends('layouts.app')

@section('title', 'New Registration')

@section('content')
<div class="container">
    <div class="registration-card">
        <div class="card-header">
            <h1 class="mb-0 text-center">
                LegendBusinessNexus
            </h1>
            <p class="mb-0 text-center" style="margin-top: 8px; font-size: 24px;">
                A Trip to Ananthagiri Hills
            </p>
        </div>

        <!-- <div class="nav-buttons">
            <a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list me-2"></i>View All Registrations
            </a>
        </div> -->

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

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
                <div class="col-md-12 mb-3">
                    <label class="form-label">Customer Type <span class="text-danger">*</span></label>
                    <select name="customer_type" id="customer_type" class="form-select" required>
                        <option value="">Select Type</option>
                        <option value="new" {{ old('customer_type') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="existing" {{ old('customer_type') == 'existing' ? 'selected' : '' }}>Existing</option>
                    </select>
                </div>


            </div>

            <!-- create a form -->






            <!-- New Member Registration Message -->
            <div id="newMemberMessage" class="alert alert-info" style="display: none; border-radius: 8px; border-left: 4px solid #0d6efd;">
                <div style="padding: 15px;">
                    <h5 style="margin-top: 0; color: #0d6efd;"><i class="fas fa-info-circle me-2"></i>Welcome New Member</h5>
                    <p style="margin: 10px 0 15px 0; color: #333;">
                        Registration is mandatory to become an LBN member. Only registered members are eligible to participate in the trip. Please click the registration link below to complete your enrollment.
                    </p>
                    <a href="https://legendbusinessnexus.com/#/uregister" target="_blank" class="btn btn-primary" style="display: inline-block; padding: 8px 20px; font-size: 14px;">
                        <i class="fas fa-external-link-alt me-2"></i>Complete Registration
                    </a>
                </div>
            </div>

            <div class="old-customer-section" id="oldCustomerSection">
                <!-- if customer type is existing we need to display this input -->
                <div class="mb-3" id="customerIdSection" style="display: none;">
                    <label class="form-label">Enter Customer Id </label>
                    <input type="text" name="customer_id" id="customer_id" class="form-control" value="{{ old('customer_id') }}" placeholder="Enter customer id">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Is Family Members Included? <span class="text-danger">*</span></label>
                    <select name="family_included" id="family_included" class="form-select" required>
                        <option value="">Select Option</option>
                        <option value="yes" {{ old('family_included') == 'yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ old('family_included') == 'no' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <!-- Family Count Fields (Conditionally shown) -->
                <div id="familyCountSection" style="display: none;">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Adults Count</label>
                            <input type="number" name="adults_count" id="adults_count" class="form-control" min="0" value="{{ old('adults_count') }}" placeholder="Enter number of adults">
                            <small class="form-text text-muted"> <b>Note:</b>Eligibility is restricted to immediate blood-related family members only, such as spouse, mother, and father. <b>A participation fee of ₹500 per person is applicable.</b></small>

                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Child Count</label>
                            <input type="text" name="child_count" id="child_count" class="form-control" pattern="[0-2]" value="{{ old('child_count') }}" placeholder="Enter number of children">
                            <small class="form-text text-muted"><b>Note:</b>Participation for children is limited to a maximum of two per member, and only children below 18 years of age are eligible</small>
                        </div>
                    </div>
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

                <button type="submit" id="submitBtn" class="btn btn-primary btn-submit">
                    <i class="fas fa-paper-plane me-2"></i>Submit Registration
                </button>
            </div>
        </form>



    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submitBtn');

        if (form && submitBtn) {
            form.addEventListener('submit', function(e) {
                // Disable the button
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
                submitBtn.style.cursor = 'not-allowed';

                // Optional: Show loading text
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
            });
        }
    });
</script>
@endpush