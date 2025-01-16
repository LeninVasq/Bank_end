<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\reservas;
use App\Models\reservas_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class reservas_controller extends Controller
{

    public function update(Request $request, $id)
    {
        $reservas = reservas::find($id);
        if (!$reservas) {
            $data = [
                'message' => 'El id de la reserva no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }




        // Solo actualiza los campos que se proporcionan
        if ($request->has('fecha_entrega')) {
            $reservas->fecha_entrega = $request->fecha_entrega;
        }
        

        $reservas->save();

        $data = [
            'message' => 'Reserva actualizada',
            'status' => 200
        ];
        return response()->json($data, 200);
    }


    public function reservas($id)
    {
       $reservas = DB::select('CALL reservas_web(?)', [$id]);
       

        $data = [
           'message' => $reservas,
           'status' => 200

       ]; 
        return response()->json($data, 200); // Retorna los menús en formato JSON
    }

    public function app_reservas($id)
    {
       $reservas = DB::select('CALL app_reservas(?)', [$id]);
       

        $data = [
           'message' => $reservas,
           'status' => 200

       ]; 
        return response()->json($data, 200); // Retorna los menús en formato JSON
    }

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
            'precio' => $request->precio,
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
