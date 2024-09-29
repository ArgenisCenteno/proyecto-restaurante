<form action="{{ route('usuarios.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña (opcional)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="mb-3">
            <label for="dni" class="form-label">Cédula</label>
            <input type="text" class="form-control" id="dni" name="dni" value="{{ $user->dni }}" required>
        </div>

        <div class="mb-3">
            <label for="sector" class="form-label">Sector</label>
            <input type="text" class="form-control" id="sector" name="sector" value="{{ $user->sector }}">
        </div>

        <div class="mb-3">
            <label for="calle" class="form-label">Calle</label>
            <input type="text" class="form-control" id="calle" name="calle" value="{{ $user->calle }}">
        </div>

        <div class="mb-3">
            <label for="casa" class="form-label">Casa</label>
            <input type="text" class="form-control" id="casa" name="casa" value="{{ $user->casa }}">
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Rol</label>
            <select class="form-select" id="role" name="role" required>
                <option value="">Selecciona un rol</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <select class="form-select" id="status" name="status" required>
                <option value="Activo" {{ $user->status == 'Activo' ? 'selected' : '' }}>Activo</option>
                <option value="Inactivo" {{ $user->status == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>