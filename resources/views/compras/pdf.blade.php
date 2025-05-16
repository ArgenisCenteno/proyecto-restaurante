<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> ORTIMED</title>

    <link rel="stylesheet" href="{{ public_path('css/bootstrap.min.css') }}"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <style>

    </style>
</head>

<body
    style="font-family: Arial, sans-serif; margin: 0; padding: 10px; line-height: 1.6; border: none; background-color: #f9f9f9;">
    <div
        style="max-width: 800px; margin: auto; padding: 10px; border-radius: 8px; background: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <!-- Encabezado -->
        <div
            style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 10px; border-bottom: 2px solid #ddd;">
            <div style="width: 20%; flex: 1;">
            </div>
            <div style="text-align: center; flex: 1;">

                <h1 style="margin: 0;  color: #333;"></h1>
            </div>

        </div>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th
                        style="border-bottom: 2px solid #ddd; padding: 8px; text-align: center; font-size: 18px; width: 15%;">
                        <img src="{{ public_path('iconos/logo.jpg') }}" alt="Logo"
                            style="max-width: 100px; height: auto;">
                    </th>
                    <th colspan="2"
                        style="border-bottom: 2px solid #ddd; padding: 8px; text-align: center; font-size: 22px; font-weight: bold; width: 70%;">
                       ORTIMED C.A
                    </th>
                    @php
                        $id = str_pad($compra->id, 8, "0", STR_PAD_LEFT);
                    @endphp
                    <th
                        style="border-bottom: 2px solid #ddd; padding: 8px; text-align: center; font-size: 22px; width: 15%;">
                        {{$id}}
                    </th>
                </tr>
            </thead>
        </table>


        <!-- Título -->
        <h3 style="text-align: center; color: #333; font-size: 24px; margin: 20px 0;">COMPROBANTE DE COMPRA</h3>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="padding: 8px; text-align: left;">DIRECCIÓN</th>
                    <th style="padding: 8px; text-align: left;">CIUDAD.</th>
                    <th style="padding: 8px; text-align: left;">FECHA DE COMPRA.</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">CALLE EZEQUIEL ZAMORA, FRENTE AL CENTRO CLINICO PUNTA DE MATA</td>
                        PUNTA DE MATA</td>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">PUNTA DE MATA</td>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{$fechacompra}}</td>
                </tr>
            </tbody>
        </table>
        <!-- Detalles del cliente y vendedor -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="padding: 8px; text-align: left;">PROVEEDOR</th>
                    <th style="padding: 8px; text-align: left;">VENDEDOR.</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{$compra->proveedor->razon_social}}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{$vendedorArray['name']}}</td>


                </tr>
            </tbody>
        </table>


        <!-- Tabla de productos -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="padding: 8px; text-align: left;">PRODUCTO</th>
                    <th style="padding: 8px; text-align: left;">CANT.</th>
                    <th style="padding: 8px; text-align: left;">PRECIO UNIT.</th>
                    <th style="padding: 8px; text-align: left;">IVA</th>
                    <th style="padding: 8px; text-align: left;">NETO</th>
                    <th style="padding: 8px; text-align: left;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($compra->detalleCompras as $detalle)
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{$detalle->producto->nombre}}</td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{$detalle->cantidad}}</td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{$detalle->precio_producto}}</td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{$detalle->impuesto}}</td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{$detalle->neto}}</td>
                        <td style="padding: 8px; border-bottom: 1px solid #ddd;">
                            {{number_format($detalle->impuesto + $detalle->neto, 2)}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Resumen de totales -->
        <div style="display: flex; justify-content: space-between; margin-top: 20px; align-items: flex-start;">
            <!-- Contenedor del QR -->

            @if($compra->tipo == 'Regular')
            <!-- Contenedor de los montos -->
            <div
                style="text-align: right; padding: 10px; border: 2px solid #ddd; border-radius: 8px; background-color: #f9f9f9; flex-grow: 1;">
                <div style="text-align: left; margin-right: 20px;">
                </div>
                <p style="margin: 0; padding: 5px; border-bottom: 1px solid #ddd;"><strong>SUBTOTAL:</strong>
                    {{$compra->pago->monto_neto}}</p>
                <p style="margin: 0; padding: 5px; border-bottom: 1px solid #ddd;"><strong>IVA (16%):</strong>
                    {{$compra->pago->impuestos}}</p>
                <p style="margin: 0; padding: 5px;"><strong>MONTO TOTAL:</strong> {{$compra->pago->monto_total}}</p>
            </div>
            @else
            <div  
                style="text-align: right; padding: 10px; border: 2px solid #ddd; border-radius: 8px; background-color: #f9f9f9; flex-grow: 1;">
                <div style="text-align: left; margin-right: 20px;">
                </div>
                <p style="margin: 0; padding: 5px; border-bottom: 1px solid #ddd;"><strong>SUBTOTAL:</strong>
                    {{$subtotal}}</p>
                <p style="margin: 0; padding: 5px; border-bottom: 1px solid #ddd;"><strong>IVA (16%):</strong>
                    {{$impuestos}}</p>
                <p style="margin: 0; padding: 5px;"><strong>MONTO TOTAL:</strong> {{$subtotal + $impuestos}}</p>
            </div>
            @endif
        </div>



    </div>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; margin-top: 60px">
   
    <tbody>
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #ddd;"></td>
            <td style="padding: 8px; text-align: center;">__________________________________</td>
            <td style="padding: 8px; text-align: center;">__________________________________</td>
            <td style="padding: 8px; border-bottom: 1px solid #ddd;"></td>
        </tr>
        <tr>
            <td style="padding: 8px; text-align: left;"></td>
            <td style="padding: 8px; text-align: center;">Firma del Proveedor</td>
            <td style="padding: 8px; text-align: center;">Firma del Vendedor</td>
            <td style="padding: 8px; text-align: left;"></td>
        </tr>
    </tbody>
</table>


</body>

</html>