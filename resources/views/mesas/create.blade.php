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
                                    <h4 class="p-2 bold">Registrar mesa</h4>
                                </div>
                                <div class="d-flex justify-content-end mt-3">


                                </div>

                            </div>
                            <div class="card-body">

                                <form action="{{ route('mesas.store') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="numero" class="form-label">Número de Mesa</label>
                                        <input type="text" name="numero" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="estado" class="form-label">Estado</label>
                                        <select name="estado" class="form-control" required>
                                            <option value="Disponible" selected>Disponible</option>
                                            <option value="Ocupada">Ocupada</option>
                                        </select>
                                    </div>



                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <a href="{{ route('mesas.index') }}" class="btn btn-secondary">Volver</a>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main> <!--end::App Main--> <!--begin::Footer-->
@endsection