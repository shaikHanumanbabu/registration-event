<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Registration System</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-container {
      width: 100%;
      max-width: 400px;
      padding: 20px;
    }

    .login-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      overflow: hidden;
    }

    .login-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 30px 20px;
      text-align: center;
    }

    .login-header h1 {
      font-size: 28px;
      font-weight: bold;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .login-header i {
      font-size: 32px;
    }

    .login-body {
      padding: 40px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-label {
      font-weight: 600;
      color: #333;
      margin-bottom: 8px;
    }

    .form-control {
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      padding: 12px 15px;
      font-size: 14px;
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-control:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn-login {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      font-weight: 600;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      color: white;
      border-radius: 8px;
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
      margin-top: 10px;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .error-message {
      color: #dc3545;
      font-size: 13px;
      margin-top: 5px;
    }

    .alert {
      border-radius: 8px;
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <h1>
          <i class="fas fa-user-shield"></i>
          Admin Login
        </h1>
      </div>

      <div class="login-body">
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
          <strong>Login Failed!</strong>
          <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST">
          @csrf

          <div class="form-group">
            <label class="form-label" for="email">
              <i class="fas fa-envelope me-2"></i>Email Address
            </label>
            <input
              type="email"
              class="form-control @error('email') is-invalid @enderror"
              id="email"
              name="email"
              value="{{ old('email') }}"
              placeholder="Enter your email"
              required>
            @error('email')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label" for="password">
              <i class="fas fa-lock me-2"></i>Password
            </label>
            <input
              type="password"
              class="form-control @error('password') is-invalid @enderror"
              id="password"
              name="password"
              placeholder="Enter your password"
              required>
            @error('password')
            <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-login">
            <i class="fas fa-sign-in-alt me-2"></i>Login
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>