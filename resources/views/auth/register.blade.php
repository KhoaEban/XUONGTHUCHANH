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
