@extends('layouts.app')

@section('content')
<section class="vh-100 p-0 bg-light" style="background-image: url('{{ asset('/iconos/fondo.jpeg') }}'); background-size: cover; background-position: center;">
  <div class="container-fluid">
    <div class="row min-vh-100 d-flex justify-content-center align-items-center">
      <div class="col-sm-12 text-black">

        <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5 justify-content-center">
          
          <!-- Login Card with Border -->
          <div class="card bg-white" style="width: 23rem; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
            <div class="card-body">
              
              <!-- Logo Image -->
              <div class="text-center mb-4">
                <img src="{{ asset('/iconos/logo.jpg') }}" alt="Logo" style="max-width: 150px; border-radius: 8px;">
              </div>
              
              <!-- Login Form -->
              <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Nueva Contraseña') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">{{ __('Confirmar Contraseña') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-key"></i> {{ __('Restablecer Contraseña') }}
                        </button>
                    </div>
                </form>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>
@endsection
