<header id="header" class="header fixed-top" style="margin-bottom: 80px !important;">
  <!-- Top Bar -->
  <div class="topbar d-flex align-items-center bg-warning">
    <div class="container d-flex justify-content-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope d-flex align-items-center">
          <a href="mailto:contact@example.com">cumanagrill@gmail.com</a>
        </i>
        <i class="bi bi-phone d-flex align-items-center ms-4">
          <span>+58 04248085560</span>
        </i>
      </div>
      <div class="social-links d-none d-md-flex align-items-center">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
      </div>
    </div>
  </div>
  <!-- End Top Bar -->

  <div class="branding d-flex align-items-center">
    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="{{ url('/home') }}" class="logo d-flex align-items-center">
        <h1 class="sitename">Cumana Grill</h1>
        <span>.</span>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li class="dropdown">
            <a href="#"><span>Ventas</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="{{ route('ventas.vender') }}">Nueva Venta</a></li>
              <li><a href="{{ route('ventas.index') }}">Historial</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#"><span>Compras</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="{{ route('compras.comprar') }}">Nueva Compra</a></li>
              <li><a href="{{ route('compras.index') }}">Historial</a></li>
            </ul>
          </li>
          <li><a href="{{ route('almacen') }}">Productos</a></li>
         
          <li class="dropdown">
            <a href="#"><span>Transacciones</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="{{ route('pagos.index') }}">Pagos</a></li>
              <li><a href="{{ route('cuentas-por-cobrar.index') }}">Cuentas Por Cobrar</a></li>
              <li><a href="{{ route('cuentas-por-pagar.index') }}">Cuentas Por Pagar</a></li>
              <li><a href="{{ route('proveedores.create') }}">Nuevo Proveedor</a></li>
              <li><a href="{{ route('proveedores.index') }}">Proveedores</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#"><span>Caja</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="{{ route('cajas.index') }}">Cajas</a></li>
              <li><a href="{{ route('caja.aperturas') }}">Aperturas</a></li>
              <li><a href="{{ route('caja.cierres') }}">Cierres</a></li>
            </ul>
          </li>
          <li class="dropdown user-menu">
            <a href="#"><span>{{ Auth::user()->name }}</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  Salir
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </li>
            </ul>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </div>
</header>

@include('layout.script')
