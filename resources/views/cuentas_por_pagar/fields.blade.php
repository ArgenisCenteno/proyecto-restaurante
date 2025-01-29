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
                <label for="monto"><strong>Monto Total de Deuda</strong></label>
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

    <h4>Pagos de Cuentas</h4>
    
    <!-- Tabla de pagos -->
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            
            <th>Pago</th>
            <th>Banco Origen</th>
            <th>Banco Destino</th>
            <th>Referencia</th>
            <th>Monto Abonado</th>
            <th>Fecha de Pago</th>
        </tr>
    </thead>
    @php
     $deuda = 0;
     @endphp
    <tbody>
        @foreach($pagos as $index => $pagoCuenta)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $pagoCuenta->pago->tipo }}</td>
            @php
                // Decodificar el JSON para acceder a los atributos del array de objetos
                $formaPago = json_decode($pagoCuenta->pago->forma_pago) ?? [];
               
               $deuda += $pagoCuenta->monto_abono 
            @endphp
            @foreach($formaPago as $pago)
                <td>{{ $pago->banco_origen ?? '' }}</td>
                <td>{{ $pago->banco_destino ?? '' }}</td>
                <td>{{ $pago->numero_referencia ?? '' }}</td>
            @endforeach
        
            <td>{{ $pagoCuenta->pago->created_at->format('d-m-Y') }}</td>
            <td>{{ $pagoCuenta->monto_abono }}</td>
        </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          
            <td></td>
            <td class="bg-dark text-white"> {{$deuda}} </td>
        </tr>
    </tbody>
</table>
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

                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="pagarModalLabel">Realizar Pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Monto -->
                    <div class="form-group">
                        <label for="monto_pago"><strong>Monto a Pagar</strong></label>
                        <input type="number" step="any" class="form-control" name="monto_pago" id="monto_pago" value="{{ $cuenta->monto - $cuenta->monto_pagado}}" readonly>
                    </div>

                    <!-- Checkbox para otro monto -->
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="otroMontoCheckbox">
                        <label class="form-check-label" for="otroMontoCheckbox">Pagar un monto diferente</label>
                    </div>
                    <div class="form-group d-none" id="otroMontoContainer">
                        <label for="otro_monto"><strong>Nuevo Monto a Pagar</strong></label>
                        <input type="number" class="form-control" name="otro_monto" id="otro_monto" min="0" step="0.01">
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

                    <!-- Campos dinámicos -->
                    <div id="detallesPago" class="d-none">
                    <div class="form-group">
                            <label for="banco_origen"><strong>Banco Origen</strong></label>
                            <select class="form-control" id="bancoOrigen" name="banco_origen">
                                <option value="">Seleccione Banco Origen (Opcional)</option>
                                <option value="Banesco">Banesco</option>
                                <option value="Banco de Venezuela">Banco de Venezuela</option>
                                <option value="Mercantil">Mercantil</option>
                                <option value="BOD">BOD</option>
                                <option value="Banco Bicentenario">Banco Bicentenario</option>
                                <option value="Banco del Tesoro">Banco del Tesoro</option>
                                <option value="Banco Plaza">Banco Plaza</option>
                                <option value="Banco Nacional de Crédito">Banco Nacional de Crédito</option>
                                <option value="Banco Provincial">Banco Provincial</option>
                                <option value="Banco Exterior">Banco Exterior</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="banco_destino"><strong>Banco Destino</strong></label>
                            <select class="form-control" id="bancoDestino" name="banco_destino">
                                <option value="">Seleccione Banco Destino (Opcional)</option>
                                <option value="Banesco">Banesco</option>
                                <option value="Banco de Venezuela">Banco de Venezuela</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="referencia"><strong>Referencia</strong></label>
                            <input type="text" class="form-control" name="referencia" id="referencia">
                        </div>
                    </div>

                    <!-- Caja -->
                    <label for="caja"><strong>Caja</strong></label>
                    <select name="caja" id="caja" class="form-control select2 mb-2 mt-2" required>
                        @foreach($cajas as $caja)
                            <option value="{{ $caja->id }}">{{ $caja->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Confirmar Pago</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const montoMaximo = parseFloat(document.getElementById('monto_pago').value); // Monto máximo permitido
    const otroMontoInput = document.getElementById('otro_monto');
    const submitButton = document.querySelector('button[type="submit"]');

    // Mostrar/ocultar campos para otros métodos de pago
    document.getElementById('tipo_pago').addEventListener('change', function () {
        const detallesPago = document.getElementById('detallesPago');
        if (['Transferencia', 'Pago Movil', 'Punto de Venta'].includes(this.value)) {
            detallesPago.classList.remove('d-none');
        } else {
            detallesPago.classList.add('d-none');
        }
    });

    // Mostrar/ocultar campo para otro monto
    document.getElementById('otroMontoCheckbox').addEventListener('change', function () {
        const otroMontoContainer = document.getElementById('otroMontoContainer');
        if (this.checked) {
            otroMontoContainer.classList.remove('d-none');
            otroMontoInput.required = true; // Requiere el campo si se activa el checkbox
        } else {
            otroMontoContainer.classList.add('d-none');
            otroMontoInput.required = false;
            otroMontoInput.value = ''; // Limpia el valor si se desactiva
            submitButton.disabled = false; // Asegura que el botón esté habilitado
        }
    });

    // Validar el monto ingresado y bloquear el botón si es mayor al permitido
    otroMontoInput.addEventListener('input', function () {
        const montoIngresado = parseFloat(this.value) || 0; // Convierte el valor a número o 0 si está vacío
        if (montoIngresado > montoMaximo) {
            this.classList.add('is-invalid'); // Añade una clase para mostrar error
            submitButton.disabled = true; // Bloquea el botón
        } else {
            this.classList.remove('is-invalid'); // Quita la clase de error
            submitButton.disabled = false; // Habilita el botón
        }
    });
</script>