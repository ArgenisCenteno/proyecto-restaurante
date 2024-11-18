@extends('layout.app')
@section('content')
<style>
    /* card*/
    /* From Uiverse.io by Yaya12085 */
    .card-dash {
        padding: 1rem;

        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        max-width: 320px;
        border-radius: 20px;
    }

    .title {
        display: flex;
        align-items: center;
    }

    .title span {
        position: relative;
        padding: 0.5rem;

        width: 1.5rem;
        height: 1.5rem;
        border-radius: 9999px;
    }

    .title span i {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        height: 1rem;
    }

    .title-text {
        margin-left: 0.5rem;
        color: #f7f7f7;
        font-size: 18px;
    }

    .percent {
        margin-left: 0.5rem;
        color: #02972f;
        font-weight: 600;
        display: flex;
    }

    .data {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .data p {
        margin-top: 1rem;
        margin-bottom: 1rem;
        color: #e7e7e7;
        font-size: 1.25rem;
        line-height: 2.5rem;
        font-weight: 700;
        text-align: left;
    }

    .data .range {
        position: relative;
        background-color: #E5E7EB;
        width: 100%;
        height: 0.5rem;
        border-radius: 0.25rem;
    }

    .data .range .fill {
        position: absolute;
        top: 0;
        left: 0;
        background-color: #1083b9;
        width: 76%;
        height: 100%;
        border-radius: 0.25rem;
    }
</style>
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
                    <div class=" "> <!-- Light background for the combined box -->
                        <div class="inner">
                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <div class="card-dash bg-success">
                                        <div class="title d-flex justify-content-left align-items-left">
                                            <p class="title-text">
                                                Total Ventas
                                            </p>
                                            <span class="material-icons" style="font-size: 100px">shopping_cart</span>
                                            <!-- Nuevo ícono -->
                                        </div>
                                        <div class="data">
                                            <p>
                                                {{$ventas}}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card-dash bg-info">
                                        <div class="title d-flex justify-content-left align-items-left">
                                            <p class="title-text">
                                                Total Compras
                                            </p>
                                            <span class="material-icons" style="font-size: 100px">shopping_bag</span>
                                            <!-- Nuevo ícono -->
                                        </div>
                                        <div class="data">
                                            <p>
                                                {{$compras}}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card-dash bg-primary">
                                        <div class="title d-flex justify-content-left align-items-left">
                                            <p class="title-text">
                                                Total Productos
                                            </p>
                                            <span class="material-icons" style="font-size: 100px">inventory</span>
                                            <!-- Nuevo ícono -->
                                        </div>
                                        <div class="data">
                                            <p>
                                               {{$productos}}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card-dash bg-dark text-white">
                                        <div class="title d-flex justify-content-left align-items-left">
                                            <p class="title-text">
                                                Tasa del dolar
                                            </p>
                                            <span class="material-icons" style="font-size: 100px">attach_money</span>
                                            <!-- Icono actualizado -->
                                        </div>
                                        <div class="data">
                                            <p>
                                               {{$dollar}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <div class="card-dash bg-info">
                                        <div class="title d-flex justify-content-left align-items-left">
                                            <p class="title-text">
                                                Toal Pagos
                                            </p>
                                            <span class="material-icons" style="font-size: 100px">payments</span>
                                            <!-- Nuevo ícono -->
                                        </div>
                                        <div class="data">
                                            <p>
                                                {{$pagos}}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card-dash bg-dark">
                                        <div class="title d-flex justify-content-left align-items-left">
                                            <p class="title-text">
                                                Proveedores
                                            </p>
                                            <span class="material-icons" style="font-size: 100px">build</span>
                                            <!-- Nuevo ícono -->
                                        </div>
                                        <div class="data">
                                            <p>
                                               {{$proveedores}}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card-dash bg-danger">
                                        <div class="title d-flex justify-content-left align-items-left">
                                            <p class="title-text">
                                                Cuentas por Cobrar
                                            </p>
                                            <span class="material-icons" style="font-size: 100px"><span
                                                    class="material-symbols-outlined">
                                                    account_balance
                                                </span></span>
                                            <!-- Nuevo ícono -->
                                        </div>
                                        <div class="data">
                                            <p>
                                                {{$creditos}}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card-dash bg-secondary text-white">
                                        <div class="title d-flex justify-content-left align-items-left">
                                            <p class="title-text">
                                                Cuentas por Pagar
                                            </p>
                                            <span class="material-icons" style="font-size: 100px">
                                                card_travel
                                            </span>
                                            <!-- Icono actualizado -->
                                        </div>
                                        <div class="data">
                                            <p>
                                                {{$deudas}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        width: 1px;
        /* Width of the separator */
        height: 100%;
        /* Full height */
        background-color: #ffffff;
        /* Color of the separator */
        z-index: 1;
        /* Place it above the background */
    }

    .col-lg-3.col-6:last-child .separator {
        display: none;
        /* Hide the separator for the last column */
    }
</style>

@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">