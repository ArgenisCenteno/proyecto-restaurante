<form action="{{ route('ventas.generarVenta') }}" method="POST">
    @csrf <!-- Agrega el token CSRF para seguridad -->
    <section>



        <div class="text-center mt-4 card pt-2 pb-2 bg-success text-white"
            style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
            <h3>Total a Pagar: <span id="totalVenta" class="totalVenta">0.00</span></h3>
        </div>
        <div class="text-center mt-1 card pt-2 pb-2 bg-dark text-white"
            style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
            <h3>Pagado: <span id="cancelado" class="cancelado">0.00</span></h3>
        </div>
        <div class="text-center mt-1 card pt-2 pb-2 bg-dark text-white"
            style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
            <h3>Restante: <span id="restante" class="restante">0.00</span></h3>
        </div>
        <hr />
        <div class="text-center mt-1 card pt-2 pb-2 bg-info text-white"
            style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
            <h3>Tasa de hoy: {{$dollar}}</h3>
            <input type="hidden" name="tasa" id="tasa" value="{{$dollar}}">
        </div>

        <div class="text-center mt-1 card pt-2 pb-2 bg-secondary text-white"
            style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
            <h3>Empleado: {{auth()->user()->name}}</h3>
        </div>

        <hr />

        <div class="productoCarrito" id="productoCarrito">

        </div>
        <input type="hidden" name="productos" id="productosInput">
        <input type="hidden" name="metodos_pago" id="metodosPagoInput">
        <div class="text-center mt-1 card pt-2 pb-2 bg-dark text-white w-full"
            style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
            <h3>Caja</h3>
        </div>
        <select name="caja" id="caja" class="form-control select2 mb-2 mt-2">
                    @foreach($cajas as $caja)
                        <option value="{{ $caja->id }}">{{ $caja->nombre }}</option>
                    @endforeach
                </select>
        <div class="text-center mt-1 card pt-2 pb-2 bg-dark text-white w-full"
            style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
            <h3>Mesa</h3>
           
        </div>
        <select name="user_id" id="user_id" class="form-control select2 mb-2 mt-2">
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
        <div class="text-center mt-1 card pt-2 pb-2 bg-dark text-white w-full"
            style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
            <h3>Cliente</h3>
        </div>
        <div class="d-flex flex-column mb-3" style="width: 100% important">
            <div data-mdb-ripple-init class="btn-group-vertical" role="group" aria-label="Vertical button group">




                <select name="user_id" id="user_id" class="form-control select2 mb-2 mt-2">
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>


            </div>
            <div id="metodosPagoContainer">
                <div class="text-center mt-2 mb-2 card pt-2 pb-2 bg-dark text-white"
                    style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                    <h3>Aplicar Pago</h3>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <select class="form-select" id="metodoPago">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Pago Movil">Pago Móvil</option>
                            <option value="Divisa">Divisa</option>
                            <option value="Punto de Venta">Punto de Venta</option>
                            <option value="A credito">A credito</option>
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
                </div>
            </div>
        </div>
        <div id="metodosPagoList"></div>


        <button style="width: 100%" type="submit" id="submitBtn" class="btn btn-primary" disabled>Generar Venta</button>
        </div>

    </section>

</form>