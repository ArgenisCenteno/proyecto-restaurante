@extends('layouts.app')

@section('content')
<div class="container pt-4">
    <div class="row">
        <!-- Filter Section -->
        <div class="col-md-3">
            <h4>Filtros</h4>
            <form method="GET" action="{{ route('products') }}">
                <div class="form-group">
                    <label for="category">Categorías</label>
                    <select id="category" name="subcategoria" class="form-control">
                        <option value="">Todas las categorias</option>
                        @foreach($categorias as $category)
                            <option value="{{ $category->id }}" {{ request('subcategoria') == $category->id ? 'selected' : '' }}>
                                {{ $category->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="rango_precio">Rango de Precio</label>
                    <input type="text" id="rango_precio" name="rango_precio" class="form-control" placeholder="EJ., 10-100" value="{{ request('price_range') }}">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary mt-4">Aplicar filtro</button>
                </div>
            </form>
        </div>

        <!-- Products Section -->
        <div class="col-md-9">
            <h4>Productos</h4>
            <div class="row">
                @foreach($productos as $product)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ $product->imagenes[0]->url }}" class="card-img-top" alt="{{ $product->nombre }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->nombre }}</h5>
                                <p class="card-text bold">{{ $product->precio_venta }} BS.</p>
                                <a href="{{ route('detalles', $product->id) }}" class="btn btn-primary">Detalles</a>
                            </div>
                        </div>
                        
                    </div>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $productos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
