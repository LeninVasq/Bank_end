<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\tipo_usuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class usuario_controller extends Controller
{

    




    //actualiza todos los campos y parcialmete
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            $data = [
                'message' => 'El id del usuario no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }




        $validation =  Validator::make($request->all(), [
            'id_tipo_usuario' => 'sometimes|exists:tipo_usuario,id_tipo_usuario',
            'correo' => [
                'sometimes',
                'email',
                Rule::unique('users')->ignore($user->id_usuario, 'id_usuario'),
            ],
            'clave' => 'sometimes|min:8',
            'token' => 'sometimes',
            'img' => 'sometimes|string',
            'correo_verificado' => 'sometimes|string',
            'estado' => 'sometimes'
        ]);


        if ($validation->fails()) {

            $data = [
                'message' => 'Error en la validation de datos',
                'error' => $validation->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('id_tipo_usuario')) {
            $user->id_tipo_usuario = $request->id_tipo_usuario;
        }
        if ($request->has('correo')) {
            $user->correo = $request->correo;
        }
        if ($request->has('clave')) {
            $user->clave = $request->clave;
        }
        if ($request->has('token')) {
            $user->token = $request->token;
        }
        if ($request->has('img')) {
            $user->img = $request->img;
        }
        if ($request->has('correo_verificado')) {
            $user->correo_verificado = $request->correo_verificado;
        }
        if ($request->has('estado')) {
            $user->estado = $request->estado;
        }

        $user->save();
        $data = [
            'message' =>$user,
            'status' => 200

        ];
        return response()->json($data, 200);
    }

    //elimina por id
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            $data = [
                'message' => 'El usuario no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $user->delete();

        $data = [
            'message' => "Usuario eliminado",
            'status' => 200

        ];
        return response()->json($data, 200);
    }

    //consulta por id
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            $data = [
                'message' => 'El id del usuario no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => $user,
            'status' => 200

        ];
        return response()->json($data, 200);
    }

    //insercion de usuarios
    public function store(Request $request)
    {

        $data = [];
        $tipo_usuario = tipo_usuario::all();

        if ($tipo_usuario->isEmpty()) {
            $data = [
                'mensaje' => 'No hay tipos de usuarios registrados',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $validation =  Validator::make($request->all(), [
            'id_tipo_usuario' => 'required|exists:tipo_usuario,id_tipo_usuario',
            'correo' => 'required|email|unique:users',
            'clave' => 'required|min:8',
        ]);

        if ($validation->fails()) {

            $data = [
                'message' => 'Error en la validation de datos',
                'error' => $validation->errors(),
                'status' => 400

            ];
            return response()->json($data, 400);
        }


        $users  = User::create([
            'id_tipo_usuario' => $request->id_tipo_usuario,
            'correo' => $request->correo,
            'clave' => $request->clave
        ]);

        if (!$users) {
            $data = [
                'message' => 'Error al crear el usuarios',
                'status' => 500

            ];
            return response()->json($data, 500);
        }


        $data = [
            'message' => $users,
            'status' => 201

        ];
        return response()->json($data, 201);
    }

    //lista todos los usuarios
    public function index()
    {
        $data = [];
        $user = User::whereIn('id_tipo_usuario', [1, 2])->get();

        if ($user->isEmpty()) {
            $data = [
                'message' => 'No hay usuarios registrados',
                'status' => 200
            ];
        } else {
            $data = [
                'users' => $user,
                'status' => 200
            ];
        }
        return response()->json($data, 200);
    }
}
