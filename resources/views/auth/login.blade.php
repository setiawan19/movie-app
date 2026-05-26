<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.login_title') }} - Movie App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f4f6f9;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .btn-login {
            background: #007bff;
            border: none;
        }
        .btn-login:hover {
            background: #0056b3;
        }
        .lang-switcher {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>

    <div class="lang-switcher">
        <a href="/lang/en" class="btn btn-sm {{ app()->getLocale() == 'en' ? 'btn-primary' : 'btn-light' }}">EN</a>
        <a href="/lang/id" class="btn btn-sm {{ app()->getLocale() == 'id' ? 'btn-primary' : 'btn-light' }}">ID</a>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card p-4">
                    <div class="card-body">
                        <h3 class="text-center mb-4 font-weight-bold text-secondary">
                            {{ __('messages.login_title') }}
                        </h3>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0 pl-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form action="/login" method="POST">
                            @csrf <div class="form-group mb-3">
                                <label for="username" class="text-muted font-weight-boldSmall">{{ __('messages.username') }}</label>
                                <input type="text" name="username" id="username" class="form-control form-control-lg" required autocomplete="off" autofocus>
                            </div>

                            <div class="form-group mb-4">
                                <label for="password" class="text-muted font-weight-boldSmall">{{ __('messages.password') }}</label>
                                <div class="form-group">
                                    <div style="position: relative;">
                                        <!-- Input Password -->
                                        <input type="password" id="password" name="password" class="form-control form-control-lg" required >
                                        
                                        <!-- Tombol Toggle dengan Icon SVG -->
                                        <button type="button" id="togglePassword" 
                                                aria-label="{{ __('messages.show_password') }}"
                                                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6b7280; display: flex; align-items: center; padding: 0;">
                                            
                                            <!-- Icon Mata (Show Password) -->
                                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>

                                            <!-- Icon Mata Coret (Hide Password) -->
                                            <svg id="eyeSlashIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px; display: none;">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12c1.512 4.06 5.442 7.5 10.066 7.5 1.583 0 3.076-.406 4.406-1.121m2.427-4.645a10.479 10.479 0 0 0 2.107-3.734c-1.512-4.06-5.442-7.5-10.066-7.5-.931 0-1.831.154-2.672.441m-1.252 1.155L3.98 8.223M12 9a3 3 0 0 1 3 3m-3 3a3 3 0 0 1-3-3m-1.5 8.25L21 3" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block btn-login font-weight-bold">
                                {{ __('messages.login_btn') }}
                            </button>
                        </form>

                    </div>
                </div>
                <p class="text-center text-muted mt-3" style="font-size: 0.85rem;">
                    Kredensial Uji Teknis PT Aldmic COOPN Digital
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');
        const eyeSlashIcon = document.querySelector('#eyeSlashIcon');

        togglePassword.addEventListener('click', function () {
            // Toggle tipe atribut
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle icon dan aria-label
            if (type === 'text') {
                eyeIcon.style.display = 'none';
                eyeSlashIcon.style.display = 'block';
                this.setAttribute('aria-label', "{{ __('messages.hide_password') }}");
            } else {
                eyeIcon.style.display = 'block';
                eyeSlashIcon.style.display = 'none';
            this.setAttribute('aria-label', "{{ addslashes(__('messages.show_password')) }}");
            }
        });
    </script>
</body>
</html>