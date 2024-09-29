@extends('layouts.app')

@section('content')
<!-- Section: Design Block -->
<section class="text-center">
  <!-- Background image -->
  <div class="bg-image" style="
        background-image: url('https://mdbootstrap.com/img/new/textures/full/171.jpg');
        height: 200px;
        "></div>
  <!-- Background image -->

  <div class="card mx-4 mx-md-5 shadow-5-strong bg-body-tertiary" style="
        margin-top: -100px;
        backdrop-filter: blur(30px);
        ">
    <div class="card-body py-5 px-md-5">

      <div class="row d-flex justify-content-center">
        <div class="col-lg-8">
          <h2 class="fw-bold mb-5">Registrarse</h2>

          <!-- Formulario de registro -->
          <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf <!-- Token CSRF para Laravel -->

            <!-- 2 columnas para Nombre y Cédula -->
            <div class="row">
              <div class="col-md-6 mb-4">
                <div class="form-outline">
                  <label class="form-label" for="name">Nombre Completo</label>
                  <input type="text" id="name" name="name" class="form-control" required />
                  @error('name')
                <p class="text-danger">{{ $message }}</p> <!-- Mostrar error de validación -->
              @enderror
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <div class="form-outline">
                  <label class="form-label" for="cedula">Cédula de Identidad</label>
                  <input type="text" id="cedula" name="cedula" class="form-control" required />
                  <p class="text-danger" id="cedulaError" style="display: none;">Cédula inválida.</p>
                  @error('dni')
                <p class="text-danger">{{ $message }}</p> <!-- Mostrar error de validación -->
              @enderror
                </div>
              </div>
            </div>

            <!-- Correo Electrónico -->
            <div class="form-outline mb-4">
              <label class="form-label" for="email">Correo Electrónico</label>
              <input type="email" id="email" name="email" class="form-control" required />
              @error('email')
                <p class="text-danger">{{ $message }}</p> <!-- Mostrar error de validación -->
              @enderror
            </div>

            <!-- Sector, Calle y Casa -->
            <div class="row">
              <div class="col-md-4 mb-4">
                <div class="form-outline">
                  <label class="form-label" for="sector">Sector</label>
                  <input type="text" id="sector" name="sector" class="form-control" />
                </div>
              </div>
              <div class="col-md-4 mb-4">
                <div class="form-outline">
                  <label class="form-label" for="calle">Calle</label>
                  <input type="text" id="calle" name="calle" class="form-control" />
                </div>
              </div>
              <div class="col-md-4 mb-4">
                <div class="form-outline">
                  <label class="form-label" for="casa">Casa</label>
                  <input type="text" id="casa" name="casa" class="form-control" />
                </div>
              </div>
            </div>

            <!-- 2 columnas para Contraseña y Confirmar Contraseña -->
            <div class="row">
              <div class="col-md-6 mb-4">
                <div class="form-outline">
                  <label class="form-label" for="password">Contraseña</label>
                  <input type="password" id="password" name="password" class="form-control" required />
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <div class="form-outline">
                  <label class="form-label" for="confirm_password">Confirmar Contraseña</label>
                  <input type="password" id="confirm_password" name="confirm_password" class="form-control" required />
                  <p class="text-danger" id="passwordError" style="display: none;">Las contraseñas no coinciden.</p>
                </div>
              </div>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="btn btn-primary btn-block mb-4">
              Registrarse
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Section: Design Block -->

<!-- Scripts para validar cédula y contraseñas -->
<script>
  document.getElementById('registerForm').addEventListener('submit', function (event) {
    // Obtener valores
    const cedula = document.getElementById('cedula').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    let valid = true;

    // Validar cédula (7 u 8 dígitos, sin letras, y no puede empezar con cero)
    const cedulaPattern = /^[1-9][0-9]{6,7}$/;
    if (!cedulaPattern.test(cedula)) {
      valid = false;
      document.getElementById('cedulaError').style.display = 'block';
    } else {
      document.getElementById('cedulaError').style.display = 'none';
    }

    // Validar que las contraseñas coincidan
    if (password !== confirmPassword) {
      valid = false;
      document.getElementById('passwordError').style.display = 'block';
    } else {
      document.getElementById('passwordError').style.display = 'none';
    }

    // Prevenir el envío del formulario si hay errores
    if (!valid) {
      event.preventDefault();
    }
  });
</script>
@endsection
