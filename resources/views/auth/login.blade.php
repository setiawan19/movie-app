<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trans('messages.login_title') }} - Movie App</title>
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
                            {{ trans('messages.login_title') }}
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
                                <label for="username" class="text-muted font-weight-boldSmall">{{ trans('messages.username') }}</label>
                                <input type="text" name="username" id="username" class="form-control form-control-lg" required autocomplete="off" autofocus>
                            </div>

                            <div class="form-group mb-4">
                                <label for="password" class="text-muted font-weight-boldSmall">{{ trans('messages.password') }}</label>
                                <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block btn-login font-weight-bold">
                                {{ trans('messages.login_btn') }}
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
</body>
</html>