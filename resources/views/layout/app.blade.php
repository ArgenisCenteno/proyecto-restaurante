<html>
@include('layout.head')
<style>
    table thead tr th{
        background-color: #343a40 !important;
        /* Color de fondo oscuro */
        color: #ffffff !important;
        /* Color de texto blanco */
    }

    /* Opcional: Estilo para bordes y alineación */
    table thead th {
        border-color: #454d55 !important;
        /* Bordes oscuros para el encabezado */
        text-align: center;
        /* Centra el texto en el encabezado */
        padding: 10px;
        /* Espacio interno para las celdas del encabezado */
    }

    /* Opcional: Bordes para las celdas del cuerpo de la tabla */
    table tbody td {
        border-color: #dee2e6 !important;
        /* Color de bordes entre celdas */
    }
</style>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper"> <!--begin::Header-->
        @include('layout.cabecera')
        @yield('content')
        @stack('third_party_scripts')
        @stack('page_scripts')
    </div>
    @yield('js')
    @include('layout.script')
    @include('sweetalert::alert')
    @include('layout.datatables_css')
    @include('layout.datatables_js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</body>

</html>