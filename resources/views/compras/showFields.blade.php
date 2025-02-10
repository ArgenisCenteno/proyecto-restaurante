<div class="">
    <!-- Información de la compra -->

    <form>
        <div class="card mb-4">
            <div class="card-header">
                <h5>Detalles de la Compra</h5>
            </div>
            <div class="row p-3">
                <!-- Vendedor -->
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="vendedor">Comprador</label>
                        <input type="text" class="form-control" id="vendedor" value="{{ $compra->user->name }}"
                            readonly>
                    </div>
                </div>

                <!-- Cliente -->
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="cliente">Proveedor</label>
                        <input type="text" class="form-control" id="cliente"
                            value="{{ $compra->proveedor->razon_social }}" readonly>
                    </div>
                </div>

                <!-- Monto Total -->
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="monto_total">Monto Total</label>
                        <input type="text" class="form-control" id="monto_total"
                            value="{{ number_format($compra->monto_total, 2) }}" readonly>
                    </div>
                </div>
            </div>

            <div class="row p-3">
                <!-- Monto Neto -->
                 

                <!-- Estado del Pago -->
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="status_pago">Estado del Pago</label>
                        <input value="{{ $compra->pago->status ?? 'Sin pagar' }}" readonly class="form-control" />
                    </div>
                </div>

                <!-- Fecha de compra -->
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="fecha_compra">Fecha de compra</label>
                        <input type="text" class="form-control" id="fecha_compra"
                            value="{{ $compra->created_at->format('Y-m-d') }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <!-- Detalles de compra -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Detalles de la compra</h5>
        </div>
        <div class="card-body  table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                      
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Impuesto</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compra->detallecompras as $detalle)
                        <tr>
                            <td>{{ $detalle->id }}</td>
                            <td>{{ $detalle->producto->nombre }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>{{ number_format($detalle->neto, 2) }}</td>
                            <td>{{ number_format($detalle->impuesto, 2) }}</td>
                            <td>{{ number_format($detalle->impuesto + $detalle->neto, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pago -->
     
    @if(isset($venta->pago) && $venta->tipo == 'Regular')
    <div class="mb-4">
    <div class="card mb-4">
        <div class="card-header">
            <h5>Método de Pago</h5>
        </div>
        <div class="card-body  table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Método</th>
                        <th>Banco Origen</th>
                        <th>Banco Destino</th>
                        <th>Número de Referencia</th>
                        <th>Monto BS</th>
                        <th>Monto USD</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (json_decode($compra->pago->forma_pago) as $pago)
                        <tr>
                            <td>{{ $pago->metodo }}</td>
                            <td>{{ $pago->banco_origen }}</td>
                            <td>{{ $pago->banco_destino }}</td>
                            <td>{{ $pago->numero_referencia }}</td>
                            @if($pago->metodo == 'Divisa')
                                <td>{{ number_format(0, 2) }}</td>
                            @else
                                <td>{{ number_format($pago->monto_bs, 2) }}</td>
                            @endif
                            @if($pago->metodo != 'Divisa')
                                <td>{{ number_format(0, 2) }}</td>
                            @else
                                <td>{{ number_format($pago->monto_dollar, 2) }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif