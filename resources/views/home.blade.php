@extends('layout.app')
@section('content')

<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Sistema de Gestión de Ventas</h3>
                </div>
                <div class="col-sm-6">
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row"> <!--begin::Combined Small Box Widget-->
                <div class="col-lg-12"> <!-- Full width for the combined box -->
                    <div class="small-box text-bg-primary"> <!-- Light background for the combined box -->
                        <div class="inner">
                            <div class="row ">
                                <div class="col-lg-3 col-6 position-relative"> <!--begin::Small Box Widget 1-->
                                    <div class="">
                                        <div class="inner">
                                            <h3>{{$ventas}}</h3>

                                            <p>Ventas</p>
                                            <i class="fas fa-shopping-cart fa-2x"></i> <!-- Icon for Ventas -->

                                        </div>
                                    </div> <!--end::Small Box Widget 1-->
                                    <div class="separator"></div> <!-- Separator -->
                                </div> <!--end::Col-->
                                <div class="col-lg-3 col-6 position-relative"> <!--begin::Small Box Widget 2-->
                                    <div class="">
                                        <div class="inner">
                                            <h3>{{$compras}}<sup class="fs-5"></sup></h3>
                                            <p>Compras</p>
                                            <i class="fas fa-money-bill-wave fa-2x"></i> <!-- Icon for Compras -->

                                        </div>
                                    </div> <!--end::Small Box Widget 2-->
                                    <div class="separator"></div> <!-- Separator -->
                                </div> <!--end::Col-->
                                <div class="col-lg-3 col-6 position-relative"> <!--begin::Small Box Widget 3-->
                                    <div class="">
                                        <div class="inner">
                                            <h3>{{$usuarios}}</h3>
                                            <p>Usuarios Registrados</p>
                                            <i class="fas fa-users fa-2x text-right"></i> <!-- Icon for Usuarios Registrados -->

                                        </div>
                                    </div> <!--end::Small Box Widget 3-->
                                    <div class="separator"></div> <!-- Separator -->
                                </div> <!--end::Col-->
                                <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 4-->
                                    <div class="">
                                        <div class="inner">
                                            <h3>{{$productos}}</h3>
                                            <p>Productos</p>
                                            <i class="fas fa-box-open fa-2x"></i> <!-- Icon for Productos -->

                                        </div>
                                    </div> <!--end::Small Box Widget 4-->
                                </div> <!--end::Col-->
                            </div> <!--end::Row for small boxes-->
                        </div> <!--end::Inner for combined box-->
                    </div> <!--end::Small Box for combined box-->
                </div> <!--end::Col for combined box-->
            </div> <!--end::Row for combined box-->
        </div> <!--end::Container-->
    </div> <!--end::App Content-->
</main> <!--end::App Main-->

@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>

<style>
.separator {
    position: absolute;
    right: 0;
    top: 0;
    width: 1px; /* Width of the separator */
    height: 100%; /* Full height */
    background-color: #ffffff; /* Color of the separator */
    z-index: 1; /* Place it above the background */
}

.col-lg-3.col-6:last-child .separator {
    display: none; /* Hide the separator for the last column */
}
</style>

@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
