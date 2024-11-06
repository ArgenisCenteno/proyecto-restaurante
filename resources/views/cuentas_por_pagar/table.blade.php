<table class="table" id="cuentas-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Proveedor</th>
            <th>Tipo</th>
            <th>Monto</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cuentas as $cuenta)
            <tr>
                <td>{{ $cuenta->id }}</td>
                <td>{{ $cuenta->proveedor->razon_social ?? 'Sin proveedor' }}</td>
                <td>{{ $cuenta->tipo }}</td>
                <td>{{ number_format($cuenta->monto, 2) }}</td>
                <td>
                    @if($cuenta->estado != 'Pagado')
                        <span class="badge badge-danger">Pendiente</span>
                    @else
                    <span class="badge badge-success">Pagado</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('cuentas-por-pagar.edit', $cuenta) }}" class="btn btn-primary">Editar</a>
                    <form action="{{ route('cuentas-por-pagar.destroy', $cuenta) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#cuentas-table').DataTable({
            order: [[0, 'desc']],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json'
            }
        });
    });
</script>
