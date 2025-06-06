<form id="ventaForm" action="{{ route('ventas.generarVenta') }}" method="POST">
    @csrf <!-- Agrega el token CSRF para seguridad -->
    <section>
        <div class="row">
            <div class="col-md-6">
                <div class="text-center mt-4 card pt-2 pb-2 bg-success text-white"
                    style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                    <h5>Total: <span id="totalVenta" class="totalVenta">0.00</span></h5>
                </div>
                <div class="text-center mt-4 card pt-2 pb-2 bg-warning text-white"
                    style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                    <h5>Total : <span id="totalVentaBs" class="totalVentaBS">0.00</span></h5>
                </div>
                <div class="text-center mt-1 card pt-2 pb-2 bg-dark text-white"
                    style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                    <h5>Pagado: <span id="cancelado" class="cancelado">0.00</span></h5>
                </div>
                <div class="text-center mt-1 card pt-2 pb-2 bg-dark text-white"
                    style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                    <h5>Restante: <span id="restante" class="restante">0.00</span></h5>
                </div>
                <hr />
                <div class="text-center mt-1 card pt-2 pb-2 bg-info text-white"
                    style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                    <h5>Tasa de hoy: {{$dollar}}</h5>
                    <input type="hidden" name="tasa" id="tasa" value="{{$dollar}}">
                </div>
                <div class="text-center mt-1 card pt-2 pb-2 bg-secondary text-white"
                    style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                    <h5>Empleado: {{auth()->user()->name}}</h5>
                </div>
            </div>
            <div class="col-md-6">
                <input type="hidden" name="productos" id="productosInput">
                <input type="hidden" name="metodos_pago" id="metodosPagoInput">
                <div id="metodosPagoContainer">
                    <div class="text-center mt-4 mb-4 card pt-2 pb-2 bg-dark text-white"
                        style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                        <h5>Aplicar Pago</h5>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <select class="form-select" id="metodoPago">
                                  <option value="A credito">A credito</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Transferencia">Transferencia</option>
                                <option value="Pago Movil">Pago Móvil</option>
                                <option value="Divisa">Divisa</option>
                                <option value="Punto de Venta">Punto de Venta</option>
                              
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="number" class="form-control" id="cantidadPagada" placeholder="Cantidad ">
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" id="bancoOrigen">
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

                        <div class="col-md-6">
                            <select class="form-control" id="bancoDestino">
                                <option value="">Seleccione Banco Destino (Opcional)</option>
                                <option value="Banesco">Banesco</option>
                                <option value="Banco de Venezuela">Banco de Venezuela</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <input type="text" class="form-control" id="numeroReferencia"
                                placeholder=" Referencia (Opcional)">
                        </div>
                        
                        
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success w-100" id="agregarMetodoPago">Agregar
                                Método</button>
                                
                        </div>
                        <div class="col-md-12">
                        <p id="mensajeAdvertencia" style="display: none; color: red; font-weight: bold;">
                        Por favor, complete los campos Banco Origen, Banco Destino y Referencia.
                        </p>
                        </div>
                    </div>
                </div>
                <div class="text-center card pt-2 mt-4 pb-2 bg-dark text-white w-full"
                    style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                    <h5>Caja</h5>
                </div>
                <select name="caja" id="caja" class="form-control select2 mb-2 mt-2">
                    @foreach($cajas as $caja)
                        <option value="{{ $caja->id }}">{{ $caja->nombre }}</option>
                    @endforeach
                </select>

                <div id="metodosPagoList"></div>
            </div>
            <div>
                <div>
                    <div class="text-center mt-1 card pt-2 pb-2 bg-dark text-white w-full"
                        style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                        <h5>Mesa</h5>

                    </div>
               
                        <select class="form-select select2 mt-4" id="mesa_id" name="mesa_id">
                            <option value="">Seleccione una mesa</option>
                            @foreach($mesas as $mesa)
                                <option value="{{ $mesa->id }}">{{ $mesa->numero }}</option>
                            @endforeach
                          
                        </select>
                 

                </div>
                <div>
                    <div class="text-center mt-1 card pt-2 pb-2 bg-dark text-white w-full"
                        style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                        <h5>Cliente</h5>
                    </div>

                    <div class="d-flex flex-column mb-3" style="width: 100% !important;">
                        <div data-mdb-ripple-init class="btn-group-vertical" role="group"
                            aria-label="Vertical button group">
                            <select name="user_id" id="user_id" class="form-control select2 mb-2 mt-2">
                                @foreach($users as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="button" class="btn btn-primary mt-2 " id="showRegisterForm">Registrar
                            Cliente</button>

                        <div id="registerClientForm" class="mt-3 card p-3" style="display: none;">
                            <h5 class="text-center bg-dark text-white p-2">Nuevo Cliente</h5>
                            <div class="mb-2">
                                <label for="cedula" class="form-label">Cédula</label>
                                <input type="text" class="form-control" id="cedula" name="cedula"
                                    placeholder="Ingrese la cédula">
                            </div>
                            <div class="mb-2">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Ingrese el nombre">
                            </div>
                            <div class="mb-2">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Ingrese el email">
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>






        <hr />





        <button style="width: 100%" type="button" id="submitBtn" class="btn btn-primary" disabled data-bs-toggle="modal"
            data-bs-target="#confirmModal">Generar Venta</button>

        </div>

    </section>
    <!-- Botón para abrir el modal -->

    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h2 class="modal-title" id="confirmModalLabel">Confirmar venta</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-black" id="totalModal"></h3>
                    <h3 class="text-success" id="totalModalBs"></h3>
                    <div id="confirmProductoCarrito" class="productoCarrito"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmVenta">Confirmar Venta</button>
                </div>
            </div>
        </div>
    </div>

</form>

<script>
    document.getElementById('showRegisterForm').addEventListener('click', function () {
        let form = document.getElementById('registerClientForm');
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    });

    document.getElementById('saveClient').addEventListener('click', function () {
        let cedula = document.getElementById('cedula').value;
        let name = document.getElementById('name').value;
        let email = document.getElementById('email').value;

        if (!cedula || !name || !email) {
            alert('Todos los campos son obligatorios');
            return;
        }

        document.getElementById('registerClientForm').style.display = 'none';
    });
</script>

<script>
    $(document).ready(function () {
        $('#metodoPago, #bancoOrigen, #bancoDestino, #numeroReferencia').on('change input', function () {
            // Obtener los valores de los campos
            var metodoPago = $('#metodoPago').val();
            var bancoOrigen = $('#bancoOrigen').val();
            var bancoDestino = $('#bancoDestino').val();
            var numeroReferencia = $('#numeroReferencia').val();

            // Comprobamos si el método de pago es Transferencia, Pago Movil o Punto de Venta
            var metodoRequiereCampos = (metodoPago === 'Transferencia' || metodoPago === 'Pago Movil' || metodoPago === 'Punto de Venta');

            // Verificamos si los campos están vacíos o no
            var camposCompletos = (bancoOrigen !== '' && bancoDestino !== '' && numeroReferencia !== '');

            // Si el método requiere campos y los campos no están completos, mostramos advertencia y deshabilitamos el botón
            if (metodoRequiereCampos && !camposCompletos) {
                $('#agregarMetodoPago').prop('disabled', true);
                $('#mensajeAdvertencia').show(); // Mostrar mensaje de advertencia
            } else {
                $('#agregarMetodoPago').prop('disabled', false);
                $('#mensajeAdvertencia').hide(); // Ocultar mensaje de advertencia
            }
        });
    });

</script>