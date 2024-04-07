<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AccesoRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegsitroRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;

class AutenticarController extends Controller
{
    public function registro(RegsitroRequest $request)
    {
        $user= new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->save();

        $user->roles()->attach($request->roles);

        return response()->json([
            'res'=>true,
            'msg'=>'Usuario registrado correctamente'
        ],200);
    }
    public function acceso(AccesoRequest $request)
    {
        $user = User::with('roles')->where('email', $request->email)->first();
 
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'res'=>true,
                'msg' => ['Las credenciales son incorrectas!!!'],
            ]);
        }
     
        $token= $user->createToken($request->email)->plainTextToken;

        return response()->json([
            'res'=>true,
            'token'=>$token,
            'usuario'=>$user//muestra dato usuario
        ],200);
    }
    public function cerrarSesion(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'res'=>true,
            'msg'=>"Token eliminado correctamente"
        ],200);
    }
    
}
