<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cumana Grill</title>

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
                        CUMANA GRILL C.A
                    </th>
                    @php
                        $id = str_pad($apertura->id, 8, "0", STR_PAD_LEFT);
                    @endphp
                    <th
                        style="border-bottom: 2px solid #ddd; padding: 8px; text-align: center; font-size: 22px; width: 15%;">
                        {{$id}}
                    </th>
                </tr>
            </thead>
        </table>


        <!-- Título -->
        <h3 style="text-align: center; color: #333; font-size: 24px; margin: 20px 0;">RESUMEN DE CAJA</h3>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="padding: 8px; text-align: left;">DIRECCIÓN</th>
                    <th style="padding: 8px; text-align: left;">CIUDAD.</th>
                    <th style="padding: 8px; text-align: left;">FECHA DE VENTA.</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">CALLE AYACUCHO FRENTE AL CEMENTERIO DE
                        PUNTA DE MATA</td>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">MONAGAS</td>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{$apertura->created_at}}</td>
                </tr>
            </tbody>
        </table>


        <div class="row">
            <div class="col-md-12 mb-4">
                <h4>Movimientos</h4>
                <div class="table-responsive">
                    <table id="movimientos-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>

                                <th>Usuario</th>

                                <th>Tipo</th>
                                <th>Monto en Bolívares</th>
                                <th>Monto en Dólares</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($movimientos as $movimiento)
                                <tr>
                                    <td>{{ $movimiento->id }}</td>
                                    <td>{{ strtoupper($movimiento->usuario->name) }}</td>
                                    <td>{{ strtoupper($movimiento->tipo) }}</td>
                                    <td>{{ number_format($movimiento->monto_bolivares, 2) }}</td>
                                    <td>{{ number_format($movimiento->monto_dolares, 2) }}</td>
                                    <td>{{ strtoupper($movimiento->descripcion) }}</td>
                                    <td>{{ $movimiento->fecha }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

            <!-- Tabla de Transacciones -->
            <div class="col-md-12 mb-4">
                <h4>Transacciones</h4>
                <div class="table-responsive">
                    <table id="transacciones-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>

                                <th>Usuario</th>

                                <th>Tipo</th>
                                <th>Monto Total en Bolívares</th>
                                <th>Monto Total en Dólares</th>
                                <th>Método de Pago</th>
                                <th>Moneda</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($transacciones as $transaccion)
                                <tr>
                                    <td>{{ $transaccion->id }}</td>
                                    <td>{{strtoupper($transaccion->usuario->name)}}</td>
                                    <td>{{strtoupper($transaccion->tipo)}}</td>
                                    <td>{{ number_format($transaccion->monto_total_bolivares, 2) }}</td>
                                    <td>{{ number_format($transaccion->monto_total_dolares, 2) }}</td>
                                    <td>{{strtoupper($transaccion->metodo_pago)}}</td>
                                    <td> {{strtoupper($transaccion->moneda)}} </td>
                                    <td>{{ $transaccion->fecha }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Resumen de Totales -->
            <div class="col-md-6 mb-3">
                <h5>Totales de Transacciones</h5>
                <div class="form-group">
                    <label>Total Monto en Bolívares:</label>
                    <input type="text" class="form-control"
                        value="{{ number_format($transacciones->sum('monto_total_bolivares'), 2) }}" readonly>
                </div>
                <div class="form-group">
                    <label>Total Monto en Dólares:</label>
                    <input type="text" class="form-control"
                        value="{{ number_format($transacciones->sum('monto_total_dolares'), 2) }}" readonly>
                </div>
            </div>

            <!-- Totales por Método de Pago -->
            <div class="col-md-6 mb-3">
                <h5>Totales por Método de Pago (Transacciones)</h5>
                @foreach($transacciones->groupBy('metodo_pago') as $metodo => $transaccionesPorMetodo)
                    <div class="form-group">
                        <label>Total en {{ $metodo }}:</label>
                        <input type="text" class="form-control"
                            value="{{ number_format($transaccionesPorMetodo->sum('monto_total_bolivares'), 2) }}" readonly>
                    </div>
                @endforeach
            </div>
        </div>


    </div>




</body>

</html>