@extends('layouts.app')

@section('title', 'Admin Dashboard')

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
  }

  .page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 10px;
    margin-bottom: 30px;
  }

  .table-responsive {
    border-radius: 10px;
    overflow: hidden;
  }

  .table thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
  }

  .badge {
    padding: 6px 12px;
    font-size: 0.85rem;
  }

  .btn-action {
    padding: 5px 12px;
    font-size: 0.85rem;
    margin: 2px;
  }

  .qr-thumbnail {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 5px;
    cursor: pointer;
  }





  .table-responsive {
    border-radius: 10px;
    overflow-x: auto;
    /* Allow horizontal scroll */
  }

  .table {
    min-width: 1200px;
    /* Ensure table doesn't collapse */
  }

  .qr-thumbnail {
    width: 50px;
    height: 50px;
    object-fit: contain;
    /* Changed from 'cover' to 'contain' */
    border-radius: 5px;
    cursor: pointer;
    border: 1px solid #ddd;
  }

  /* Make action buttons always visible */
  .btn-action {
    padding: 5px 12px;
    font-size: 0.85rem;
    margin: 2px;
    white-space: nowrap;
  }

  /* Sticky action column */
  .table td:last-child,
  .table th:last-child {
    position: sticky;
    right: 0;
    background: white;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
  }

  .table thead th:last-child {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  }
</style>

@endpush

@section('content')


<div class="container-fluid">
  <div class="main-container">

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


    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
      <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if ($registrations->count() > 0)
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Customer No</th>
            <th>Type</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Family</th>
            <th>Checked In At</th>
            <th>Amount</th>
            <th>Payment</th>
            <th>Status</th>
            <th>QR Code</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($registrations as $registration)
          <tr>
            <td>{{ $registration->id }}</td>
            <td><strong class="text-primary">{{ $registration->customer_no }}</strong></td>
            <td>
              <span class="badge bg-{{ $registration->customer_type == 'new' ? 'success' : 'info' }}">
                {{ ucfirst($registration->customer_type) }}
              </span>
            </td>
            <td>{{ $registration->name }}</td>
            <td>{{ $registration->email }}</td>
            <td>{{ $registration->phone }}</td>
            <td>
              @if ($registration->family_included == 'yes')
              <span class="badge bg-primary">
                Yes
                @if ($registration->adults_count || $registration->child_count)
                (A:{{ $registration->adults_count ?? 0 }}, C:{{ $registration->child_count ?? 0 }})
                @endif
              </span>
              @else
              <span class="badge bg-secondary">No</span>
              @endif
            </td>

            <td>
              @if ($registration->checked_in_at)
              <span class="badge bg-success">{{ $registration->checked_in_at->format('d/m/Y H:i') }}</span>
              @else
              <span class="badge bg-secondary">Not Checked In</span>
              @endif
              </span>

            </td>
            <td><strong>₹{{ number_format($registration->total_amount, 2) }}</strong></td>
            <td>
              <span class="badge bg-warning text-dark">
                {{ ucfirst($registration->payment_type) }}
              </span>
            </td>
            <td>
              <span class="badge bg-{{ $registration->payment_status == 'verified' ? 'success' : 'danger' }}">
                {{ ucfirst($registration->payment_status ?? 'non-verified') }}
              </span>
            </td>

            <td class="text-center">
              @if ($registration->qr_code)
              @php
              $qrUrl = asset($registration->qr_code);
              $filePath = public_path($registration->qr_code);
              @endphp

              @if(file_exists($filePath))
              <img src="{{ $qrUrl }}"
                class="qr-thumbnail"
                style="width: 50px; height: 50px; cursor: pointer; border: 1px solid #ddd; padding: 3px;"
                data-bs-toggle="modal"
                data-bs-target="#qrModal{{ $registration->id }}"
                alt="QR Code">
              @else
              <span class="badge bg-secondary">QR Not Found</span>
              @endif
              @else
              <span class="text-muted">-</span>
              @endif
            </td>
            </td>

            <td>{{ $registration->created_at->format('d/m/Y') }}</td>
            <td>
              @if ($registration->payment_status == 'verified')
              <form action="{{ route('admin.unverify-payment', $registration->id) }}"
                method="POST"
                style="display: inline-block;">
                @csrf
                <button type="submit" class="btn btn-danger btn-action btn-sm" title="Unverify Payment">
                  <i class="fas fa-times-circle me-1"></i>Unverify
                </button>
              </form>
              @else
              <form action="{{ route('admin.verify-payment', $registration->id) }}"
                method="POST"
                style="display: inline-block;">
                @csrf
                <button type="submit" class="btn btn-success btn-action btn-sm" title="Verify Payment">
                  <i class="fas fa-check-circle me-1"></i>Verify
                </button>
              </form>
              @endif
              <!-- <a href="{{ route('registrations.show', $registration->id) }}"
                class="btn btn-info btn-action btn-sm">
                <i class="fas fa-eye"></i>
              </a> -->
              <!-- <a href="{{ route('registrations.edit', $registration->id) }}"
                class="btn btn-warning btn-action btn-sm">
                <i class="fas fa-edit"></i>
              </a> -->
              <!-- <form action="{{ route('registrations.destroy', $registration->id) }}"
                method="POST"
                style="display: inline-block;"
                onsubmit="return confirm('Are you sure you want to delete this registration?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-action btn-sm">
                  <i class="fas fa-trash"></i>
                </button>
              </form> -->
            </td>
          </tr>

          <!-- QR Code Modal -->
          <div class="modal fade" id="qrModal{{ $registration->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">QR Code - {{ $registration->customer_no }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                  @if ($registration->qr_code)
                  @php
                  $extension = pathinfo($registration->qr_code, PATHINFO_EXTENSION);
                  $filePath = public_path($registration->qr_code);
                  $qrUrl = asset($registration->qr_code);
                  @endphp

                  @if(file_exists($filePath))
                  <img src="{{ $qrUrl }}"
                    class="img-fluid"
                    style="max-width: 400px; border: 1px solid #ddd; padding: 10px; border-radius: 5px;"
                    alt="QR Code">
                  @else
                  <p class="text-danger">QR Code file not found</p>
                  @endif
                  @endif
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $registrations->links() }}
    </div>
    @else
    <div class="alert alert-info text-center">
      <i class="fas fa-info-circle me-2"></i>No registrations found.
      <a href="{{ route('registrations.create') }}" class="alert-link">Create your first registration</a>
    </div>
    @endif
  </div>
</div>

@endsection