<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/d70c32c211.js" crossorigin="anonymous"></script>
    <style>
        /* @import "compass/css3";

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            background: #95a5a6;
            background-image: url(http://subtlepatterns2015.subtlepatterns.netdna-cdn.com/patterns/dark_embroidery.png);
            font-family: 'Helvetica Neue', Arial, Sans-Serif;

            .login-wrap {
                position: relative;
                margin: 0 auto;
                background: #ecf0f1;
                width: 350px;
                border-radius: 5px;
                box-shadow: 3px 3px 10px #333;
                padding: 15px;

                h2 {
                    text-align: center;
                    font-weight: 200;
                    font-size: 2em;
                    margin-top: 10px;
                    color: #34495e;
                }

                .form {
                    padding-top: 20px;

                    input[type="email"],
                    input[type="password"],
                    button {
                        width: 80%;
                        margin-left: 10%;
                        margin-bottom: 25px;
                        height: 40px;
                        border-radius: 5px;
                        outline: 0;
                        -moz-outline-style: none;
                    }

                    input[type="email"],
                    input[type="password"] {
                        border: 1px solid #bbb;
                        padding: 0 0 0 10px;
                        font-size: 14px;

                        &:focus {
                            border: 1px solid #3498db;
                        }
                    }

                    a {
                        text-align: center;
                        font-size: 10px;
                        color: #3498db;

                        p {
                            padding-bottom: 10px;
                        }

                    }

                    button {
                        background: #e74c3c;
                        border: none;
                        color: white;
                        font-size: 18px;
                        font-weight: 200;
                        cursor: pointer;
                        transition: box-shadow .4s ease;

                        &:hover {
                            box-shadow: 1px 1px 5px #555;
                        }

                        &:active {
                            box-shadow: 1px 1px 7px #222;
                        }

                    }

                }

                &:after {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    background: -webkit-linear-gradient(left,
                            #27ae60 0%, #27ae60 20%,
                            #8e44ad 20%, #8e44ad 40%,
                            #3498db 40%, #3498db 60%,
                            #e74c3c 60%, #e74c3c 80%,
                            #f1c40f 80%, #f1c40f 100%);
                    background: -moz-linear-gradient(left,
                            #27ae60 0%, #27ae60 20%,
                            #8e44ad 20%, #8e44ad 40%,
                            #3498db 40%, #3498db 60%,
                            #e74c3c 60%, #e74c3c 80%,
                            #f1c40f 80%, #f1c40f 100%);
                    height: 5px;
                    border-radius: 5px 5px 0 0;
                }

            }

        } */
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required>
                                    @error('password')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>

                                    @if (Route::has('send-mail'))
                                        <a class="btn btn-link"
                                            href="{{ route('send-mail') }}">{{ __('Forgot Your Password?') }}</a>
                                    @endif
                                </div>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <p>Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="login-wrap">
            <h2>Login</h2>

            <div class="form">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" required
                        autofocus />
                    <input type="password" placeholder="Password" name="password" />
                    <div class="row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>

                            @if (Route::has('send-mail'))
                                <a class="btn btn-link"
                                    href="{{ route('send-mail') }}">{{ __('Forgot Your Password?') }}</a>
                            @endif
                        </div>
                    </div>
                    <a href="">
                        <p class="text-center"> Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
                        </p>
                    </a>
                </form>
            </div>
        </div> --}}
    </div>

    <script>
        // Login/Register form
        // Author: Ian Pirro 
        //------------------------------------
        // Form will change from login to register and visa-versa based
        // on if the user is already "registered"
        // "Usernames" min-len is 5 chars
        //
        // Could be annoying... but fun anyways


        // These users "already exist"
        var users = [{
                name: 'ianpirro'
            },
            {
                name: 'joeschmoe'
            },
            {
                name: 'superdev'
            }
        ]

        var loginform = {

            init: function() {
                this.bindUserBox();
            },

            bindUserBox: function() {
                var result = {};

                $(".form").delegate("input[name='un']", 'blur', function() {
                    var $self = $(this);

                    // this grep would be replaced by $.post tp check db for user
                    result = $.grep(users, function(elem, i) {
                        return (elem.name == $self.val());
                    });

                    // This would be callback
                    if (result.length === 1) {
                        if ($("div.login-wrap").hasClass('register')) {
                            loginform.revertForm();
                            return;
                        } else {
                            return;
                        }
                    }

                    if (!$("div.login-wrap").hasClass('register')) {
                        if ($("input[name='un']").val().length > 4)
                            loginform.switchForm();
                    }

                });
            },
            switchForm: function() {
                var $html = $("div.login-wrap").addClass('register');
                $html.children('h2').html('Register');
                $html.find(".form input[name='pw']").after(
                    "<input type='password' placeholder='Re-type password' name='rpw' />");
                $html.find('button').html('Sign up');
                $html.find('a p').html('Have an account? Sign in');
            },
            revertForm: function() {
                var $html = $("div.login-wrap").removeClass('register');
                $html.children('h2').html('Login');
                $html.find(".form input[name='rpw']").remove();
                $html.find('button').html('Sign in');
                $html.find('a p').html("Don't have an account? Register");
            },
            submitForm: function() {
                // ajax to handle register or login
            }

        } // loginform {}


        // Init login form
        loginform.init();


        // vertical align box   
        (function(elem) {
            elem.css("margin-top", Math.floor(($(window).height() / 2) - (elem.height() / 2)));
        }($(".login-wrap")));

        $(window).resize(function() {
            $(".login-wrap").css("margin-top", Math.floor(($(window).height() / 2) - ($(".login-wrap").height() /
                2)));

        });
    </script>
</body>

</html>
