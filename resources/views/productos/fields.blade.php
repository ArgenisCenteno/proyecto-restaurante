<div class="row">
    <!-- Nombre Field -->
    <div class="form-group col-12 col-md-6 mb-3">
        {!! Form::label('nombre', 'Nombre:', ['class' => 'font-weight-bold']) !!}
        {!! Form::text('nombre', null, ['class' => 'form-control rounded', 'required']) !!}
    </div>

    <!-- Descripción Field -->
    <div class="form-group col-12 col-md-6 mb-3">
        {!! Form::label('descripcion', 'Descripción:', ['class' => 'font-weight-bold']) !!}
        {!! Form::text('descripcion', null, ['class' => 'form-control rounded', 'rows' => 3, 'required']) !!}
    </div>

    <!-- Precio Compra Field -->
    <div class="form-group col-12 col-md-6 mb-3">
        {!! Form::label('precio_compra', 'Precio Compra:', ['class' => 'font-weight-bold']) !!}
        {!! Form::number('precio_compra', null, ['class' => 'form-control rounded', 'step' => '0.01', 'id' => 'precio_compra', 'required']) !!}
        <p id="precio_compra_error" class="text-danger d-none">El precio de compra no puede ser negativo.</p>
    </div>

    <!-- Precio Venta Field -->
    <div class="form-group col-12 col-md-6 mb-3">
        {!! Form::label('precio_venta', 'Precio Venta:', ['class' => 'font-weight-bold']) !!}
        {!! Form::number('precio_venta', null, ['class' => 'form-control rounded', 'step' => '0.01', 'id' => 'precio_venta', 'required']) !!}
        <p id="precio_venta_error" class="text-danger d-none">El precio de venta no puede ser negativo.</p>
    </div>

    <!-- Aplica IVA Field -->
    <div class="form-group col-12 col-md-6 mb-3">
        {!! Form::label('aplica_iva', 'IVA:', ['class' => 'font-weight-bold']) !!}
        {!! Form::select('aplica_iva', ['1' => 'Sí', '0' => 'No'], null, ['class' => 'form-control rounded', 'required']) !!}
    </div>

    <!-- Cantidad Field -->
    <div class="form-group col-12 col-md-6 mb-3">
        {!! Form::label('cantidad', 'Cantidad:', ['class' => 'font-weight-bold']) !!}
        {!! Form::number('cantidad', null, ['class' => 'form-control rounded', 'step' => '1', 'required']) !!}
    </div>

    <!-- Subcategoría Field -->
    <div class="form-group col-12 col-md-6 mb-3">
        {!! Form::label('sub_categoria_id', 'Subcategoría:', ['class' => 'font-weight-bold']) !!}
        {!! Form::select('sub_categoria_id', $subcategorias, null, ['class' => 'form-control rounded', 'placeholder' => 'Selecciona una subcategoría', 'required']) !!}
    </div>

    <!-- Disponible Field -->
    <div class="form-group col-12 col-md-6 mb-3">
        {!! Form::label('disponible', 'Disponible:', ['class' => 'font-weight-bold']) !!}
        {!! Form::select('disponible', ['1' => 'Disponible', '0' => 'No Disponible'], null, ['class' => 'form-control rounded', 'required']) !!}
    </div>

    <!-- Campo de imágenes -->
    <div class="form-group col-12 col-md-6 mb-3">
        {!! Form::label('imagenes', 'Imágenes:', ['class' => 'font-weight-bold']) !!}
        {!! Form::file('imagenes[]', ['class' => 'form-control rounded', 'accept' => 'image/*', 'multiple' => true, 'id' => 'imagenes']) !!}
        <p id="imagenes_error" class="text-danger d-none">Puedes subir hasta 5 imágenes.</p>
    </div>

    <!-- Contenedor para previsualizar las imágenes -->
    <div class="form-group col-12 mb-3" id="imagenes-preview"></div>
</div>

<!-- Botones de acción -->
<div class="d-flex justify-content-end">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary rounded me-2', 'id' => 'submit_btn']) !!}
</div>


<script src="{{asset('js/sweetalert2.js')}}"></script>


<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        let precioCompraInput = document.getElementById('precio_compra');
        let precioVentaInput = document.getElementById('precio_venta');
        let submitBtn = document.getElementById('submit_btn');
        let precioCompraError = document.getElementById('precio_compra_error');
        let precioVentaError = document.getElementById('precio_venta_error');
        let imagenesInput = document.getElementById('imagenes');
        let previewContainer = document.getElementById('imagenes-preview');
        let imagenesError = document.getElementById('imagenes_error');

        // Función para validar los precios
        function validarPrecios() {
            let precioCompra = parseFloat(precioCompraInput.value);
            let precioVenta = parseFloat(precioVentaInput.value);
            let valid = true;

            if (isNaN(precioCompra) || precioCompra < 0) {
                precioCompraError.style.display = 'block';
                valid = false;
            } else {
                precioCompraError.style.display = 'none';
            }

            if (isNaN(precioVenta) || precioVenta < 0) {
                precioVentaError.style.display = 'block';
                valid = false;
            } else {
                precioVentaError.style.display = 'none';
            }

            submitBtn.disabled = !valid;
        }

       

        // Función para manejar la previsualización y eliminación de imágenes
        imagenesInput.addEventListener('change', function (event) {
            let files = event.target.files;
    let maxFiles = 5; // Máximo de archivos permitidos

    // Limpiar la previsualización actual
    previewContainer.innerHTML = '';

    // Validar cantidad de archivos seleccionados
    if (files.length > maxFiles) {
        imagenesError.style.display = 'block';
        imagenesInput.value = ''; // Limpiar la selección de archivos
        return;
    } else {
        imagenesError.style.display = 'none';
    }

    // Mostrar previsualización de cada imagen seleccionada
    Array.from(files).forEach((file) => {
        let reader = new FileReader();
        reader.onload = function (e) {
            let imgContainer = document.createElement('div');
            imgContainer.style.position = 'relative';
            imgContainer.style.display = 'inline-block';
            imgContainer.style.margin = '5px';

            let img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '300px';
            img.style.height = '300px';
            img.style.objectFit = 'cover';

            let removeBtn = document.createElement('button');
            removeBtn.innerText = 'Quitar';
            removeBtn.style.position = 'absolute';
            removeBtn.style.top = '0';
            removeBtn.style.right = '0';
            removeBtn.style.backgroundColor = 'black';
            removeBtn.style.color = 'white';
            removeBtn.style.border = 'none';
            removeBtn.style.borderRadius = '50%';
            removeBtn.style.width = '50px';
            removeBtn.style.height = '50px';
            removeBtn.style.cursor = 'pointer';

            removeBtn.addEventListener('click', function () {
                imgContainer.remove();
                let dt = new DataTransfer();
                for (let i = 0; i < files.length; i++) {
                    if (files[i] !== file) {
                        dt.items.add(files[i]);
                    }
                }
                imagenesInput.files = dt.files;
            });

            imgContainer.appendChild(img);
            imgContainer.appendChild(removeBtn);
            previewContainer.appendChild(imgContainer);
        }
        reader.readAsDataURL(file);
    });
});
    });
</script>