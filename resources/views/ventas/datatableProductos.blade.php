<div class="text-center mt-4 card pt-2 pb-2 bg-dark text-white"
    style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
    <h3>Productos</h3>



</div>
<hr />
<div class="table-responsive">
    <table class="table table-hover" id="productos-table2">
        <thead class="bg-light">
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Costo</th>
                <th> IVA</th>
                <th>Existencia</th>

                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="text-center mt-4 card pt-2 pb-2 bg-warning text-black"
    style="box-shadow: rgba(133, 152, 11, 0.2) 0px 7px 29px 0px;">
    <h3>Carrito de Compras</h3>



</div>
<div class="productoCarrito" id="productoCarrito" class="mt-3">

</div>

@section('js')
@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="{{asset('js/sweetalert2.js')}}"></script>
<script type="text/javascript">

    $(document).ready(function () {
        let productosEnCarrito = [];


        $('#productos-table2').DataTable({
            processing: true,
            serverSide: true,
             pageLength: 3,
            responsive: true,
            ajax: "{{ route('ventas.datatableProductoVenta') }}",
            dataType: 'json',
            type: "POST",
            columns: [
                {
                    data: 'imagenes', // Asumiendo que 'imagenes' es un array con las imágenes del producto
                    name: 'imagenes',
                    render: function (data) {
                        // Verificamos si hay imágenes y devolvemos la primera
                        return data.length > 0 ? `<img src="${data[0].url}" alt="Imagen" style="width: 50px; height: auto;">` : 'Sin imagen'; // Cambia 'url' por el campo correcto de tu objeto de imagen
                    }
                },
                { data: 'nombre', name: 'nombre' },
                { data: 'precio_venta', name: 'precio_venta' },
                {
                    data: 'aplica_iva', name: 'aplica_iva', render: function (data) {
                        return data ? 'Sí' : 'No';
                    }
                },
                { data: 'cantidad', name: 'cantidad' },

                {
                    data: 'id',
                    name: 'actions',
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btn btn-primary addToCartBtn" data-product-id="' + data + '"><i class="fas fa-shopping-cart"></i></button>';
                    }
                }
            ],
            order: [[0, 'desc']],
            "language": {
                "lengthMenu": "Mostrar _MENU_ Registros por Página",
                "zeroRecords": "Sin resultados",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay Registros Disponibles",
                "infoFiltered": "Filtrado de _TOTAL_ de _MAX_ Registros Totales",
                "search": "Buscar",
                "paginate": {
                    "next": ">",
                    "previous": "<"
                }
            }
        });

        $(document).on('click', '.addToCartBtn', function () {
            const productId = $(this).data('product-id');
            const url = '{{ route('productos.obtener', ['id' => ':id']) }}';
            const urlWithId = url.replace(':id', productId);
            const $button = $(this);

            $.ajax({
                url: urlWithId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const producto = response.producto;

                        if (producto.cantidad == 0 || producto.cantidad < 0) {
                            Swal.fire({
                                title: 'Sin stock',
                                text: "Este producto no está disponible.",
                                icon: 'info',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33'
                            })
                            return;
                        }
                        let dolar = $("#tasa").val();
                     
                        const productName = producto.nombre;
                        const productoUrl = producto.imagenes[0].url;
                        
                        const productPrice = (producto.precio_venta * dolar).toFixed(2); // Format to 2 decimal places
const productIva = producto.aplica_iva ? 'Sí' : 'No';

let precioProductoIva;
if (productIva === 'Sí') {
    precioProductoIva = (productPrice * 1.16).toFixed(2); // Apply IVA and format
} else {
    precioProductoIva = parseFloat(productPrice).toFixed(2); // Ensure consistent format
}

                        const productDescription = producto.descripcion;
                        const productLote = producto.lote;
                        const productoStock = producto.cantidad;
                        const productSubcategoria = producto.subCategoria ? producto.subCategoria.nombre : '';

                        // Agregar el producto al array
                        productosEnCarrito.push({
                            id: productId,
                            nombre: productName,
                            precio: productPrice,
                            aplicaIva: producto.aplica_iva,
                            cantidad: 1, // Cantidad inicial,
                            productoUrl: productoUrl // Cantidad inicial
                        });
                        const productoHTML = `
<div class="productoCarrito p-2 border rounded bg-light mb-2" id="productoCarrito_${productId}">
    <div class="d-flex">
        <!-- Imagen del producto -->
        <div class="me-3">
            ${productoUrl ? `<img src="${productoUrl}" alt="Imagen del producto" style="width: 100px; height: auto;">` : '<span>Sin imagen</span>'}
        </div>

        <!-- Información del producto -->
        <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Bs ${precioProductoIva}</h5>
                <span class="aplicaIVA text-primary d-none" id="aplicaIVA_${productId}">${productIva}</span>
            </div>
            <h6 class="mt-1 nombreProducto">${productName}</h6>
            <small class="text-muted">Precio bruto: <span class="fw-bold text-success" id="precioProducto_${productId}">Bs ${productPrice}</span></small>
            
            <!-- Campo de cantidad debajo -->
            <div class="d-flex align-items-center mt-2">
                <div class="input-group me-2">
                    <span class="input-group-text">Cant:</span>
                    <input type="number" class="form-control cantidadProducto" value="1" min="1" id="cantidadProducto_${productId}">
                    <input type="hidden" class="stock" id="stock_${productId}" value="${productoStock}"/>
                </div>
                <button type="button" class="btn btn-outline-danger btn-sm removeProducto" id="removeProducto_${productId}">Eliminar</button>
            </div>
        </div>
    </div>
</div>
`;




                        // Agregar el productoHTML al contenedor #productoCarrito
                        $('#productoCarrito').append(productoHTML);
                        $button.prop('disabled', true);

                        Swal.fire({
                            title: 'Producto Agregado',
                            text: "Se agrego un producto al carrito.",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33'
                        })
                        // Calcular el total a pagar
                        calcularTotal();
                        actualizarProductosInput();
                    } else {
                        console.error('Error: No se pudo obtener el producto.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error al obtener el producto:', error);
                }
            });
        });

        $(document).on('click', '.removeProducto', function () {
            const productId = $(this).attr('id').split('_')[1];
            $('#productoCarrito_' + productId).remove();
            const $button = $(this);

            // Eliminar el producto del array
            productosEnCarrito = productosEnCarrito.filter(function (producto) {
                return producto.id != productId;
            });
            $('.addToCartBtn[data-product-id="' + productId + '"]').prop('disabled', false);
            calcularTotal();
            actualizarProductosInput();

            Swal.fire({
                title: 'Producto Descartado',
                text: "Se ha descatado un producto del carrito.",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            })
        });

        $(document).on('change', '.cantidadProducto', function () {
            const productId = $(this).attr('id').split('_')[1]; // Obtener el ID del producto
            const nuevaCantidad = parseInt($(this).val());
            const stockDisponible = parseInt($(`#stock_${productId}`).val()); // Obtener el stock disponible
            if (nuevaCantidad > stockDisponible) {
                Swal.fire({
                    title: 'Sin disponibilidad suficiente',
                    text: "No hay disponibilidad suficiente actualmente",
                    icon: 'info',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                })
                $(this).val(stockDisponible);
            }

            // Actualizar la cantidad en el array
            productosEnCarrito = productosEnCarrito.map(function (producto) {
                if (producto.id == productId) {
                    producto.cantidad = nuevaCantidad;
                }
                return producto;
            });

            // Recalcular el total
            calcularTotal();
            actualizarProductosInput();
        });
        // Función para calcular el total de la venta
        function calcularTotal() {
            let total = 0;
            let totalD = 0;
            let dolar = $('#tasa').val();
            // Iterar sobre cada producto en el carrito
            $('.productoCarrito').each(function () {
                const productId = $(this).attr('id').split('_')[1];

                if (productId != undefined) {

                    const precioProducto = parseFloat($('#precioProducto_' + productId).text().replace('Bs', ''));

                    const cantidad = parseInt($('#cantidadProducto_' + productId).val());
                    const aplicaIva = $('#aplicaIVA_' + productId).text().trim() === 'Sí';

                    let subtotalProducto = precioProducto * cantidad;

                    // Aplicar el IVA si corresponde
                    if (aplicaIva) {
                        subtotalProducto *= 1.16; // 16% de IVA
                    }

                    total += subtotalProducto;
                    totalD += subtotalProducto / dolar;
                }
            });



            // Mostrar el total calculado
            $('.totalVenta').text('Bs' + total.toFixed(2));
            $('.totalVentaBs').text('$' + totalD.toFixed(2));
        }

        function actualizarProductosInput() {
            $('#productosInput').val(JSON.stringify(productosEnCarrito));
        }
    });


    let metodosPago = [];


    calcularTotalPagos();

    const tasaCambio = parseFloat($('#tasa').val());

    $('#agregarMetodoPago').on('click', function () {
        const metodoPago = $('#metodoPago').val();
        let cantidadPagada = parseFloat($('#cantidadPagada').val());
        const bancoOrigen = $('#bancoOrigen').val();
        const bancoDestino = $('#bancoDestino').val();
        const numeroReferencia = $('#numeroReferencia').val();

        let montoBs = cantidadPagada;
        let montoDollar = cantidadPagada / tasaCambio;
        // Validar cantidad pagada
        if (isNaN(cantidadPagada) || cantidadPagada <= 0) {
            alert('Por favor, ingresa una cantidad pagada válida.');
            return;
        }

        // Convertir divisa a bolívares si el método de pago es divisa
        if (metodoPago === 'Divisa') {
            montoBs = cantidadPagada * tasaCambio;
            montoDollar = cantidadPagada;
        }

        if (metodoPago === 'A credito') {
            $('#btnSubmit').prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');

        }
        let totalVenta = parseFloat($('#totalVenta').text().replace('Bs', ''));
        let cancelado = parseFloat($('#cancelado').text().replace('Bs', ''));
let totalF = (cancelado + montoBs).toFixed(2);

       // console.log(totalF, totalF > totalVenta);
        if (totalF > totalVenta) {
            $('#advertencia').show();
        } else if (totalF <= totalVenta) {
            $('#advertencia').hide();
            cancelado += montoBs;

            const metodo = {
                metodo: metodoPago,
                cantidad: cantidadPagada,
                banco_origen: bancoOrigen,
                banco_destino: bancoDestino,
                numero_referencia: numeroReferencia,
                monto_bs: montoBs,
                monto_dollar: montoDollar
            };

            metodosPago.push(metodo);
            $('#cancelado').text('Bs' + cancelado.toFixed(2));

            // Check if total is paid
            if (cancelado >= totalVenta) {
                $('#submitBtn').prop('disabled', false);
            } else {
                $('#submitBtn').prop('disabled', true);
            }
        }

        actualizarMetodosPago();
        calcularTotalPagos();

        // Limpiar campos
        $('#cantidadPagada').val('');
        $('#bancoOrigen').val('');
        $('#bancoDestino').val('');
        $('#numeroReferencia').val('');
    });
    // Eliminar Método de Pago
    $(document).on('click', '.removeMetodoPago', function () {
        const index = $(this).data('index');
        metodosPago.splice(index, 1);
        actualizarMetodosPago();
        calcularTotalPagos();
    });

    // Actualizar lista de métodos de pago en el DOM
    function actualizarMetodosPago() {
        let html = '';
        metodosPago.forEach((metodo, index) => {
            html += `
           <div class="mb-2 metodoPagoItem mt-3 d-flex align-items-center justify-content-between">
    <div class="d-flex flex-column">
        <span class="fw-bold">${metodo.metodo} - $${metodo.monto_dollar.toFixed(2)} (${metodo.monto_bs.toFixed(2)} Bs)</span>
        <small class="text-muted">
            ${metodo.banco_origen ? 'Origen: ' + metodo.banco_origen : ''}
            ${metodo.banco_destino ? ' | Destino: ' + metodo.banco_destino : ''}
            ${metodo.numero_referencia ? ' | Ref: ' + metodo.numero_referencia : ''}
        </small>
    </div>
    <button type="button" class="btn btn-danger btn-sm removeMetodoPago" data-index="${index}">
        <i class="bi bi-trash3-fill"></i> Eliminar
    </button>
</div>

        `;
        });
        $('#metodosPagoList').html(html);
        $('#metodosPagoInput').val(JSON.stringify(metodosPago));
    }

    // Calcular y actualizar total a pagar y total cancelado
    function calcularTotalPagos() {
        totalPagar = 0;
        totalCancelado = 0;


        // Si el método de pago es divisa, aplicar la tasa de cambio al monto_bs
        metodosPago.forEach(metodo => {


            // Si el método de pago es divisa, aplicar la tasa de cambio al monto_bs
            if (metodo.metodo === 'Divisa') {
                totalCancelado += metodo.cantidad * tasaCambio;
            } else {
                totalCancelado += metodo.monto_bs;
            }
        });

        // Actualizar en el DOM
        let totalVenta = parseFloat($('#totalVenta').text().replace('Bs', ''));
        $('#cancelado').text('Bs' + totalCancelado.toFixed(2));
        $('#restante').text((totalCancelado - totalVenta).toFixed(2));


        // Habilitar o deshabilitar botón submit según el total pagado
        validarTotalPagado();
    }

    // Validar el total pagado y habilitar/deshabilitar botón submit
    function validarTotalPagado() {
        const tasa = parseFloat($('#tasa').val()) || 1; // Obtener la tasa de cambio (por defecto 1 si está vacío)
        const totalPagadoBs = totalCancelado * tasa;

        if (totalPagadoBs >= totalPagar) {
            $('#btnSubmit').prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
        } else {
            $('#btnSubmit').prop('disabled', true).removeClass('btn-primary').addClass('btn-danger');
            alert('El monto pagado no puede ser menor al total a pagar en bolívares.');
        }
    }

    // Evento cambio en la tasa de cambio
    $('#tasa').on('input', function () {
        tasaCambio = parseFloat($(this).val()) || 1; // Actualizar la tasa de cambio
        calcularTotalPagos(); // Recalcular total con la nueva tasa de cambio
    });

    // Envío del formulario
    $('#ventaForm').on('submit', function (event) {
        event.preventDefault();

        // Validar una última vez antes de enviar
        if (totalPagar <= 0 || totalCancelado < totalPagar) {
            alert('Aún no se ha pagado el total requerido.');
            return;
        }

        // Aquí puedes enviar el formulario al controlador
        // Implementa tu lógica para enviar los datos al servidor
        alert('Formulario enviado correctamente.');
        // this.submit(); // Descomenta esta línea para enviar el formulario realmente
    });



    document.getElementById("submitBtn").addEventListener("click", function () {
  const carrito = document.getElementById("productoCarrito"); // Elemento del carrito original
  const totalModal = document.getElementById("totalModal"); // Elemento del carrito original
  const totalVenta = document.getElementById("totalVenta"); // Elemento del carrito original
  const totalVentaBS = document.getElementById("totalVentaBs"); // Elemento del carrito original
  const totalModalBs = document.getElementById("totalModalBs"); // Elemento del carrito original

  const valorTotalVenta = totalVenta ? totalVenta.innerText : '0'; // Si no existe, asigna '0'
const valorTotalVentaBS = totalVentaBS ? totalVentaBS.innerText : '0'; // Si no existe, asigna '0';

// Asignar los valores a totalModal y totalModalBs
if (totalModal) {
    totalModal.innerText = valorTotalVenta; // Asigna el texto de totalVenta a totalModal
}

if (totalModalBs) {
    totalModalBs.innerText = valorTotalVentaBS; // Asigna el texto de totalVentaBS a totalModalBs
}
  const confirmCarrito = document.getElementById("confirmProductoCarrito"); // Contenedor del modal

  // Limpia el contenido previo del modal
  confirmCarrito.innerHTML = "";

  // Clona los productos del carrito y los agrega al modal
  const productos = carrito.querySelectorAll(".productoCarrito");
  productos.forEach((producto) => {
    const productoClone = producto.cloneNode(true);

    // Deshabilitar entradas y botones de edición en el modal
    const inputs = productoClone.querySelectorAll("input");
    inputs.forEach((input) => input.setAttribute("disabled", true));

    const removeButton = productoClone.querySelector(".removeProducto");
    if (removeButton) {
      removeButton.remove(); // Eliminar botones de eliminación
    }

    confirmCarrito.appendChild(productoClone); // Agregar producto clonado al modal
  });
});

document.getElementById("confirmVenta").addEventListener("click", function () {
  // Obtén el formulario
  const form = document.getElementById("ventaForm");

  // Envía el formulario
  form.submit();
});


</script>

@endsection