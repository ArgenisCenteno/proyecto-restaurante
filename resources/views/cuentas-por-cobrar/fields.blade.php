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
