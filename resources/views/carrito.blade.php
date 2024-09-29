@extends('layouts.app')

@section('content')

<section class="h-100 py-5">
    <div class="container-fluid">
        <div class="row d-flex justify-content-between">
            <div class="col-lg-9 mb-4">

                <div class="d-flex justify-content-between align-items-center mb-4 ">
                    <h3 class="fw-normal mb-0">Carrito de Compras</h3>
                </div>

                @if (session('cart') && count(session('cart')) > 0)
                    @foreach (session('cart') as $key => $item)
                        <div class="card rounded-3 mb-4">
                            <div class="card-body p-4">
                                <div class="row d-flex justify-content-between align-items-center">
                                    <div class="col-md-2 col-lg-2 col-xl-2">
                                        <img src="{{ $item['imagen'] }}" class="img-fluid rounded-3" alt="{{ $item['nombre'] }}">
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-xl-3">
                                        <p class="lead fw-normal mb-2">{{ $item['nombre'] }}</p>
                                    </div>
                                    <div class="col-md-2 col-lg-2 col-xl-2 d-flex">
                                        <button id="reset" type="button" class="btn btn-danger px-2"
                                            onclick="changeQuantity({{ $key }}, -1, '{{ addslashes($item['nombre']) }}', {{ $item['precio'] }});">
                                            -
                                        </button>

                                        <input id="quantity-{{ $key }}" min="1" name="quantity" value="{{ $item['cantidad'] }}"
                                            type="number" class="form-control form-control-sm mx-2" readonly />

                                        <button id="add" type="button" class="btn btn-primary px-2"
                                            onclick="changeQuantity({{ $key }}, 1, '{{ addslashes($item['nombre']) }}', {{ $item['precio'] }});">
                                            +
                                        </button>
                                    </div>
                                    <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                        <h5 class="mb-0">{{ number_format($item['precio'], 2) }} <small>Bs</small></h5>
                                    </div>
                                    <div class="col-md-2 col-lg-2 col-xl-2 text-end">
                                        @php
                                            $subtotal = $item['cantidad'] * $item['precio'];
                                        @endphp
                                        <h5 id="subtotal-{{ $key }}" class="mb-0">Subtotal: {{ number_format($subtotal, 2) }} <small>Bs</small></h5>
                                    </div>
                                    <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                        <a href="#!" class="text-danger"><i class="fas fa-trash fa-lg"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Tú carrito esta vacío.</p>
                @endif

            </div>

            <div class="col-lg-3">
                <div class="card mb-4">
                    <div class="card-header py-3 bg-primary text-white">
                        <h5 class="mb-0 ">Resumen</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                Productos
                                @if (session('cart') && count(session('cart')) > 0)
                                <span>{{count(session('cart'))}}</span>
                                @endif
                               
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                Envío
                                <span>Gratis</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                <div>
                                    <strong>Monto total</strong>
                                    <p class="mb-0">(Incluye IVA)</p>
                                </div>
                                <span><strong>{{$total}}</strong></span>
                            </li>
                        </ul>
                        <a href="{{route('pagar')}}" class="btn btn-primary btn-lg btn-block">
                            Ir a pagar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@include('layout.script')
<script src="{{asset('js/sweetalert2.js')}}"></script>
<script>

    function updateSubtotal(index, price) {

        // Obtener cantidad
        var quantity = document.getElementById('quantity-' + index).value;

        // Calcular el nuevo subtotal
        var subtotal = quantity * price;
        // changeQuantity(index, quantity, product, price)
        // Actualizar la visualización del subtotal
        document.getElementById('subtotal-' + index).innerText = 'Subtotal: ' + subtotal.toFixed(2) + ' Bs';

    }

    function changeQuantity(index, change, product, price) {
        // Obtener el input de cantidad
        var quantityInput = document.getElementById('quantity-' + index);
        //console.log(product)

        // Calcular la nueva cantidad
        var newQuantity = parseInt(quantityInput.value) + change;

        // Asegurarse de que la cantidad no sea menor a 1
        if (newQuantity < 1) {
            newQuantity = 1;
        }

        // Actualizar el valor del input
        quantityInput.value = newQuantity;

        // Llamar a la función para actualizar el subtotal
        updateSubtotal(index, price);

        // Hacer la solicitud AJAX para actualizar la cantidad en la sesión
        fetch('{{ route("carrito.actualizar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product: product,
                cantidad: newQuantity
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log(data.message);
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>