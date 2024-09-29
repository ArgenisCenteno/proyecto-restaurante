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
                                <h3 class="p-2 bold">Detalles de la Notificación</h3>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('notificaciones.index') }}" class="btn btn-primary mt-3">Volver</a>

                            </div>
                        </div>
                        <div class="card-body">

                        <p>{{ $notification->data['message'] ?? 'Detalles de la notificación' }}</p>
                        <p><strong>Fecha:</strong> {{ $notification->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> <!--end::App Main--> <!--begin::Footer-->
@endsection
