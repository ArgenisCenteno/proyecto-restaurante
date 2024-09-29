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
                                <h3 class="p-2 bold">Notificaciones</h3>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                            </div>
                        </div>
                        <div class="card-body">

                            <ul class="list-group mt-3">
                                @forelse($notificaciones as $notificacion)
                                    <li class="list-group-item {{ $notificacion->read_at ? '' : 'bg-light' }}">
                                        <a href="{{$notificacion->data['url']}}">
                                            {{-- Muestra el mensaje de la notificación --}}
                                            {{ $notificacion->data['message'] ?? 'Notificación' }}

                                            {{-- Muestra el tipo de notificación --}}
                                            @if(isset($notificacion->data['type']))
                                                <span class="badge bg-secondary ms-2">{{ $notificacion->data['type'] }}</span>
                                            @endif

                                            <span class="text-muted">{{ $notificacion->created_at->diffForHumans() }}</span>
                                        </a>

                                        <form action="{{ route('notificaciones.destroy', $notificacion->id) }}"
                                            method="POST" class="d-inline-block float-end">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </li>
                                @empty
                                    <li class="list-group-item">No hay notificaciones.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> <!--end::App Main--> <!--begin::Footer-->
@endsection