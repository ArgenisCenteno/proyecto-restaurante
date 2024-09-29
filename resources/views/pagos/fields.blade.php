<form action="{{ route('pagos.update', $pago->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="tipo" class="form-label">Tipo</label>
            <input type="text" class="form-control" id="tipo" value="{{ $pago->tipo }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="fecha_pago" class="form-label">Fecha de Pago</label>
            <input type="text" class="form-control" id="fecha_pago" value="{{ $pago->fecha_pago }}" readonly>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="monto_total" class="form-label">Monto Total</label>
            <input type="text" class="form-control" id="monto_total" value="{{ $pago->monto_total }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="monto_neto" class="form-label">Monto Neto</label>
            <input type="text" class="form-control" id="monto_neto" value="{{ $pago->monto_neto }}" readonly>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="descuento" class="form-label">Descuento</label>
            <input type="text" class="form-control" id="descuento" value="{{ $pago->descuento }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="tasa_dolar" class="form-label">Tasa Dólar</label>
            <input type="text" class="form-control" id="tasa_dolar" value="{{ $pago->tasa_dolar }}" readonly>
        </div>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Estado</label>
        <select class="form-select" id="status" name="status" required>
            <option value="Pendiente" {{ $pago->status == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="Pagado" {{ $pago->status == 'Pagado' ? 'selected' : '' }}>Pagado</option>
            <option value="Rechazado" {{ $pago->status == 'Rechazado' ? 'selected' : '' }}>Rechazado</option>
            <!-- Add other statuses as needed -->
        </select>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('pagos.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>