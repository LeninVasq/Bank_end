<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\reservas;
use App\Models\reservas_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class reservas_controller extends Controller
{


    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'id_usuario' => 'required|exists:users,id_usuario',
            'id_menu' => 'required|exists:menu,id_menu',
            'cantidad' => 'required|int',
        ]);
        
        if ($validation->fails()) {
            $data = [
                'message' => 'El usuario no existe',
                'details' => $validation->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $menu = Menu::find($request->id_menu);

        $stockActual = $menu->cantidad_platos;

        if($request->cantidad > $stockActual){
            $data = [
                'excess' => 'La cantidad elegida supera la cantidad de platos que hay',
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $reservas = reservas::create([
            'id_usuario' => $request->id_usuario,
        ]);

        $reservas_item = reservas_item::create([
            'id_menu' => $request->id_menu,
            'cantidad' => $request->cantidad,
            'id_reservas' =>$reservas->id_reservas,

        ]);

        
        $nuevoStock = $stockActual - $request->cantidad;

        

        $menu->cantidad_platos = $nuevoStock;

        $menu->save();


        $data = [
            'message' => "Se ha reservado exitosamente",
            'status' => 201

        ];
        return response()->json($data, 201);
    }


    public function index()
    {
        $data = [];

        $reservas = reservas::all();
        
        
         
        if ($reservas->isEmpty()) {
            $data = [
                'message' => 'No hay reservas registrados',
                'status' => 200
            ];
        } else {
            $data = [
                'reservas' => $reservas,
                'status' => 200
            ];
        }
        return response()->json($data, 200);
    }
}
