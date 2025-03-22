<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <script src="https://kit.fontawesome.com/d70c32c211.js" crossorigin="anonymous"></script>

  <style>
    body {
      background: url('https://img.lovepik.com/bg/20240409/Futuristic-Metropolis-Stunning-3D-Render-of-Techno-Skyscrapers-in-Skyline_5810141_wh1200.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
    }

    .card {
      background-color: rgba(255, 255, 255, 0.85);
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      animation: fadeInUp 0.8s ease-out;
      transition: box-shadow 0.3s ease;
    }

    .card:hover {
      box-shadow: 0 6px 25px rgba(0, 0, 0, 0.3);
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(50px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .hover-icon {
      transition: transform 0.3s ease, color 0.3s ease;
    }

    .hover-icon:hover {
      transform: scale(1.2) rotate(10deg);
      color: #0d6efd;
    }
  </style>
</head>

<body>
  <div class="container min-vh-100 d-flex align-items-center">
    <div class="row w-100 justify-content-center">
      <div class="col-md-6">
        <div class="card p-4">
          <div class="card-header text-center mb-3">
            <i class="fas fa-sign-in-alt me-2 hover-icon"></i>{{ __('Login') }}
          </div>

          <div class="card-body">
            @if (session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
              @csrf

              <div class="mb-3">
                <label for="email" class="form-label">
                  <i class="fas fa-envelope me-2 hover-icon"></i>{{ __('Email Address') }}
                </label>
                <input id="email" type="email"
                  class="form-control @error('email') is-invalid @enderror" name="email"
                  value="{{ old('email') }}" required autofocus>
                @error('email')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">
                  <i class="fas fa-lock me-2 hover-icon"></i>{{ __('Password') }}
                </label>
                <input id="password" type="password"
                  class="form-control @error('password') is-invalid @enderror" name="password" required>
                @error('password')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>

              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>
                  <label class="form-check-label" for="remember">
                    <i class="fas fa-check me-1 hover-icon"></i>{{ __('Remember Me') }}
                  </label>
                </div>
              </div>

              <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-sign-in-alt me-2 hover-icon"></i>{{ __('Login') }}
                </button>

                @if (Route::has('send-mail'))
                  <a class="btn btn-link" href="{{ route('send-mail') }}">
                    <i class="fas fa-key me-1 hover-icon"></i>{{ __('Forgot Your Password?') }}
                  </a>
                @endif
              </div>
            </form>

            <div class="mt-3 text-center">
              <p>Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</body>

</html>
