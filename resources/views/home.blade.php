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
                                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                                        <div class="small-box text-bg-success">
                                            <div class="inner">
                                                <h3>{{$ventas}}</h3>
                                                <p>Ventas</p>
                                            </div> <span class="material-icons small-box-icon"
                                                style="font-size: 100px">shopping_cart</span><a
                                                href="{{route('ventas.index')}}"
                                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                                Ver más <i class="bi bi-link-45deg"></i> </a>
                                        </div> <!--end::Small Box Widget 1-->
                                    </div> <!--end::Col-->
                                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                                        <div class="small-box text-bg-primary">
                                            <div class="inner">
                                                <h3>{{$compras}}</h3>
                                                <p>Compras</p>
                                            </div> <span class="material-icons small-box-icon"
                                                style="font-size: 100px">shopping_bag</span><a
                                                href="{{route('ventas.index')}}"
                                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                                Ver más <i class="bi bi-link-45deg"></i> </a>
                                        </div> <!--end::Small Box Widget 1-->
                                    </div> <!--end::Col-->
                                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                                        <div class="small-box text-bg-dark">
                                            <div class="inner">
                                                <h3> {{$productos}}</h3>
                                                <p>Productos</p>
                                            </div> <span class="material-icons small-box-icon"
                                                style="font-size: 100px">inventory</span><a href="{{route('ventas.index')}}"
                                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                                Ver más <i class="bi bi-link-45deg"></i> </a>
                                        </div> <!--end::Small Box Widget 1-->
                                    </div> <!--end::Col-->
                                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                                        <div class="small-box text-bg-info">
                                            <div class="inner">
                                                <h3>{{$dollar}}</h3>
                                                <p>Dolar</p>
                                            </div> <span class="material-icons small-box-icon"
                                                style="font-size: 100px">attach_money</span><a
                                                href="{{route('ventas.index')}}"
                                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                                Ver más <i class="bi bi-link-45deg"></i> </a>
                                        </div> <!--end::Small Box Widget 1-->
                                    </div> <!--end::Col-->



                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                                        <div class="small-box text-bg-secondary">
                                            <div class="inner">
                                                <h3>{{$proveedores}}</h3>
                                                <p>Proveedores</p>
                                            </div> <span class="material-icons small-box-icon"
                                                style="font-size: 100px">assured_workload</span><a
                                                href="{{route('ventas.index')}}"
                                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                                Ver más <i class="bi bi-link-45deg"></i> </a>
                                        </div> <!--end::Small Box Widget 1-->
                                    </div> <!--end::Col-->
                                    @if(Auth::user()->hasRole('superAdmin'))
                                        <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                                            <div class="small-box text-bg-warning">
                                                <div class="inner">
                                                    <h3>{{$usuarios}}</h3>
                                                    <p>Usuarios</p>
                                                </div> <span class="material-icons small-box-icon"
                                                    style="font-size: 100px">shopping_bag</span><a
                                                    href="{{route('ventas.index')}}"
                                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                                    Ver más <i class="bi bi-link-45deg"></i> </a>
                                            </div> <!--end::Small Box Widget 1-->
                                        </div> <!--end::Col-->
                                    @endif
                                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                                        <div class="small-box text-bg-danger">
                                            <div class="inner">
                                                <h3>{{$deudas}}</h3>
                                                <p>Cuentas por pagar</p>
                                            </div> <span class="material-icons small-box-icon"
                                                style="font-size: 100px">payments</span><a href="{{route('ventas.index')}}"
                                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                                Ver más <i class="bi bi-link-45deg"></i> </a>
                                        </div> <!--end::Small Box Widget 1-->
                                    </div> <!--end::Col-->

                                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                                        <div class="small-box text-bg-success">
                                            <div class="inner">
                                                <h3>{{$creditos}}</h3>
                                                <p>Cuentas por cobrar</p>
                                            </div> <span class="material-icons small-box-icon"
                                                style="font-size: 100px">account_balance_wallet</span><a
                                                href="{{route('ventas.index')}}"
                                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                                Ver más <i class="bi bi-link-45deg"></i> </a>
                                        </div> <!--end::Small Box Widget 1-->
                                    </div> <!--end::Col-->
                                </div>
                            </div> <!--end::Inner for combined box-->
                        </div> <!--end::Small Box for combined box-->
                    </div> <!--end::Col for combined box-->
                </div> <!--end::Row for combined box-->

                <hr>

                <div class="row">
                    @foreach($mesas as $mesa)
                        <div class="col-md-3 mb-4">
                            <div class="small-box text-bg-{{ $mesa->estado === 'Ocupada' ? 'danger' : 'success' }}">
                                <div class="inner">
                                    <h3>Mesa {{ $mesa->numero }}</h3>
                                    <p>{{ ucfirst($mesa->estado) }}</p>
                                </div>

                                <span class="material-icons small-box-icon" style="font-size: 100px;">
                                    table_restaurant
                                </span>

                            
                                @if($mesa->estado === 'Ocupada' && $mesa->ventaActiva && $mesa->ventaActiva->cuenta)
                                    <a href="{{ route('cuentas-por-cobrar.show', $mesa->ventaActiva->cuenta->id) }}"
                                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                       Pagar <i class="bi bi-link-45deg"></i>
                                    </a>
                                    <a href="{{ route('ventas.edit', $mesa->ventaActiva->id) }}"
                                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                       Modificar <i class="bi bi-link-45deg"></i>
                                    </a>
                                @else
                                    <span class="small-box-footer text-light">
                                        Sin venta activa
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
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