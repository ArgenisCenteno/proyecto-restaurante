<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Compra;
use App\Models\CuentaPorCobrar;
use App\Models\CuentaPorPagar;
use App\Models\Mesa;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\SubCategoria;
use App\Models\User;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $ventas = Venta::where('status', 'Pagado')->whereDate('created_at', Carbon::today())->sum('monto_total');
        $compras = Compra::where('status', 'Pagado')->whereDate('created_at', Carbon::today())->sum('monto_total');
        $usuarios = User::count();
        $productos = Producto::count();
        $categorias = Categoria::count();
        $subcategorias = SubCategoria::count();
        $proveedores = Proveedor::count();
        $pagos = Pago::count();
        $deudas = CuentaPorPagar::where('estado', 'Pendiente')->sum('monto');
        $creditos = CuentaPorCobrar::where('estado', 'Pendiente')->sum('monto');
        $mesas = Mesa::with('ventaActiva')->get();

        $notificaciones = auth()->user()->unreadNotifications;
        function isConnected()
        {
            $connected = @fsockopen("www.google.com", 80); // Intenta conectar al puerto 80 de Google
            if ($connected) {
                fclose($connected);
                return true; // Hay conexión
            }
            return false; // No hay conexión
        }

        if (isConnected()) {
            $response = file_get_contents("https://ve.dolarapi.com/v1/dolares/oficial");

        } else {

            $response = false;
        }



        // dd();
        if ($response) {
            $dato = json_decode($response);
            $dollar = $dato->promedio;
        } else {
            $dollar = 44.30;
        }

        return view('home', compact('mesas', 'ventas', 'deudas', 'creditos', 'dollar', 'compras', 'notificaciones', 'proveedores', 'usuarios', 'productos', 'categorias', 'subcategorias', 'pagos'));
    }


}
