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
                        <div class="col-md-6 col-6">
                            <h3 class="p-2 bold">Histrorial de Compras</h3>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                                <form action="{{ route('ventas.export') }}" method="GET">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label for="start_date">Inicio:</label>
                                            <input type="date" class="form-control" name="start_date" id="start_date"
                                                required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="end_date">Fin:</label>
                                            <input type="date" class="form-control" name="end_date" id="end_date"
                                                required>
                                        </div>

                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary mt-4">Exportar</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                    </div>
                    <div class="card-body">
                  
                        @include('compras.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main> <!--end::App Main--> <!--begin::Footer-->
@endsection
