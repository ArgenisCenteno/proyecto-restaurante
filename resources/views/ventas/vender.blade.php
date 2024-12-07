@extends('layout.app')
@section('content')
<main class="app-main"> <!--begin::App Content Header-->
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 my-5">
                    <div class="px-2 row">
                        <div class="col-lg-12">
                            @include('flash::message')
                        </div>
                        <div class="col-md-12 col-2">
                            <h3 class="p-2 bold text-center">Punto de Venta</h3>
                        </div>
                       
                    </div>
                    <div class="card-body">
                  
                     <div class="row">
                        <div class="col-6">
                        @include('ventas.datatableProductos') 
                        </div>
                        <div class="col-6">
                         
                            @include('ventas.fields_venta') 
                        </div>
                     </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main> <!--end::App Main--> <!--begin::Footer-->
@endsection

@section('js')
@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="{{asset('js/sweetalert2.js')}}"></script>@endsection