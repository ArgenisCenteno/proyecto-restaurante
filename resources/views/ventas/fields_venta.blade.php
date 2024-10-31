<form action="{{ route('ventas.generarVenta') }}" method="POST">
    @csrf <!-- Agrega el token CSRF para seguridad -->
    <section>
      

       
        <div class="text-center mt-4 card pt-2 pb-2 bg-success text-white" style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
            <h3>Total a Pagar: <span id="totalVenta" class="totalVenta">0.00</span> Bs</h3>

         
            <input type="hidden" name="productos" id="productosInput">
         
        </div>
        <hr />


        <div class="d-flex flex-column mb-3">
            <div data-mdb-ripple-init class="btn-group-vertical" role="group" aria-label="Vertical button group">

              

                <label data-mdb-ripple-init class="bg-dark w-100 p-4  text-white " for="option1">
                    <div class="d-flex justify-content-between">
                    <span><i class="fas fa-dollar-sign"></i> Dollar: </span>

                        <input type="hidden" name="tasa" id="tasa" value="{{$dollar->valor}}">
                        <input type="hidden" name="id_tasa" value="{{$dollar->id}}">
                        <span>{{$dollar->valor}}</span>
                    </div>
                </label>

                <input type="radio" data-mdb-ripple-init class="btn-check" name="options" id="option2"
                    autocomplete="off" checked />
                <label data-mdb-ripple-init class="bg-dark w-100 p-4  text-white" for="option2">
                    <div class="d-flex justify-content-between">
                        <span><i class="fas fa-user "></i> Empleado </span>
                        <span>{{auth()->user()->name}}</span>
                    </div>
                </label>
              <label for="Cliente"> <i class="fas fa-user text-success mt-3"></i> Cliente</label>
                <select name="user_id" id="user_id" class="form-control select2 mb-2 mt-2">
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>


            </div>
            <div id="metodosPagoContainer">
               
                <div class="row g-3 mt-3">
                    <div class="col-md-12">
                        <label for=""><i class="fas fa-cash-register text-success"></i> Forma de Pago</label>
                        <select class="form-select" id="metodoPago" name="metodoPago">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Pago Movil">Pago Móvil</option>
                            <option value="Divisa">Divisa</option>
                            <option value="Punto de Venta">Punto de Venta</option>
                            <option value="A credito">A credito</option>
                        </select>
                    </div>
                   
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-12">
                        <label for=""><i class="fas fa-table text-success"></i> Mesa</label>
                        <select class="form-select" id="Mesa" name="mesa">
                            <option value="Mesa 1">Mesa 1</option>
                            <option value="Mesa 2">Mesa 2</option>
                            <option value="Mesa 3">Mesa 3</option>
                            <option value="Mesa 4">Mesa 4</option>
                            <option value="Mesa 5">Mesa 5</option>
                        </select>
                    </div>
                   
                </div>
            </div>
        </div>
        <div id="metodosPagoList"></div>

        <div class="productoCarrito" id="productoCarrito">

</div>
        <button type="submit" id="submitBtn" class="btn btn-primary w-100" >Completar</button>
        </div>

    </section>

</form>