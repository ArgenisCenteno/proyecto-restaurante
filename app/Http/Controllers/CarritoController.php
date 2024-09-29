<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use Session;
use Alert;
class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function products(Request $request)
    {
        $categorias = SubCategoria::all();
        $query = Producto::query();

        // Apply filters
        if ($request->filled('subcategoria')) {
            // Make sure you are using the correct key here
            $query->where('sub_categoria_id', $request->subcategoria);
        }

        if ($request->filled('rango_precio')) {
            // Correctly retrieve the price range
            // dd($request->filled('rango_precio'));
            $priceRange = explode('-', $request->rango_precio); // Ensure this key matches your request
            $query->whereBetween('precio_venta', [$priceRange[0], $priceRange[1]]);
        }

        $productos = $query->paginate(12);

        return view('productos')->with('categorias', $categorias)->with('productos', $productos);
    }

    public function detalles($id)
    {
        $producto = Producto::find($id);



        return view('detalles')->with('producto', $producto);
    }

    public function agregarCarrito(Request $request, $id)
    {
        // Retrieve the product based on ID
        $producto = Producto::find($id);

        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado');
        }



        // Create a cart item
        $cartItem = [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'cantidad' => 1,
            'precio' => $producto->precio_venta,
            'imagen' => asset($producto->imagenes[0]->url) // Use the first image
        ];

        // Get existing cart from session
        $cart = Session::get('cart', []);

        if (count($cart) > 0) {
            foreach ($cart as $key => $item) {
                if ($item['nombre'] === $producto->nombre) {
                    $cart[$key]['cantidad'] += 1; // Update quantity
                    session()->put('cart', $cart);
                    Alert::success('Exito!', 'Se aumento la cantidad del producto ya existente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
                    return redirect()->back();
                } else {
                    // Add product to the cart
                    $cart[] = $cartItem;

                }
            }
        } else {
            $cart[] = $cartItem;
        }




        // Save the cart back to session
        Session::put('cart', $cart);
        Alert::success('Exito!', 'Producto agregado al carrito')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->back();
    }

    public function actualizarCarrito(Request $request)
    {
        $carrito = session()->get('cart');

        // Check if the cart exists
        if ($carrito) {
            // Find the product by name
            foreach ($carrito as $key => $item) {
                if ($item['nombre'] === $request->product) {
                    $carrito[$key]['cantidad'] = $request->cantidad; // Update quantity
                    session()->put('cart', $carrito);
                    return response()->json(['success' => true, 'message' => 'Carrito actualizado.']);
                }
            }
        }

        return response()->json(['success' => false, 'message' => 'Item no encontrado en carrito']);
    }

    public function checkout(Request $request)
    {
        $carrito = session()->get('cart');

        if(!$carrito){
            Alert::error('¡Error!', 'Carrito vacío')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->back();
        }

        $total = 0;
        $impuesto = 0;
        $montoTotal = 0;

        if (count($carrito) > 0) {
            foreach ($carrito as $c) {
                $total += $c['precio'] * $c['cantidad'];

                $consulta = Producto::find($c['id']);
                //dd($consulta);
                if($consulta->aplica_iva === 1) {
                    $impuesto += $c['precio'] * $c['cantidad'] * 0.16;
                }
                
            }
        }

        $montoTotal = $impuesto + $total;

        return view('pagar', compact('carrito', 'total', 'montoTotal', 'impuesto'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $cart = Session::get('cart', []);


        $total = 0;

        if (count($cart) > 0) {
            foreach ($cart as $c) {
                $total += $c['precio'] * $c['cantidad'];
            }
        }


        return view('carrito', compact('cart', 'total'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
