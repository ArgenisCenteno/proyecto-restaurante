<!-- Formulario de visualización de detalles -->
<form>
    <div class="row">
        <!-- Tipo -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="tipo"><strong>Tipo</strong></label>
                <input type="text" class="form-control" id="tipo" value="{{ $cuenta->tipo }}" readonly>
            </div>
        </div>

        <!-- Descripción -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="descripcion"><strong>Descripción</strong></label>
                <input type="text" class="form-control" id="descripcion" value="{{ $cuenta->descripcion }}" readonly>
            </div>
        </div>

        <!-- Monto -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="monto"><strong>Monto</strong></label>
                <input type="text" class="form-control" id="monto" value="{{ number_format($cuenta->monto, 2) }}" readonly>
            </div>
        </div>

        <!-- Pago ID o Sin Pagar -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="pago_id"><strong>Pago</strong></label>
                <input type="text" class="form-control" id="pago_id" value="{{ $cuenta->pago_id ? $cuenta->pago_id : 'Sin pagar' }}" readonly>
            </div>
        </div>

        <!-- Estado -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="estado"><strong>Estado</strong></label>
                <input type="text" class="form-control" id="estado" value="{{ $cuenta->estado }}" readonly>
            </div>
        </div>

        <!-- Fecha de creación -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="fecha_creacion"><strong>Fecha de Creación</strong></label>
                <input type="text" class="form-control" id="fecha_creacion" value="{{ $cuenta->created_at->format('Y-m-d') }}" readonly>
            </div>
        </div>
    </div>
</form>

<!-- Botón Pagar -->
<button type="button" class="btn btn-success mt-3" data-toggle="modal" data-target="#pagarModal">
    Pagar
</button>

<!-- Modal para el Pago -->
<div class="modal fade" id="pagarModal" tabindex="-1" aria-labelledby="pagarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('cuentas-por-pagar.update', $cuenta->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title" id="pagarModalLabel">Realizar Pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <!-- Monto -->
                    <div class="form-group">
                        <label for="monto_pago"><strong>Monto a Pagar</strong></label>
                        <input type="text" class="form-control" name="monto_pago" id="monto_pago" value="{{$cuenta->monto }}" readonly>
                    </div>

                    <!-- Tipo de Pago -->
                    <div class="form-group">
                        <label for="tipo_pago"><strong>Tipo de Pago</strong></label>
                        <select class="form-control" id="tipo_pago" name="tipo_pago" required>
                            <option value="" disabled selected>Seleccione un tipo de pago</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Pago Movil">Pago Móvil</option>
                            <option value="Punto de Venta">Punto de Venta</option>
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Confirmar Pago</button>
                </div>
            </form>
        </div>
    </div>
</div>
