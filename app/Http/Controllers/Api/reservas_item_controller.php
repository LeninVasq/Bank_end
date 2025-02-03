<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\reservas_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class reservas_item_controller extends Controller
{


    public function app_reservas_item($id)
    {
        $reservas = DB::select('CALL ver_item_pedidos(?)', [$id]);


        $data = [
            'message' => $reservas,
            'status' => 200

        ];
        return response()->json($data, 200); // Retorna los menús en formato JSON
    }


    public function grafica_platillo_mas_reservado(){

        $menus = DB::table('grafica_plato_mas_reservado')->get();

        $data = [
            'message' => $menus,
            'status' => 200

        ];
        return response()->json($data, 200);

    }




    


    public function show($id)
    {
        $reservas = DB::select('CALL reservas_web(?)', [$id]);


        $data = [
            'message' => $reservas,
            'status' => 200

        ];
        return response()->json($data, 200); // Retorna los menús en formato JSON
    }

    public function destroy($id)
    {
        $reserva_item = reservas_item::find($id);
        if (!$reserva_item) {
            $data = [
                'message' => 'El id de la reserva item no existe no existe',
                'status' => 404

            ];
            return response()->json($data, 404);
        }

        $id_menu = $reserva_item->id_menu;
        $cantidad_item = $reserva_item->cantidad;


        $menu = Menu::find($id_menu);
        $stockActual = $menu->cantidad_platos;
        $nuevoStock = $stockActual + $cantidad_item;
        $menu->cantidad_platos = $nuevoStock;
        $menu->save();


        $reserva_item->delete();

        $data = [
            'message' => $menu,
            'status' => 200

        ];
        return response()->json($data, 200);
    }
}
