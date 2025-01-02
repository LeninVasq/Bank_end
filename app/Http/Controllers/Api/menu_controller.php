<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class menu_controller extends Controller
{
    /**
     * Mostrar todos los menús.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::all(); // Obtiene todos los menús
        return response()->json($menus); // Retorna los menús en formato JSON
    }

    /**
     * Crear un nuevo menú.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'precio' => 'numeric',
            'cantidad_platos' => 'required|integer',
            'descripcion' => 'string',
            'img' => 'required',
            'estado' => 'required|boolean',
        ]);

        $menu = Menu::create($request->all()); // Crea un nuevo menú con los datos recibidos
        return response()->json($menu, 201); // Retorna el menú creado con código de estado 201 (creado)
    }

    /**
     * Mostrar un menú específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json(['message' => 'Menú no encontrado'], 404); // Si no se encuentra el menú
        }

        return response()->json($menu); // Retorna el menú encontrado
    }

    /**
     * Actualizar un menú existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json(['message' => 'Menú no encontrado'], 404); // Si no se encuentra el menú
        }

        $request->validate([
            'nombre' => 'string',
            'precio' => 'numeric',
            'cantidad_platos' => 'integer',
            'descripcion' => 'string',
            'img' => 'string',
            'estado' => 'boolean',
        ]);

        $menu->update($request->all()); // Actualiza el menú con los nuevos datos
        return response()->json($menu); // Retorna el menú actualizado
    }

    /**
     * Eliminar un menú específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json(['message' => 'Menú no encontrado'], 404); // Si no se encuentra el menú
        }

        $menu->delete(); // Elimina el menú
        return response()->json(['message' => 'Menú eliminado exitosamente'], 200); // Respuesta de éxito
    }
}
