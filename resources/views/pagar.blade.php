@extends('layout.app')

@section('content')

<section class="h-100 py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="fw-normal mb-0">Pago de Orden</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('pagarCuenta')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="metodo" class="form-label">Metodo de Pago</label>
                                <select class="form-select" id="metodo" name="metodo" required>
                                    <option value="" disabled selected>Seleccione un metodo de pago</option>
                                    <option value="Pago movil">Pago móvil</option>
                                    <option value="Transferencia">Transferencia</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="banco_origen" class="form-label">Banco de Origen</label>
                                <select class="form-select" id="banco_origen" name="banco_origen" required>
                                    <option value="" disabled selected>Selecciona tu banco de origen</option>
                                    <option value="Banesco">Banesco</option>
                                    <option value="Banco de Venezuela">Banco de Venezuela</option>
                                    <option value="Mercantil">Mercantil</option>
                                    <option value="BBVA Provincial">BBVA Provincial</option>
                                    <option value="Bicentenario">Bicentenario</option>
                                    <option value="Banco Exterior">Banco Exterior</option>
                                    <option value="Banco del Tesoro">Banco del Tesoro</option>
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="banco_destino" class="form-label">Banco de Destino</label>
                                <select class="form-select" id="banco_destino" name="banco_destino" required>
                                    <option value="" disabled selected>Selecciona tu banco de destino</option>
                                    <option value="Banesco">Banesco</option>
                                    <option value="Banco de Venezuela">Banco de Venezuela</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="numero_referencia" class="form-label">Número de Referencia</label>
                                <input type="text" class="form-control" id="numero_referencia" name="numero_referencia" maxlength="8" placeholder="12345678" pattern="\d{8}" title="Debe tener 8 dígitos" required>
                            </div>

                            <div class="mb-3">
                                <label for="comprobante" class="form-label">Comprobante de Pago</label>
                                <input type="file" class="form-control" id="comprobante" name="comprobante" required>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <p class="fw-bold mb-0">Total:</p>
                                <p class="text-muted mb-0">{{$total}}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="fw-bold mb-0">Impuesto:</p>
                                <p class="text-muted mb-0">{{$impuesto}}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="fw-bold mb-0">Monto a Pagar:</p>
                                <p class="text-muted mb-0">{{$montoTotal}}</p>
                                <input type="hidden" name="montoTotal" value="{{$montoTotal}}">
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-4">Realizar Pago</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@include('layout.script')
<script src="{{asset('js/sweetalert2.js')}}"></script>
