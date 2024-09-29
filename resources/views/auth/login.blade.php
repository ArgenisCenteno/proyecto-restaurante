@extends('layouts.app')

@section('content')
<section class="vh-100 p-0">
  <div class="container-fluid">
    <div class="row min-vh-100 d-flex justify-content-center align-items-center ">
      <div class="col-sm-12 text-black ">

        <div class=" d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5 justify-content-center">

          <!-- Formulario de inicio de sesión -->
          <form method="POST" action="{{ route('login') }}" style="width: 23rem;">
            @csrf <!-- Agregar token CSRF obligatorio -->

            <h3 class="fw-normal mb-3 pb-1 text-center" style="letter-spacing: 1px;"><strong>Cúmana Grill</strong></h3>
           

            <!-- Campo de correo electrónico -->
            <div class="form-outline mb-4 ">
              <label class="form-label" for="email">Correo Electrónico</label>
              <input type="email" id="email" name="email" class="form-control form-control-lg"
                value="{{ old('email') }}" required autofocus />
              @error('email')
                <p class="text-danger">{{ $message }}</p> <!-- Mostrar error de validación -->
              @enderror
            </div>

            <!-- Campo de contraseña -->
            <div class="form-outline mb-4">
              <label class="form-label" for="password">Contraseña</label>
              <input type="password" id="password" name="password" class="form-control form-control-lg" required />
              @error('password')
                <p class="text-danger">{{ $message }}</p> <!-- Mostrar error de validación -->
              @enderror
            </div>

            <!-- Botón de inicio de sesión -->
            <div class="pt-1 mb-4">
              <button class="btn btn-primary" type="submit">Acceder</button>
            </div>

            <!-- Enlace para recuperar la contraseña -->

          </form>

        </div>

      </div>
    </div>
  </div>
</section>
@endsection
