
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
                                <h4 class="p-2 bold">Editar Caja</h4>
                            </div>

                        </div>
                        <div class="card-body">
                            {!! Form::model($caja, ['route' => ['cajas.update', $caja->id], 'method' => 'PUT', 'class' => 'btn-create', 'enctype' => 'multipart/form-data']) !!}
                            @include('caja.edit_fields')
                            {!! Form::close() !!}

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