@extends('layout.app')
@section('content')
<main class="app-main">
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
                                <h4 class="p-2 bold">Aperturas</h4>
                            </div>
                            <div class="col-md-6 col-6 text-right">
                                <!-- Buscador -->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="aperturas-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Caja</th>
                                            <th>Usuario</th>
                                            <th>Monto Inicial (Bolívares)</th>
                                            <th>Monto Inicial (Dólares)</th>
                                            <th>Apertura</th>
                                            <th>Fecha de Creación</th>
                                            <th>Última Actualización</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($aperturas as $apertura)
                                            <tr>
                                                <td>{{ $apertura->id }}</td>
                                                <td>{{ $apertura->caja->nombre }}</td>
                                                <td>{{ $apertura->usuario->name }}</td>
                                                <td>{{ number_format($apertura->monto_inicial_bolivares, 2, ',', '.') }}</td>
                                                <td>{{ number_format($apertura->monto_inicial_dolares, 2, ',', '.') }}</td>
                                                <td>{{ $apertura->apertura }}</td>
                                                <td>{{ $apertura->created_at->format('d/m/Y H:i') }}</td>
                                                <td>{{ $apertura->updated_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $apertura->estado === 'Finalizado' ? 'success' : 'danger' }}">
                                                        {{ $apertura->estado }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No hay aperturas registradas.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
@include('layout.script')
<!-- DataTables CSS y JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="{{ asset('js/sweetalert2.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#aperturas-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
            },
            "order": [[0, "desc"]],
            "responsive": true,
            "autoWidth": false
        });
    });
</script>
@endsection
