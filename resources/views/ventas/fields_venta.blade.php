<form action="{{ route('ventas.generarVenta') }}" method="POST">
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
                    <select name="mesa" id="mesa" class="form-control select2 mb-2 mt-2">
                        <option value="Mesa 1">Mesa 1</option>
                        <option value="Mesa 2">Mesa 2</option>
                        <option value="Mesa 3">Mesa 3</option>
                        <option value="Mesa 4">Mesa 4</option>
                        <option value="Mesa 5">Mesa 5</option>
                        <option value="Mesa 6">Mesa 6</option>
                    </select>

                </div>
                <div>
                    <div class="text-center mt-1 card pt-2 pb-2 bg-dark text-white w-full"
                        style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                        <h5>Cliente</h5>
                    </div>
                    <div class="d-flex flex-column mb-3" style="width: 100% important">
                        <div data-mdb-ripple-init class="btn-group-vertical" role="group"
                            aria-label="Vertical button group">




                            <select name="user_id" id="user_id" class="form-control select2 mb-2 mt-2">
                                @foreach($users as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>


                        </div>

                    </div>
                </div>
            </div>
        </div>






        <hr />





        <button style="width: 100%" type="submit" id="submitBtn" class="btn btn-primary" disabled>Generar Venta</button>
        </div>

    </section>

</form>

