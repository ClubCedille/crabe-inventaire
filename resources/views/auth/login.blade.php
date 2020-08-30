@extends('layouts.app')

@section('content')
<div class="container center-height">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header justify-content-center">{{ __('Login') }}</div>

        <div class="card-body">
          <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('user.email') }}</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                  value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('user.password') }}</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                  name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-6 offset-md-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>

                  <label class="form-check-label" for="remember">
                    {{ __('auth.remember-me') }}
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('auth.login') }}
                </button>

                @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                  {{ __('auth.forgotpassword?') }}
                </a>
                @endif
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="bike">
  <div class="part frame">
    <div class="bar left-top"></div>
    <div class="bar left-bottom"></div>
    <div class="bar left"></div>
    <div class="bar top"></div>
    <div class="bar bottom"></div>
    <div class="bar right"></div>
  </div>
  <div class="part sadle">
    <div class="sit-here"></div>
    <div class="sadlepen"></div>
  </div>
  <div class="part handlebar">
    <div class="stem"></div>
    <div class="connector"></div>
    <div class="prehandle"></div>
    <div class="handle"></div>
  </div>
  <div class="part pedals">
    <div class="inside"></div>
    <div class="outside"></div>
    <div class="pedalstem front">
      <div class="pedalbase front"></div>
    </div>
    <div class="pedalstem back">
      <div class="pedalbase back"></div>
    </div>
  </div>
  <div class="part wheel left">
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
  </div>
  <div class="part wheel right">
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
  </div>
  <div class="part axis left"></div>
  <div class="part axis right"></div>
</div>

<div class="bike bike-two">
  <div class="part frame">
    <div class="bar left-top"></div>
    <div class="bar left-bottom"></div>
    <div class="bar left"></div>
    <div class="bar top"></div>
    <div class="bar bottom"></div>
    <div class="bar right"></div>
  </div>
  <div class="part sadle">
    <div class="sit-here"></div>
    <div class="sadlepen"></div>
  </div>
  <div class="part handlebar">
    <div class="stem"></div>
    <div class="connector"></div>
    <div class="prehandle"></div>
    <div class="handle"></div>
  </div>
  <div class="part pedals">
    <div class="inside"></div>
    <div class="outside"></div>
    <div class="pedalstem front">
      <div class="pedalbase front"></div>
    </div>
    <div class="pedalstem back">
      <div class="pedalbase back"></div>
    </div>
  </div>
  <div class="part wheel left">
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
  </div>
  <div class="part wheel right">
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
    <div class="spoke"></div>
  </div>
  <div class="part axis left"></div>
  <div class="part axis right"></div>
</div>
</div>
@endsection
