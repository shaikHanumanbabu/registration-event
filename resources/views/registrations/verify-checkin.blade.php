@extends('layouts.app')

@section('title', 'Verify Check-in')

@push('styles')
<style>
  body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 30px 0;
  }

  .main-container {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    padding: 40px;
    margin: 0 auto;
    max-width: 800px;
  }

  .header-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 10px;
    margin-bottom: 30px;
    text-align: center;
  }

  .details-card {
    background-color: #f8f9fa;
    border-left: 4px solid #667eea;
    padding: 20px;
    margin: 20px 0;
    border-radius: 4px;
  }

  .detail-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #e0e0e0;
  }

  .detail-row:last-child {
    border-bottom: none;
  }

  .detail-label {
    font-weight: bold;
    color: #333;
  }

  .detail-value {
    color: #667eea;
    font-weight: 600;
  }

  .status-badge {
    display: inline-block;
    padding: 8px 15px;
    border-radius: 20px;
    font-weight: bold;
    text-align: center;
    margin: 10px 0;
  }

  .status-checked-in {
    background-color: #d4edda;
    color: #155724;
  }

  .status-not-checked {
    background-color: #f8d7da;
    color: #721c24;
  }

  .btn-verify {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    display: inline-block;
    margin-top: 20px;
    width: 100%;
    text-align: center;
  }

  .btn-verify:hover {
    opacity: 0.9;
  }

  .btn-verify:disabled {
    opacity: 0.6;
    cursor: not-allowed;
  }

  .success-message {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    display: none;
  }

  .success-message.show {
    display: block;
  }
</style>
@endpush

@section('content')
<div class="container">
  <div class="main-container">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
      <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif


    @if ($registration->checked_in)
    <!-- Success Message - Already Checked In -->
    <div class="details-card" style="text-align: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
      <i class="fas fa-check-circle" style="font-size: 48px; margin-bottom: 15px; color: #fff;"></i>
      <h2 style="color: #fff; margin: 15px 0;">Check-in Successful!</h2>
      <p style="font-size: 16px; margin: 15px 0; line-height: 1.6;">
        The coupon already exists. You have successfully checked in. Thank you.
      </p>
      <div style="background-color: rgba(0,0,0,0.1); padding: 20px; border-radius: 5px; margin-top: 20px;">
        <p style="margin: 10px 0; font-size: 14px;">For more information, please contact:</p>
        <p style="font-size: 18px; font-weight: bold; margin: 10px 0;">
          <i class="fas fa-phone me-2"></i>+91 90005 27519
        </p>
        <p style="font-size: 18px; font-weight: bold; margin: 10px 0;">
          <i class="fas fa-phone me-2"></i>+91 99493 59007
        </p>
      </div>
      <p style="font-size: 12px; margin-top: 20px; opacity: 0.9;">
        Checked in on: {{ $registration->checked_in_at->format('d/m/Y \a\t H:i:s') }}
      </p>
    </div>
    @else

    <div class="header-section">
      <h1 style="margin: 0; font-size: 28px;">
        <i class="fas fa-qrcode me-2"></i>Verify Check-in
      </h1>
      <p style="margin: 10px 0 0 0; opacity: 0.9;">Registration Details</p>
    </div>

    <!-- Registration Details -->
    <div class="details-card">
      <h3 style="margin-top: 0; color: #667eea;">
        <i class="fas fa-user me-2"></i>Personal Information
      </h3>
      <div class="detail-row">
        <span class="detail-label">Registration ID:</span>
        <span class="detail-value">{{ $registration->id }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Customer Number:</span>
        <span class="detail-value">{{ $registration->customer_no }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Name:</span>
        <span class="detail-value">{{ $registration->name }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Email:</span>
        <span class="detail-value">{{ $registration->email }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Phone:</span>
        <span class="detail-value">{{ $registration->phone }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Address:</span>
        <span class="detail-value">{{ $registration->address }}, {{ $registration->state }}</span>
      </div>
    </div>

    <!-- Family Details -->
    <div class="details-card">
      <h3 style="margin-top: 0; color: #667eea;">
        <i class="fas fa-users me-2"></i>Family Information
      </h3>
      <div class="detail-row">
        <span class="detail-label">Customer Type:</span>
        <span class="detail-value text-capitalize">{{ $registration->customer_type }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Family Included:</span>
        <span class="detail-value text-capitalize">{{ $registration->family_included }}</span>
      </div>
      @if ($registration->family_included == 'yes')
      <div class="detail-row">
        <span class="detail-label">Adults Count:</span>
        <span class="detail-value">{{ $registration->adults_count ?? 0 }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Children Count:</span>
        <span class="detail-value">{{ $registration->child_count ?? 0 }}</span>
      </div>
      @endif
    </div>

    <!-- Payment Details -->
    <div class="details-card">
      <h3 style="margin-top: 0; color: #667eea;">
        <i class="fas fa-money-bill me-2"></i>Payment Information
      </h3>
      <div class="detail-row">
        <span class="detail-label">Total Amount:</span>
        <span class="detail-value">₹{{ number_format($registration->total_amount, 2) }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Payment Type:</span>
        <span class="detail-value text-capitalize">{{ $registration->payment_type }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Payment Status:</span>
        <span class="detail-value">
          <span class="badge bg-{{ $registration->payment_status == 'verified' ? 'success' : 'danger' }}">
            {{ ucfirst($registration->payment_status ?? 'non-verified') }}
          </span>
        </span>
      </div>
    </div>


    <!-- Check-in Status - Not Yet Checked In -->
    <div class="details-card">
      <h3 style="margin-top: 0; color: #667eea;">
        <i class="fas fa-check-square me-2"></i>Check-in Status
      </h3>
      <div class="status-badge status-not-checked">
        <i class="fas fa-times-circle me-2"></i>Not Checked In
      </div>
      @auth('admin')
      <form action="{{ route('confirm-checkin', $registration->id) }}" method="POST" style="margin-top: 20px;">
        @csrf
        <button type="submit" class="btn btn-verify">
          <i class="fas fa-check-circle me-2"></i>Verify Check-in
        </button>
      </form>
      @else
      <div style="background-color: #fff3cd; border: 1px solid #ffc107; color: #856404; padding: 15px; border-radius: 5px; margin-top: 20px; text-align: center;">
        <i class="fas fa-lock me-2"></i>Please log in to verify check-in
      </div>
      @endauth
    </div>
    @endif

    <div style="text-align: center; margin-top: 30px;">
      <a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Registrations
      </a>
    </div>
  </div>
</div>
@endsection