<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class auth_controller extends Controller
{
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id_tipo_usuario' => 'required|exists:tipo_usuario,id_tipo_usuario',
            'correo' => 'required|email|unique:users,correo',
            'clave' => 'required|min:8',
            //'clave' => 'required|min:8|confirmed',
            //'token' => 'sometimes|string',
            //'img' => 'sometimes|string',
            //'correo_verificado' => 'sometimes|string',
            //'estado' => 'sometimes'
        ]);

        if ($validation->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'details' => $validation->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $user = new User();

        if ($request->has('id_tipo_usuario')) {
            $user->id_tipo_usuario = $request->id_tipo_usuario;
        }
        if ($request->has('correo')) {
            $user->correo = $request->correo;
        }
        if ($request->has('clave')) {
            $user->clave =  $request->clave;    

            //$user->clave =  Hash::make($request->clave);    
        }
        if ($request->has('token')) {
            $user->token = $request->token;
        }

        $user->save();

        $data = [
            'message' => 'Se ha registrado exitosamente',
            'status' => 200
        ];
        return response()->json($data, 200); 
    }

    public function login(Request $request)
    {

        
        $validation = Validator::make($request->all(), [
            'correo' => 'required|email',
           // 'clave' => 'required|min:8',
        ]);

        if ($validation->fails()) {
            $data = [
                //'error' => 'Error en la validación de datos',
                'details' => $validation->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        
        

        
        $credentials = [
            'correo' => $request->input('correo'),
            'password' => $request->input('clave'),
        ];
        
        
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken("token")->plainTextToken;
            $cookie = cookie("cookie_token",$token, 60*24);
           
            $email = $request->input('correo');
        
            $users = User::where('correo', $email)->first();
           
            $users->token = $token;
            $users->save();    
    
            $data = [
                'id'=> $user->id_usuario,
                'correo'=> $user->correo,
                'tipo_usuario'=> $user->id_tipo_usuario,
                'message' => 'Se ha logeado exitosamente',
                'token' => $token,
                'status' => 200,
                'estado' => $user->estado
            ];

            return response()->json($data, 200)->cookie($cookie); 
        }
        
        $data = [
            'error' => 'Las credenciales no son correctas',
            'status' => 401
        ];
        return response()->json($data, 401);
    }

    
    
    public function logout ($id){
        $user = User::find($id);
        $user->token = "";
        $user->save();
        $cookie = Cookie::forget('cookie_token');
        $data = [
            'message' => 'Cerrando session',
            'status' => 200
        ];
        return response()->json($data, 200)->withCookie($cookie); 
    }


}
