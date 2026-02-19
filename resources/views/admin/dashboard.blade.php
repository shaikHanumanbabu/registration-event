@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
  <div class="row">
    <!-- Header -->
    <div class="col-12">
      <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 15px; margin-bottom: 30px;">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h1 style="margin: 0; font-size: 32px; font-weight: bold;">
              <i class="fas fa-tachometer-alt me-3"></i>Admin Dashboard
            </h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Welcome back to your dashboard</p>
          </div>
          <div>
            <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
              @csrf
              <button type="submit" class="btn btn-light">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if(session('success'))
  <div class="row mb-3">
    <div class="col-12">
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  </div>
  @endif

  @if(session('error'))
  <div class="row mb-3">
    <div class="col-12">
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  </div>
  @endif

  <div class="row">
    <!-- Statistics Cards -->
    <div class="col-md-3 mb-4">
      <div class="card border-0 shadow-sm" style="border-radius: 10px; overflow: hidden;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px;">
          <i class="fas fa-users" style="font-size: 32px; opacity: 0.8;"></i>
        </div>
        <div class="card-body">
          <h6 class="card-title text-muted">Total Registrations</h6>
          <h2 class="card-text" style="font-weight: bold; color: #667eea;">
            {{ \App\Models\Registration::count() }}
          </h2>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <div class="card border-0 shadow-sm" style="border-radius: 10px; overflow: hidden;">
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 20px;">
          <i class="fas fa-user-check" style="font-size: 32px; opacity: 0.8;"></i>
        </div>
        <div class="card-body">
          <h6 class="card-title text-muted">New Customers</h6>
          <h2 class="card-text" style="font-weight: bold; color: #f5576c;">
            {{ \App\Models\Registration::where('customer_type', 'new')->count() }}
          </h2>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <div class="card border-0 shadow-sm" style="border-radius: 10px; overflow: hidden;">
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 20px;">
          <i class="fas fa-user-tie" style="font-size: 32px; opacity: 0.8;"></i>
        </div>
        <div class="card-body">
          <h6 class="card-title text-muted">Existing Customers</h6>
          <h2 class="card-text" style="font-weight: bold; color: #00f2fe;">
            {{ \App\Models\Registration::where('customer_type', 'existing')->count() }}
          </h2>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <div class="card border-0 shadow-sm" style="border-radius: 10px; overflow: hidden;">
        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 20px;">
          <i class="fas fa-indian-rupee-sign" style="font-size: 32px; opacity: 0.8;"></i>
        </div>
        <div class="card-body">
          <h6 class="card-title text-muted">Total Revenue</h6>
          <h2 class="card-text" style="font-weight: bold; color: #38f9d7;">
            ₹{{ number_format(\App\Models\Registration::sum('total_amount'), 2) }}
          </h2>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Quick Actions -->
    <div class="col-12">
      <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 10px 10px 0 0;">
          <h5 class="mb-0">
            <i class="fas fa-lightning-bolt me-2"></i>Quick Actions
          </h5>
        </div>
        <div class="card-body" style="padding: 30px;">
          <div class="row">
            <div class="col-md-4 mb-3">
              <a href="{{ route('registrations.create') }}" class="btn btn-outline-primary w-100" style="padding: 12px; font-weight: 600;">
                <i class="fas fa-plus me-2"></i>New Registration
              </a>
            </div>
            <div class="col-md-4 mb-3">
              <a href="{{ route('registrations.index') }}" class="btn btn-outline-info w-100" style="padding: 12px; font-weight: 600;">
                <i class="fas fa-list me-2"></i>View All Registrations
              </a>
            </div>
            <div class="col-md-4 mb-3">
              <a href="{{ route('check.registration-mail') }}" class="btn btn-outline-warning w-100" style="padding: 12px; font-weight: 600;">
                <i class="fas fa-envelope me-2"></i>View Email Template
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <!-- Recent Registrations -->
    <div class="col-12">
      <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 10px 10px 0 0;">
          <h5 class="mb-0">
            <i class="fas fa-clock me-2"></i>Recent Registrations
          </h5>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead style="background-color: #f8f9fa;">
              <tr>
                <th>Registration ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Customer Type</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($registrations as $registration)
              <tr>
                <td><strong>#{{ $registration->id }}</strong></td>
                <td>{{ $registration->name }}</td>
                <td>{{ $registration->email }}</td>
                <td>
                  <span class="badge bg-{{ $registration->customer_type === 'new' ? 'success' : 'info' }}">
                    {{ ucfirst($registration->customer_type) }}
                  </span>
                </td>
                <td><strong>₹{{ number_format($registration->total_amount, 2) }}</strong></td>
                <td>{{ $registration->created_at->format('M d, Y') }}</td>
                <td>
                  <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                    @if($registration->payment_status === 'verified')
                    <span class="badge bg-success">
                      <i class="fas fa-check-circle me-1"></i>Verified
                    </span>
                    <form action="{{ route('admin.unverify-payment', $registration->id) }}" method="POST" style="display: inline;">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Mark as Non-Verified">
                        <i class="fas fa-times me-1"></i>Unverify
                      </button>
                    </form>
                    @else
                    <span class="badge bg-danger">
                      <i class="fas fa-exclamation-circle me-1"></i>Non-Verified
                    </span>
                    <form action="{{ route('admin.verify-payment', $registration->id) }}" method="POST" style="display: inline;">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-outline-success" title="Verify Payment">
                        <i class="fas fa-check me-1"></i>Verify Payment
                      </button>
                    </form>
                    @endif
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-4">
                  <i class="fas fa-inbox" style="font-size: 32px; opacity: 0.5;"></i>
                  <p class="mt-2">No registrations yet</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div style="padding: 20px;">
          {{ $registrations->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection