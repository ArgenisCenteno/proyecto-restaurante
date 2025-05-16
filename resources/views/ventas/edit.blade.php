@extends('layout.app')
@section('content')
    <main class="app-main"> <!--begin::App Content Header-->
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card border-0 my-5">
                            <div class="px-2 row">
                                <div class="col-lg-12">
                                    @include('flash::message')
                                </div>
                                <div class="col-md-12 col-2">
                                    <h3 class="p-2 bold text-center">Editar Venta</h3>
                                </div>

                            </div>
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-12">


                                        <div class="row mb-3">
                                            <div class="col-md-4 mb-3">
                                                <label>Cliente</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $venta->user->name ?? 'N/A' }}" readonly>
                                              
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Vendedor</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $venta->vendedor->name ?? 'N/A' }}" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Estado</label>
                                                <input type="text" class="form-control" value="{{ $venta->status }}"
                                                    readonly>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4 mb-3">
                                                <label>Monto Total</label>
                                                <input type="text" class="form-control"
                                                    value="{{ number_format($venta->monto_total, 2) }}" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Mesa</label>
                                                <input type="text" class="form-control" value="{{ $venta->mesa ?? 'N/A' }}"
                                                    readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label>Tipo</label>
                                                <input type="text" class="form-control" value="{{ $venta->tipo ?? 'N/A' }}"
                                                    readonly>
                                            </div>
                                        </div>


                                        <h4>Productos de la venta</h4>
                                        <form action="{{ route('ventas.update', $venta->id) }}" method="POST">
                                              <input type="hidden" name="dollar" id="dollar" value="{{ $dollar }}">
                                            @csrf
                                            @method('PUT')
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Producto</th>
                                                        <th>Precio Unitario</th>
                                                        <th>Cantidad</th>
                                                        <th>Neto</th>
                                                        <th>Impuesto</th>
                                                        <th>Subtotal</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($venta->detalleVentas as $detalle)
                                                        <tr id="detalle-{{ $detalle->producto->id ?? $detalle->id }}">
                                                            <td>{{ $detalle->producto->nombre ?? 'Producto eliminado' }}</td>
                                                            <td>{{ number_format($detalle->precio_producto, 2) }}</td>
                                                            <td>
                                                                <input type="number" name="cantidades[{{ $detalle->id }}]"
                                                                    class="form-control" min="1"
                                                                    value="{{ $detalle->cantidad }}">
                                                            </td>
                                                             <td>
                                                                <input type="number" step="any" name="netos[{{ $detalle->id }}]"
                                                                    class="form-control" min="1"
                                                                    value="{{ $detalle->neto }}">
                                                            </td>
                                                            <td>{{ number_format($detalle->impuesto, 2) }}</td>
                                                            <td>{{ number_format($detalle->neto + $detalle->impuesto, 2) }}</td>
                                                            <td>
                                                                <!-- Botón de eliminación en otro formulario -->
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    onclick="eliminarProducto({{ $detalle->id }})">Eliminar</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <button type="button" class="btn btn-success mb-3"
                                                onclick="$('#modalAgregarProducto').modal('show')">
                                                Agregar Producto
                                            </button>

                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                            </div>
                                        </form>

                                        <!-- Formulario oculto para eliminar -->
                                        <form id="formEliminarProducto" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main> <!--end::App Main--> <!--begin::Footer-->

    <div class="modal fade" id="modalAgregarProducto" tabindex="-1" role="dialog"
        aria-labelledby="modalAgregarProductoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarProductoLabel">Seleccionar Productos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="productos-table2" style="width:100%">
                            <thead class="bg-light">
                                <tr>
                                    
                                    <th>Nombre</th>
                                    <th>Costo</th>
                                    <th>IVA</th>
                                    <th>Existencia</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    @include('layout.script')
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <script src="{{asset('js/sweetalert2.js')}}"></script>
    <script>
        function eliminarProducto(id) {
            if (confirm('¿Seguro que deseas eliminar este producto?')) {
                const form = document.getElementById('formEliminarProducto');
                form.action = "{{ url('detallesVenta') }}/" + id;
                form.submit();
            }
        }
    </script>
    <script>
        $(document).ready(function () {
            var table = $('#productos-table2').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('ventas.datatableProductoVenta') }}",
                    type: "GET",
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                },
                columns: [
                     
                    { data: 'nombre', name: 'nombre' },
                    { data: 'precio_venta', name: 'precio_venta' },
                    {
                        data: 'aplica_iva',
                        name: 'aplica_iva',
                        render: function (data) {
                            return data ? 'Sí' : 'No';
                        }
                    },
                    { data: 'cantidad', name: 'cantidad' },
                    {
                        data: 'id',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, full) {
                            return `<button type="button" class="btn btn-primary addToCartBtn" data-product='${JSON.stringify(full)}'>
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>`;
                        }
                    }
                ],
                order: [[1, 'asc']],
                language: {
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    zeroRecords: "Sin resultados",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    infoEmpty: "No hay registros disponibles",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    search: "Buscar:",
                    paginate: {
                        next: ">",
                        previous: "<"
                    }
                }
            });

            // Evento para agregar producto al formulario de venta
            $('#productos-table2 tbody').on('click', '.addToCartBtn', function () {
                let producto = $(this).data('product');
                let dollar = $('#dollar').val();
                // Chequear si ya existe ese producto (puedes usar el id en un data-atributo para evitar duplicados)
                if ($(`#detalle-${producto.id}`).length) {
                    Swal.fire('¡Producto ya agregado!', '', 'warning');
                    return;
                }

                if (producto.cantidad <= 0) {
                    Swal.fire('¡No hay suficiente stock!', '', 'warning');
                    return;
                }

                let neto = parseFloat(producto.precio_venta) * dollar;
                let impuesto = producto.aplica_iva ? neto * 0.16 : 0;
                let subtotal = neto + impuesto;

                // Crear fila nueva con inputs para enviar en el form
                let fila = `
                   <tr id="detalle-${producto.id}" class="bg-secondary">
        <td>${producto.nombre}</td>
        <td>${neto.toFixed(2)}</td>
        <td>
            <input type="number" name="nuevos_productos[${producto.id}][cantidad]" class="form-control" value="1" min="1" onchange="actualizarFila(${producto.id})" />
            <input type="hidden" name="nuevos_productos[${producto.id}][producto_id]" value="${producto.id}" />
                  <input type="hidden" name="nuevos_productos[${producto.id}][neto]" value="${neto.toFixed(2)}" />

            </td>
        <td id="neto-${producto.id}">${neto.toFixed(2)}</td>
        <td id="impuesto-${producto.id}">${impuesto.toFixed(2)}</td>
        <td id="subtotal-${producto.id}">${subtotal.toFixed(2)}</td>
        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(${producto.id})">Eliminar</button>
        </td>
    </tr>

                `;

                $('form table tbody').append(fila);
                $('#modalAgregarProducto').modal('hide');
            });
        });

        // Función para actualizar neto, impuesto y subtotal si cambia la cantidad
        function actualizarFila(id) {
            let cantidad = parseInt($(`input[name="nuevos_productos[${id}][cantidad]"]`).val());
            if (cantidad < 1) cantidad = 1;

            let netoUnitario = parseFloat($(`#neto-${id}`).text());
            // Para recalcular neto y subtotal correcto, obtén el precio unitario:
            let netoUnitarioReal = parseFloat($(`#detalle-${id} td:nth-child(2)`).text());

            let neto = netoUnitarioReal * cantidad;
            let aplicaIva = parseFloat($(`#impuesto-${id}`).text()) > 0; // si tiene impuesto
            let impuesto = aplicaIva ? neto * 0.16 : 0;
            let subtotal = neto + impuesto;

            $(`#neto-${id}`).text(neto.toFixed(2));
            $(`#impuesto-${id}`).text(impuesto.toFixed(2));
            $(`#subtotal-${id}`).text(subtotal.toFixed(2));
        }

        // Eliminar fila agregada
        function eliminarFila(id) {
            $(`#detalle-${id}`).remove();
        }

    </script>
@endsection