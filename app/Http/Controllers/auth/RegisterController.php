<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role; // Make sure to import the Role model

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
{
    return Validator::make($data, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8'],
        'sector' => 'nullable|string|max:255',
        'calle' => 'nullable|string|max:255',
        'casa' => 'nullable|string|max:255',
        'cedula' => ['required', 'integer', 'digits_between:7,8'], // Add this line
    ]);
}


    protected function create(array $data)
    {
        // Create the user with additional fields
        $user = User::create([
            'name' => $data['name'],
            'cedula' => $data['cedula'], // Include cedula
            'email' => $data['email'],
            'sector' => $data['sector'], // Include sector
            'calle' => $data['calle'],   // Include calle
            'casa' => $data['casa'],     // Include casa
            'password' => Hash::make($data['password']),
            'status' => 'Activo', // Set status to 'Activo'
        ]);

        // Assign the 'cliente' role to the user
        $user->assignRole('cliente');

        return $user;
    }
}
