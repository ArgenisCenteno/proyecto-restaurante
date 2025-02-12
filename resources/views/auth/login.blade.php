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
              <form method="POST" action="{{ route('login') }}" style="width: 100%;">
                @csrf

                <h3 class="fw-normal mb-3 pb-1 text-center" style="letter-spacing: 1px;">
                  <strong>Cúmana Grill</strong>
                </h3>

                <!-- Email Field -->
                <div class="form-outline mb-4">
                  <label class="form-label" for="email">Correo Electrónico</label>
                  <input type="email" id="email" name="email" class="form-control form-control-lg"
                    value="{{ old('email') }}" required autofocus />
                  @error('email')
                    <p class="text-danger">{{ $message }}</p> <!-- Validation error -->
                  @enderror
                </div>

                <!-- Password Field -->
                <div class="form-outline mb-4">
                  <label class="form-label" for="password">Contraseña</label>
                  <input type="password" id="password" name="password" class="form-control form-control-lg" required />
                  @error('password')
                    <p class="text-danger">{{ $message }}</p> <!-- Validation error -->
                  @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-1 mb-4">
                  <button class="btn btn-primary" type="submit">Acceder</button>
                </div>
                <p class=" mb-5 pb-lg-2">
              <a  href="{{ route('password.request') }}">Recuperar Contraseña</a>
            </p>

              </form>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>
@endsection
