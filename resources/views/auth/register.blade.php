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
      background: url('https://plus.unsplash.com/premium_photo-1661964095477-fe68b487f700?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8YnVpbGRpbmclMjBpbiUyMGJhY2tncm91bmR8ZW58MHx8MHx8fDA%3D') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
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


    .card {
      background-color: rgba(255, 255, 255, 0.7);
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      animation: fadeInUp 0.8s ease-out;
      transition: box-shadow 0.3s ease;
    }
    .card:hover {
      box-shadow: 0 6px 25px rgba(0, 0, 0, 0.3);
    }
    .card-header {
      background-color: transparent;
      font-weight: bold;
      font-size: 1.5rem;
      border-bottom: none;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }

    .form-control {
      border-radius: 0.25rem;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    .form-control:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 8px rgba(13, 110, 253, 0.5);
    }

    .hover-icon {
      transition: transform 0.3s ease, color 0.3s ease;
    }
    .hover-icon:hover {
      transform: scale(1.2) rotate(10deg);
      color: #0d6efd;
    }

    .btn-primary {
      border-radius: 2rem;
      background: linear-gradient(45deg, #0d6efd, #00bfff);
      border: none;
      position: relative;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .btn-primary:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-primary::after {
      content: "";
      position: absolute;
      background: rgba(255, 255, 255, 0.4);
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      opacity: 0;
      transform: scale(0);
      transition: opacity 0.3s ease, transform 0.6s ease;
      border-radius: inherit;
    }
    .btn-primary:active::after {
      opacity: 1;
      transform: scale(2);
      transition: 0s;
    }
  </style>
</head>
<body>

  <div class="container min-vh-100 d-flex align-items-center">
    <div class="row w-100 justify-content-center">
      <div class="col-md-6">
        <div class="card p-4">
          <div class="card-header text-center mb-3">
            {{ __('Register') }}
          </div>

          <div class="card-body">
            @if (session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
              @csrf

              <div class="mb-3">
                <label for="name" class="form-label">
                  <i class="fas fa-user hover-icon me-2"></i>{{ __('Name') }}
                </label>
                <input id="name" type="text"
                  class="form-control @error('name') is-invalid @enderror" name="name"
                  value="{{ old('name') }}" required autofocus>
                @error('name')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                @enderror
                <div class="invalid-feedback">Vui lòng nhập tên của bạn.</div>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">
                  <i class="fas fa-envelope hover-icon me-2"></i>{{ __('Email Address') }}
                </label>
                <input id="email" type="email"
                  class="form-control @error('email') is-invalid @enderror" name="email"
                  value="{{ old('email') }}" required>
                @error('email')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                @enderror
                <div class="invalid-feedback">Vui lòng nhập địa chỉ email hợp lệ.</div>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">
                  <i class="fas fa-lock hover-icon me-2"></i>{{ __('Password') }}
                </label>
                <input id="password" type="password"
                  class="form-control @error('password') is-invalid @enderror" name="password" required>
                @error('password')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                @enderror
                <div class="invalid-feedback">Vui lòng nhập mật khẩu.</div>
              </div>

              <div class="mb-3">
                <label for="password-confirm" class="form-label">
                  <i class="fas fa-lock hover-icon me-2"></i>{{ __('Confirm Password') }}
                </label>
                <input id="password-confirm" type="password" class="form-control"
                  name="password_confirmation" required>
                <div class="invalid-feedback">Mật khẩu xác nhận chưa khớp.</div>
              </div>

              <input type="hidden" name="role" value="user">

              <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-user-plus hover-icon me-2"></i>{{ __('Đăng ký') }}
                </button>
              </div>
            </form>

            <div class="mt-3 text-center">
              <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
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
                        <option value="instructor" {{ old('role') == 'instructor' ? 'selected' : '' }}>Instructor</option>
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

        <div class="form-box register">
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
        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Welcome Back!</h1>
                <p>Bạn đã có tài khoản?</p>
                <button class="btn register-btn">Đăng nhập</button>
            </div>

            <div class="toggle-panel toggle-right text-center">
                <h2>Chào mừng đến với hệ thống khóa học online</h2>
                <p>Bạn không có tài khoản?</p>
                <button class="btn login-btn">Đăng ký</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function () {
      'use strict';
      var form = document.querySelector('.needs-validation');

      form.addEventListener('submit', function (event) {
        var password = document.getElementById('password');
        var passwordConfirm = document.getElementById('password-confirm');
        if (password.value !== passwordConfirm.value) {
          passwordConfirm.setCustomValidity('Mật khẩu xác nhận chưa khớp.');
        } else {
          passwordConfirm.setCustomValidity('');
        }

        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    })();
  </script>
</body>
</html>


    <script src="{{ asset('js/auth.js') }}"></script>

</body>

</html>
