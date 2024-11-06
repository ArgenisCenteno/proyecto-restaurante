<nav class="app-header navbar bg-warning navbar-expand bg-body"> <!--begin::Container-->
  <div class="container-fluid"> <!--begin::Start Navbar Links-->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="{{url('/home')}}">
          <span> <strong>Cumana Grill</strong> </span>
        </a>
      </li>
      <!-- Ventas Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="ventasDropdown" role="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          Ventas
        </a>
        <ul class="dropdown-menu" aria-labelledby="ventasDropdown">
          <li><a class="dropdown-item" href="{{route('ventas.vender')}}">Nueva Venta</a></li>
          <li><a class="dropdown-item" href="{{route('ventas.index')}}">Historial</a></li>
        </ul>
      </li>

      <!-- Compras Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="comprasDropdown" role="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          Compras
        </a>
        <ul class="dropdown-menu" aria-labelledby="comprasDropdown">
          <li><a class="dropdown-item" href="{{route('compras.comprar')}}">Nueva Compra</a></li>
          <li><a class="dropdown-item" href="{{route('compras.index')}}">Historial</a></li>
        </ul>
      </li>

      <!-- Productos Link -->
      <li class="nav-item">
        <a class="nav-link" href="{{route('almacen')}}">Productos</a>
      </li>

      <!-- Clasificador Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="monedaDropdown" role="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          Moneda
        </a>
        <ul class="dropdown-menu" aria-labelledby="monedaDropdown">
          <li><a class="dropdown-item" href="{{ route('tasas.create') }}">Nueva Moneda</a></li>
          <li><a class="dropdown-item" href="{{ route('tasas.index') }}">Monedas</a></li>
        </ul>
      </li>


      <!-- Transacciones Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="transaccionesDropdown" role="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          Transacciones
        </a>
        <ul class="dropdown-menu" aria-labelledby="transaccionesDropdown">
          <li><a class="dropdown-item" href="{{route('pagos.index')}}">Pagos</a></li>
          <li><a class="dropdown-item" href="{{route('cuentas-por-cobrar.index')}}">Cuentas Por Cobrar</a></li>
          <li><a class="dropdown-item" href="{{route('cuentas-por-pagar.index')}}">Cuentas Por Pagar</a></li>

          <li><a class="dropdown-item" href="{{route(name: 'proveedores.create')}}">Nuevo Proveedor</a></li>

          <li><a class="dropdown-item" href="{{route('proveedores.index')}}">Proveedores</a></li>
        </ul>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="transaccionesDropdown" role="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          Caja
        </a>
        <ul class="dropdown-menu" aria-labelledby="transaccionesDropdown">
          <li><a class="dropdown-item" href="{{route('cajas.index')}}">Cajas</a></li>
          <li><a class="dropdown-item" href="{{route('caja.aperturas')}}">Aperturas</a></li>
          <li><a class="dropdown-item" href="{{route('caja.cierres')}}">Cierres</a></li>

        </ul>
      </li>

    </ul>
    <ul class="navbar-nav ms-auto"> <!--begin::Navbar Search-->

      <!--begin::Messages Dropdown Menu-->




      <!--begin::User Menu Dropdown-->
      <li class="nav-item dropdown user-menu"> <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <span class="d-none d-md-inline">{{Auth::user()->name}}</span> </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <!--begin::User Image-->
          

          <li class="user-footer"> <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
              Salir
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li> <!--end::Menu Footer-->
        </ul>
      </li> <!--end::User Menu Dropdown-->
    </ul> <!--end::End Navbar Links-->
  </div> <!--end::Container-->
</nav> <!--end::Header--> <!--begin::Sidebar-->
@include('layout.script')
