<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Components / Accordion - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('images/logo.png') }}" rel="icon">


  <!-- Vendor CSS Files -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/datatable.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
</head>

<body>


<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="text-center mb-3">
            <img src="{{ asset('images/logo.png') }}" class="" style="width: 200px;" alt="">
            </div>
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body mb-2 pt-2">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class=" mb-3">
                            <label for="email" class="col-form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="mb-3 ">
                            <label for="password" class="col-form-label">{{ __('Password') }}</label>

                                <input id="password" type="password" class=" form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="row mb-5 d-flex">
                            <!-- @if (Route::has('password.request'))
                                    <a class="" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif -->
                  
                                <div class="">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
</div>
                        </div>

                        <div class="row mb-0 d-flex ps-3 pe-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>