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
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/d70c32c211.js" crossorigin="anonymous"></script>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background-image: url('{{ asset('image/background.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center center;
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="form-box login">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1>Login</h1>
                <div class="input-box">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        placeholder="Email">
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input id="password" type="password" name="password" required placeholder="Password">
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="forgot-link">
                    <a>Forgot Password?</a>
                </div>
                <button type="submit" class="btn">Login</button>
                <p>or login with social platforms</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-google"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </form>
        </div>

        <div class="form-box register">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h1>Registration</h1>
                <div class="input-box">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required placeholder="Username">
                    @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required placeholder="Email">
                    <i class='bx bxs-envelope'></i>
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="input-box">
                    <input type="password" name="password" required placeholder="Password">
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password_confirmation" required placeholder="Repeat Password">
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="input-box">
                    <label for="role" class="form-label">Vai trò</label>
                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                        <option value="" disabled selected>Chọn vai trò</option>
                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="instructor" {{ old('role') == 'instructor' ? 'selected' : '' }}>Instructor
                        </option>
                    </select>
                    @error('role')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <button type="submit" class="btn">Register</button>
                <p>or register with social platforms</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-google"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </form>
        </div>
        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Chào mừng đến với hệ thống khóa học online</h1>
                <p>Bạn không có tài khoản?</p>
                <button class="btn register-btn">Đăng ký</button>
            </div>

            <div class="toggle-panel toggle-right">
                <h1>Welcome Back!</h1>
                <p>Bạn đã có tài khoản?</p>
                <button class="btn login-btn">Đăng nhập</button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

    <script src="{{ asset('js/auth.js') }}"></script>

</body>

</html>
