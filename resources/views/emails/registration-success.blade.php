<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Successful</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
  <!-- Main Container -->
  <div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow: hidden;">

    <!-- Header -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 20px; text-align: center; color: #ffffff;">
      <h1 style="margin: 0; font-size: 28px; font-weight: bold;">Registration Successful!</h1>
      <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">Event Registration Confirmation</p>
    </div>

    <!-- Content -->
    <div style="padding: 40px 20px;">

      <!-- Welcome Message -->
      <p style="margin: 0 0 20px 0; font-size: 16px; color: #333333; line-height: 1.6;">
        Hello <strong>{{ $registration->name }}</strong>,
      </p>

      <p style="margin: 0 0 20px 0; font-size: 14px; color: #555555; line-height: 1.6;">
        Thank you for registering for our event! You are eligible to participate in the Ananthagiri trip scheduled for the 27th and 28th. We wish you an enjoyable and memorable experience.
      </p>

      <!-- Registration Details Card -->
      <div style="background-color: #f8f9fa; border-left: 4px solid #667eea; padding: 20px; margin: 20px 0; border-radius: 4px;">
        <h3 style="margin: 0 0 15px 0; font-size: 16px; color: #333333; font-weight: bold;">Registration Details</h3>

        <table style="width: 100%; font-size: 14px; color: #555555;">
          <tr style="border-bottom: 1px solid #e0e0e0;">
            <td style="padding: 10px 0; font-weight: bold; width: 40%;">Registration ID:</td>
            <td style="padding: 10px 0; color: #667eea; font-weight: bold;">{{ $registration->id ?? 'N/A' }}</td>
          </tr>
          <tr style="border-bottom: 1px solid #e0e0e0;">
            <td style="padding: 10px 0; font-weight: bold;">Name:</td>
            <td style="padding: 10px 0;">{{ $registration->name }}</td>
          </tr>
          <tr style="border-bottom: 1px solid #e0e0e0;">
            <td style="padding: 10px 0; font-weight: bold;">Email:</td>
            <td style="padding: 10px 0;">{{ $registration->email }}</td>
          </tr>
          <tr style="border-bottom: 1px solid #e0e0e0;">
            <td style="padding: 10px 0; font-weight: bold;">Phone:</td>
            <td style="padding: 10px 0;">{{ $registration->phone }}</td>
          </tr>
          @if($registration->customer_type)
          <tr style="border-bottom: 1px solid #e0e0e0;">
            <td style="padding: 10px 0; font-weight: bold;">Customer Type:</td>
            <td style="padding: 10px 0; text-transform: capitalize;">{{ $registration->customer_type }}</td>
          </tr>
          @endif
          @if($registration->family_included)
          <tr style="border-bottom: 1px solid #e0e0e0;">
            <td style="padding: 10px 0; font-weight: bold;">Family Included:</td>
            <td style="padding: 10px 0; text-transform: capitalize;">{{ $registration->family_included }}</td>
          </tr>
          @endif
          @if($registration->family_included === 'yes')
          <tr style="border-bottom: 1px solid #e0e0e0;">
            <td style="padding: 10px 0; font-weight: bold;">Adults Count:</td>
            <td style="padding: 10px 0;">{{ $registration->adults_count ?? 0 }}</td>
          </tr>
          <tr style="border-bottom: 1px solid #e0e0e0;">
            <td style="padding: 10px 0; font-weight: bold;">Children Count:</td>
            <td style="padding: 10px 0;">{{ $registration->child_count ?? 0 }}</td>
          </tr>
          @endif
          @if($registration->total_amount)
          <tr>
            <td style="padding: 10px 0; font-weight: bold;">Total Amount:</td>
            <td style="padding: 10px 0; color: #28a745; font-weight: bold; font-size: 16px;">₹ {{ number_format($registration->total_amount, 2) }}</td>
          </tr>
          @endif
        </table>
      </div>

      <!-- QR Code Section -->
      @if($registration->qr_code)
      @php
      $qrUrl = asset($registration->qr_code);
      $filePath = public_path($registration->qr_code);
      @endphp
      @if(file_exists($filePath))
      <div style="text-align: center; margin: 30px 0; padding: 20px; background-color: #f8f9fa; border-radius: 8px;">
        <h3 style="margin: 0 0 15px 0; font-size: 16px; color: #333333; font-weight: bold;">Your Registration QR Code</h3>
        <p style="margin: 0 0 15px 0; font-size: 12px; color: #888888;">Use this QR code for event check-in</p>
        <img src="{{ $qrUrl }}" alt="Registration QR Code" style="max-width: 250px; height: auto; border-radius: 8px; border: 1px solid #ddd;">
      </div>
      @endif
      @endif

      <!-- Message -->
      <div style="background-color: #e7f3ff; border-left: 4px solid #2196F3; padding: 15px; margin: 20px 0; border-radius: 4px;">
        <p style="margin: 0; font-size: 13px; color: #1565C0; line-height: 1.5;">
          <strong>Important:</strong> Please save this email and present the QR code at the event check-in desk. Keep your registration ID handy for reference.
        </p>
      </div>

      <!-- Contact Information -->
      <p style="margin: 20px 0 10px 0; font-size: 14px; color: #555555; line-height: 1.6;">
        If you have any questions or need to modify your registration, please contact us.
      </p>

      <!-- Footer -->
      <div style="border-top: 1px solid #e0e0e0; margin-top: 30px; padding-top: 20px; text-align: center; font-size: 12px; color: #999999;">
        <p style="margin: 0 0 10px 0;">{{ config('app.name') }} - Event Registration System</p>
        <p style="margin: 0;">© {{ date('Y') }} All rights reserved.</p>
      </div>
    </div>
  </div>

  <!-- Disclaimer -->
  <div style="text-align: center; margin-top: 20px; font-size: 11px; color: #999999;">
    <p style="margin: 0;">This is an automated email. Please do not reply to this message.</p>
  </div>
</body>

</html>