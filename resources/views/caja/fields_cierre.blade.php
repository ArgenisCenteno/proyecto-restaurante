<div class="row">
    <!-- Tabla de Movimientos -->
    <div class="col-md-12 mb-4">
        <h4>Movimientos</h4>
        <div class="table-responsive">
            <table id="movimientos-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>

                        <th>Usuario</th>

                        <th>Tipo</th>
                        <th>Monto en Bolívares</th>
                        <th>Monto en Dólares</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($movimientos as $movimiento)
                        <tr>
                            <td>{{ $movimiento->id }}</td>
                            <td>{{ strtoupper($movimiento->usuario->name) }}</td>
                            <td>{{ strtoupper($movimiento->tipo) }}</td>
                            <td>{{ number_format($movimiento->monto_bolivares, 2) }}</td>
                            <td>{{ number_format($movimiento->monto_dolares, 2) }}</td>
                            <td>{{ strtoupper($movimiento->descripcion) }}</td>
                            <td>{{ $movimiento->fecha }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <!-- Tabla de Transacciones -->
    <div class="col-md-12 mb-4">
        <h4>Transacciones</h4>
        <div class="table-responsive">
            <table id="transacciones-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>

                        <th>Usuario</th>

                        <th>Tipo</th>
                        <th>Monto Total en Bolívares</th>
                        <th>Monto Total en Dólares</th>
                        <th>Método de Pago</th>
                        <th>Moneda</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($transacciones as $transaccion)
                        <tr>
                            <td>{{ $transaccion->id }}</td>
                            <td>{{strtoupper($transaccion->usuario->name)}}</td>
                            <td>{{strtoupper($transaccion->tipo)}}</td>
                            <td>{{ number_format($transaccion->monto_total_bolivares, 2) }}</td>
                            <td>{{ number_format($transaccion->monto_total_dolares, 2) }}</td>
                            <td>{{strtoupper($transaccion->metodo_pago)}}</td>
                            <td> {{strtoupper($transaccion->moneda)}} </td>
                            <td>{{ $transaccion->fecha }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Resumen de Totales -->
    <div class="col-md-6 mb-3">
        <h5>Totales de Transacciones</h5>
        <div class="form-group">
            <label>Total Monto en Bolívares:</label>
            <input type="text" class="form-control"
                value="{{ number_format($transacciones->sum('monto_total_bolivares'), 2) }}" readonly>
        </div>
        <div class="form-group">
            <label>Total Monto en Dólares:</label>
            <input type="text" class="form-control"
                value="{{ number_format($transacciones->sum('monto_total_dolares'), 2) }}" readonly>
        </div>
    </div>

    <!-- Totales por Método de Pago -->
    <div class="col-md-6 mb-3">
        <h5>Totales por Método de Pago (Transacciones)</h5>
        @foreach($transacciones->groupBy('metodo_pago') as $metodo => $transaccionesPorMetodo)
            <div class="form-group">
                <label>Total en {{ $metodo }}:</label>
                <input type="text" class="form-control"
                    value="{{ number_format($transaccionesPorMetodo->sum('monto_total_bolivares'), 2) }}" readonly>
            </div>
        @endforeach
    </div>

    <!-- Botón para Cerrar Caja -->
    <div class="col-md-12 mt-4">
        <form action="{{ route('caja.cierre', $caja->id) }}" method="POST">
        @csrf
        @method('PUT')
            <button type="submit" class="btn btn-danger btn-lg">Cerrar Caja</button>
        </form>
    </div>
</div>


@section('scripts')
<script>
    $(document).ready(function () {
        $('#movimientos-table').DataTable({
            order: [[0, 'desc']]
        });
        $('#transacciones-table').DataTable({
            order: [[0, 'desc']]
        });
    });
</script>
@endsection