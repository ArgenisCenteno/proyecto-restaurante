<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cúmana Grill</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.min.css') }}"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

</head>

<body>

    <header class="row">
        <div class="header-left">
        <img src="{{ public_path('iconos/logo.jpg') }}" width="100px" alt="" style="margin-left: 20px">

        </div>
        <div class="header-center text-center">
            <strong>
                <p style="margin-top: 0; margin-bottom:0; font-size:0.7rem;">REPÚBLICA BOLÍVARIANA DE VENEZUELA</p>
                <p style="margin-top: 0; margin-bottom:0; font-size:0.7rem;">ESTADO MONAGAS</p>
                <p style="margin-top: 0; margin-bottom:0; font-size:0.7rem;">ALCALDÍA BOLÍVARIANA DEL MUNICIPIO MATURÍN
                </p>
            </strong>
        </div>
        <div class="header-right " >
            <h3>Cúmana Grill</h3>
        </div>
    </header>

    <div class="fondo-titulo text-center container-fluid ">
        <h1><strong>COMPROBANTE DE VENTA</strong></h1>
    </div>

    <div style="clear: both;"></div>

    <div class="container content-doc mt-2">
        <div class="col-6 d-inline-flex">
            <p class="mb-0 mt-1 " style="font-size: 12px;"><strong>NOMBRE O RAZÓN SOCIAL</strong></p>
            <p class="razon-social mb-0 p-1 pl-3 " style="font-size: 12px; padding-left: 10px;">
                {{ strtoupper($userArray['name']) }}
            </p>
        </div>

       


        <div class="col-6 d-inline-flex mt-0">
            <p style="font-size: 12px;" class="mb-1 mt-0"><strong>CÉDULA:</strong> {{   $userArray['dni'] }}
            </p>
        </div>

        <div class="col-4 d-inline-flex">
            <p style="font-size: 12px;" class="mb-0"><strong>FECHA DE VENTA:</strong> </p>
            <p style="font-size: 12px;" >{{ $venta->created_at }}</p>
        </div>

      

      

        <div class="col-6 d-inline-flex">
            <p style="font-size: 12px;" class="mb-0"><strong>DIRECCIÓN:</strong></p>
            <p style="font-size: 12px;"> {{ $userArray['sector'] ?? 'Sector no disponible' }},
                                {{ $userArray['calle'] ?? 'Calle no disponible' }},
                                {{ $userArray['casa'] ?? 'Casa no disponible' }} </p>
        </div>
 


        <div class="col-6 d-inline-flex mb-0 mt-0 ">
            <p style="font-size: 12px;" class="mt-0 razon-social p-1 pl-3">VENTA NRO
            @php
                                $id = str_pad($venta->id, 6, "0", STR_PAD_LEFT);
                            @endphp
                @if ($id)
                    <strong>{{ $id }}</strong>

                @endif
            </p>



        </div>

        <div class="col-4 d-inline-flex">
            <p style="font-size: 12px;" class="mb-0"></p>
            <p style="font-size: 12px;">

            </p>
        </div>
    </div>

    <div class="container">
        <table class="table" style="font-size: 12px">
            <thead>
                <tr>
                    <th class="text-center" scope="col">PRODUCTO</th>
                    <th class="text-center" scope="col">PRECIO</th>
                    <th class="text-center" scope="col">Cantidad</th>
                    <th class="text-center" scope="col">NETO</th>
                    <th class="text-center" scope="col">IMPUESTOS</th>
                    <th class="text-center" scope="col">SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->detalleVentas as $detalle)
                    <tr class="border text-center">
                        <td class="m-0 p-0 align-center">
                            <p class="mb-0">{{ $detalle->producto->nombre ?? 'Producto no disponible' }}</p>
                            <!-- Asegúrate de que 'nombre' es el campo correcto -->
                        </td>

                        <td class="m-0 p-0 align-center">
                            <p class="mb-0">{{ number_format($detalle->precio_producto, 2) }} </p>
                        </td>

                        <td class="m-0 p-0 align-center">
                            <p class="mb-0">{{ number_format($detalle->cantidad, 2) }} </p>
                        </td>

                        <td class="m-0 p-0 align-center">
                            <p class="mb-0">{{ number_format($detalle->neto, 2) }}</p>
                        </td>

                        <td class="m-0 p-0 align-center">
                            <p class="mb-0">{{ number_format($detalle->impuesto, 2) }}</p>
                        </td>

                        <td class="m-0 p-0 align-center">
                            <p class="mb-0">{{ number_format($detalle->neto + $detalle->impuesto, 2) }}</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="container content-firma" style="margin-top: 9rem; position: relative;">
        <div class="firma-center">
            <div style="border-top: 2px solid black;"></div>
            <p><strong>EMPLEADO</strong></p>
            <p style="margin: 0; font-size: 0.9rem;">{{$vendedorArray['name']}}</p>
        </div>
        
    </div>
    {{-- <div style="clear: both;"></div> --}}

    
    {{-- SALTO DE PAGINA --}}
    

</body>

</html>