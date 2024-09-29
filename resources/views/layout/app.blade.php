<html>
@include('layout.head')
<style>
    tr{
        background-color: #343a40;
        color: white;
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