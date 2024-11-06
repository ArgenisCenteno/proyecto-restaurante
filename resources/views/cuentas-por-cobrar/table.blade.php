
<div class="table-responsive">
   
    <table class="table table-hover" id="cuentas-por-cobrar-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Pago</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>  
    </table>
</div>

@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="{{asset('js/sweetalert2.js')}}"></script>

<script>
    $(function() {
        $('#cuentas-por-cobrar-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('cuentas-por-cobrar.index') }}',
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'tipo', name: 'tipo' },
                { data: 'descripcion', name: 'descripcion' },
                { data: 'monto', name: 'monto' },
                { data: 'fecha', name: 'fecha' },
                { data: 'pago_id', name: 'pago_id' },
                { data: 'estado', name: 'estado' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },
            ]
            ,
            order: [[0, 'desc']],
        });
    });
</script>

