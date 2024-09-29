<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cúmana Grill</title>
    <link rel="stylesheet" href="{{public_path('css/bootstrap.min.css')}}" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="{{public_path('css/pdf.css')}}" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body class="Solvencia">

    <div class="container-fluid">
        <!-- Encabezado de la Factura -->
        <div class="border-dark border my-3">
            <h6 class="text-center text-white bg-dark p-2">Comprobante de Venta</h6>
            <table class="table table-borderless">
                <tr>
                    <td><strong>Venta:</strong> {{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td><strong>Tipo:</strong> {{ $venta->pago->tipo }}</td>
                    <td><strong>Forma de Pago</strong> {{ $venta->pago->forma_pago }}</td>
                    <td class="text-end"><strong>Fecha:</strong> {{ $fechaVenta }}</td>
                </tr>
            </table>
        </div>

        <!-- Datos del Cliente -->
        <div class="border-dark border my-3">
            <h6 class="text-center text-white bg-dark p-2">Datos del Cliente</h6>
            <table class="table table-borderless">
                <tr>
                    <td><strong>C.I / R.I.F:</strong> {{ $userArray['dni'] }}</td>
                    <td><strong>NOMBRE/RAZÓN SOCIAL:</strong> {{ $userArray['name'] }}</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>DIRECCIÓN:</strong> {{ $userArray['sector'] ?? 'Sector no disponible' }}, {{ $userArray['calle'] ?? 'Calle no disponible' }}, {{ $userArray['casa'] ?? 'Casa no disponible' }}</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>CORREO ELECTRÓNICO:</strong> {{ $userArray['email'] ?? 'Correo no disponible' }}</td>
                </tr>
            </table>
        </div>

        <!-- Productos Adquiridos -->
        <div class="border-dark border my-3">
            <h6 class="text-center text-white bg-dark p-2">Productos </h6>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Neto</th>
                        <th>Impuesto</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($venta->detalleVentas as $detalle)
                        <tr>
                            <td>{{ $detalle->producto->nombre ?? 'Producto no disponible' }}</td>
                            <td>{{ number_format($detalle->precio_producto, 2) }}</td>
                            <td>{{ number_format($detalle->cantidad, 2) }}</td>
                            <td>{{ number_format($detalle->neto, 2) }}</td>
                            <td>{{ number_format($detalle->impuesto, 2) }}</td>
                            <td>{{ number_format($detalle->neto + $detalle->impuesto, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Vendedor -->
        <div class="text-center my-3">
            <p>GRACIAS POR SU COMPRA</p>
        </div>

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
