<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suptrima</title>
    <link rel="stylesheet" href="{{public_path('css/bootstrap.min.css')}}"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="{{public_path('css/pdf.css')}}"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body class="Solvencia">

    <div class="SolvenciaTabla">

        <header class="container-fluid my-0 border-2 round-top">
            <table class="table table-borderless p-0 m-0">
                <thead>
                    <tr class="m-0 ">
                        <td class="py-1 align-middle m-0 text-center">
                            <h4 class="bolt"> Farmagarca</h4>
                        </td>
                        <td class="py-1 text-center encabezado">
                            <p class="mb-0 bold" style="font-size: 0.6em">REPÚBLICA BOLIVARIANA DE VENEZUELA</p>
                            <p class="mb-0 bold" style="font-size: 0.6em">MUNICIPIO EZEQUIEL ZAMORA,
                                ESTADO MONAGAS</p>
                            <p class="mb-0 bold" style="font-size: 0.6em">PUNTA DE MATA
                            </p>

                        </td>
                        <td class="py-1 align-middle">
                            <img class=" m-0 aaaa" width="40px" src="{{public_path('iconos/solicitud.png')}}"
                                alt="logo">

                        </td>

                    </tr>

                </thead>
            </table>
        </header>


        <div class="border-dark container-fluid border-left round border-right border-top border-bottom  border-1 my-0">
            <div class="my-1 py-1 border-2 primeratabla">
                <h6 class="mb-0 text-center bold text-white">Comprobante de Compra</h6>
            </div>
            <table class="table table-borderless p-0 m-0">
                <tbody>
                    <tr class="">
                        <td class="text-start">
                            @php
                                $id = str_pad($compra->id, 6, "0", STR_PAD_LEFT);
                            @endphp
                            <p class="m-0"> <strong>Compra N°: {{$id}}</strong></p>
                        </td>
                        <td class="text-start">
                            <p class="m-0"> <strong>Tipo: {{$compra->pago->tipo}}</strong>
                            </p>
                        </td>
                        <td class="text-end">
                            <p class="m-0"> <strong>Fecha:</strong> {{$fechacompra}} </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div><br>


        <div
            class="container-fluid round border-dark my-0 py-1 border-bottom border-left border-right border-primary border-top border-1">
            <div class="my-2 py-1 border-2 primeratabla">
                <h6 class="mb-0 text-center bold">Datos del Proveedor</h6>
            </div>

            <table class="table table-borderless my-0">
                <tbody>
                    <tr>
                        <td style="width: 50%">
                            <p class="mb-0"><strong>C.I / R.I.F:</strong> {{$compra->proveedor->rif}}</p>
                            <p class="mb-0"><strong>NOMBRE/RAZÓN SOCIAL:</strong> {{$compra->proveedor->razon_social}}</p>
                        </td>
                        <td>
                            <p class="mb-0"><strong>DIRECCIÓN:</strong>
                                {{$compra->proveedor->area ?? 'Área no disponible' }},
                                {{ $compra->proveedor->municipio ?? 'Municipio no disponible' }},
                                {{ $compra->proveedor->estado ?? 'Estado no disponible' }},
                                {{ $compra->proveedor->parroquia ?? 'Parroquia no disponible' }}
                            </p>
                            <p class="mb-0"><strong>CORREO ELECTRÓNICO:</strong>
                                {{ $compra->proveedor->email ?? 'Correo no disponible' }}
                            </p>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div><br>



        <div
            class="container-fluid round-top border-dark my-0 py-1  border-left border-right border-primary border-top border-1">
            <div class="my-2 py-1 border-2 primeratabla">
                <h6 class="mb-1 text-center bold">Productos Adquiridos</h6>
            </div>

            {{-- <p class="mb-0 p-small text-start bold">Pago por concepto de:

            </p>




            <p class="mb-0 p-small text-start bold">Observaciones:

            </p>

            --}}


        </div>

        <div
            class="container-fluid round-bottom border-dark my-0 py-1  border-left border-right border-primary border-bottom border-1">
            <table class="table table-bordered text-center my-1">
                <tbody>
                    <tr class="border" style="font-size:0.7em">
                        <th class="align-middle">Producto</th>
                        <th class="align-middle">Precio</th>
                        <th class="align-middle">Cantidad</th>
                        <th class="align-middle">Neto</th>
                        <th class="align-middle">Impuesto</th>
                        <th class="align-middle">Subtotal</th>
                    </tr>

                    @foreach ($compra->detalleCompras as $detalle)
                        <tr class="border">
                            <td class="m-0 p-0 align-middle">
                                <p class="mb-0">{{ $detalle->producto->nombre ?? 'Producto no disponible' }}</p>
                                <!-- Asegúrate de que 'nombre' es el campo correcto -->
                            </td>

                            <td class="m-0 p-0 align-middle">
                                <p class="mb-0">{{ number_format($detalle->precio_producto, 2) }} </p>
                            </td>

                            <td class="m-0 p-0 align-middle">
                                <p class="mb-0">{{ number_format($detalle->cantidad, 2) }} </p>
                            </td>

                            <td class="m-0 p-0 align-middle">
                                <p class="mb-0">{{ number_format($detalle->neto, 2) }}</p>
                            </td>

                            <td class="m-0 p-0 align-middle">
                                <p class="mb-0">{{ number_format($detalle->impuesto, 2) }}</p>
                            </td>

                            <td class="m-0 p-0 align-middle">
                                <p class="mb-0">{{ number_format($detalle->neto + $detalle->impuesto, 2) }}</p>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div><br>



        <div
            class="container-fluid round border-dark my-0 py-1 border-bottom border-left border-right border-primary border-top border-1">
            <div class="my-1 py-1 border-2 primeratabla">
                <h6 class="mb-0 text-center bold">Forma de Pago</h6>
            </div>



            <table class="table table-bordered text-center my-1">
                <thead>
                    <tr class="border" style="font-size:0.7em">
                        <th class="align-middle text-center">Forma de Pago</th>
                        <th class="align-middle text-center">Banco de Destino</th>
                        <th class="align-middle text-center">Referencia</th>
                        <th class="align-middle text-center">Moneda</th>
                        <th class="align-middle text-center">Monto Total</th>
                        <th class="align-middle text-center">Total Pagado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formaPagoArray as $pago)
                        <tr class="border">
                            <td class="m-0 p-0 align-middle text-center">
                                <p class="mb-0">{{ $pago['metodo'] }}</p>
                            </td>
                            <td class="m-0 p-0 align-middle text-center">
                                <p class="mb-0">{{ $pago['banco_destino'] }}</p>
                            </td>
                            <td class="m-0 p-0 align-middle text-center">
                                <p class="mb-0">{{ $pago['numero_referencia'] }}</p>
                            </td>
                            <td class="m-0 p-0 align-middle text-center">
                                <p class="mb-1">{{ $pago['metodo'] === 'Divisa' ? 'Dólar' : 'Bolívar' }}</p>
                            </td>
                            <td class="m-0 p-0 align-middle text-center">
                                <p class="mb-1">
                                    {{ $pago['metodo'] === 'Divisa' ? number_format($pago['monto_dollar'], 2) : number_format($pago['monto_bs'], 2) }}
                                </p>
                            </td>
                            <td class="m-0 p-0 align-middle text-center">
                                <p class="mb-1">{{ number_format($pago['cantidad'], 2) }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>



        </div>
        <table class="table table-borderless text-center my-2">
            <tbody class="p-0 mt-5">
                <tr class="">
                    <th>

                    </th>
                    <th class="">
                        <!-- <p class="m-0 p-0 mt-4 border-top">Sello</p> -->
                    </th>
                    <th class="" style="width: 200px;">




                        <p class="m-0 p-0 mt-4 border-2 border-top">Vendedor</p>

                        <p class="m-0 p-0 mt-4 ">{{$vendedorArray['name']}}</p>


                    </th>

                </tr>

            </tbody>
        </table>


        <div class="title m-b-md">


        </div>




        {{-- <footer class="bg-success">
            <p class="text-centser">
                <?php echo date("d-m-y"); ?>
            </p>
        </footer> --}}
        <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(500, 810, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
        </script>
    </div>
</body>

</html>