<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //vistas



        DB::statement("
       
CREATE

    VIEW web_reservas
    AS
( SELECT 
               reservas.id_reservas, 
               SUM(reservas_item.cantidad) AS cantidad,
               users.correo AS usuario_correo,
                SUM(reservas_item.cantidad * reservas_item.precio )AS precio,
               users.img
           FROM 
               reservas
           INNER JOIN 
               reservas_item ON reservas.id_reservas = reservas_item.id_reservas
           INNER JOIN 
               menu ON reservas_item.id_menu = menu.id_menu
           INNER JOIN 
               categoria_menu ON menu.id_categoria = categoria_menu.id_categoria_menu
           INNER JOIN 
               users ON reservas.id_usuario = users.id_usuario 
           WHERE 
                reservas.fecha_entrega IS NULL AND reservas.estado = 1
                GROUP BY id_reservas, correo, img
              );
        ");


        DB::statement("
       CREATE
    VIEW app_categoria_menu 
    AS
(SELECT
  categoria_menu.id_categoria_menu AS id_categoria_menu,
  categoria_menu.nombre            AS nombre,
  categoria_menu.foto              AS foto,
  SUM(menu.cantidad_platos)        AS cantidad_platos
FROM (categoria_menu
   JOIN menu
     ON (categoria_menu.id_categoria_menu = menu.id_categoria))
WHERE menu.cantidad_platos > 0
GROUP BY categoria_menu.id_categoria_menu,categoria_menu.nombre
,categoria_menu.foto);
        ");


        DB::statement("

        CREATE
        VIEW categoria_count_productos 
        AS
    (SELECT
      c.id_categoria_pro AS id_categoria_pro,
      c.nombre_categoria AS nombre_categoria,
      c.descripcion      AS descripcion,
      c.foto             AS foto,
      c.estado           AS estado,
      c.created_at       AS created_at,
      c.updated_at       AS updated_at,
      COUNT(p.id_categoria_pro) AS cantidad_productos
    FROM (categoria_pro c
       LEFT JOIN productos p
         ON (c.id_categoria_pro = p.id_categoria_pro))
    GROUP BY c.id_categoria_pro,c.nombre_categoria,c.descripcion,c.estado,c.created_at,c.updated_at,c.foto
    ORDER BY COUNT(p.id_categoria_pro)DESC);
         ");


         DB::statement("

         CREATE
       VIEW grafica_productos_mas_utilizados 
       AS
   (SELECT
     p.nombre AS nombre,
     COUNT(0)     AS cantidad
   FROM (receta_producto r
      JOIN productos p
        ON (r.id_producto = p.id_producto))
   GROUP BY p.id_producto,p.nombre
   ORDER BY COUNT(0)DESC
   LIMIT 6);
            ");


            DB::statement("

            CREATE
            VIEW grafica_plato_mas_reservado 
            AS
        (SELECT
          menu.nombre AS nombre,
          COUNT(0)        AS cantidad
        FROM (reservas_item
           JOIN menu
             ON (menu.id_menu = reservas_item.id_menu))
        GROUP BY menu.id_menu,menu.nombre
        ORDER BY COUNT(0)DESC
        LIMIT 6);
        
               ");


        


         
        //procedimientos

        DB::statement("

        CREATE PROCEDURE app_menu( IN id_categoria_param INT)
    
     BEGIN
 
  SELECT
         menu.id_menu         AS id_menu,
         menu.nombre          AS nombre,
         menu.precio          AS precio,
         menu.cantidad_platos AS cantidad_platos
     FROM menu
     WHERE id_categoria = id_categoria_param AND cantidad_platos > 0;
 END");


 DB::statement("
 CREATE PROCEDURE app_menu_img(     IN id_categoria_param INT
)

BEGIN
SELECT
        `menu`.`id_menu` AS `id_menu`,
        `menu`.`img`     AS `img`
    FROM `menu`
    WHERE `id_categoria` = id_categoria_param AND cantidad_platos > 0;

     END
            ");


                    DB::statement("
                    CREATE PROCEDURE app_reservas(     IN usuario_id INT
)

BEGIN
SELECT reservas_item.id_reserva_item,reservas.id_reservas, menu.nombre, menu.img, reservas_item.cantidad AS cantidad, reservas_item.precio
FROM reservas
INNER JOIN reservas_item ON reservas.id_reservas = reservas_item.id_reservas
INNER JOIN menu ON reservas_item.id_menu = menu.id_menu
INNER JOIN categoria_menu ON menu.id_categoria = categoria_menu.id_categoria_menu
WHERE reservas.id_usuario = usuario_id AND reservas.fecha_entrega IS NULL
;    
END



       
                               ");





                               DB::statement("
                               CREATE PROCEDURE reservas_web(  
                               IN id_re   INT    
       )
          
           BEGIN
        SELECT 
               reservas.id_reservas, 
               menu.`nombre`,
               reservas_item.cantidad,
                   reservas_item.precio,
               menu.img AS foto, 
                   menu.nombre,
               users.correo AS usuario_correo 
           FROM 
               reservas
           INNER JOIN 
               reservas_item ON reservas.id_reservas = reservas_item.id_reservas
           INNER JOIN 
               menu ON reservas_item.id_menu = menu.id_menu
           INNER JOIN 
               categoria_menu ON menu.id_categoria = categoria_menu.id_categoria_menu
           INNER JOIN 
               users ON reservas.id_usuario = users.id_usuario 
           WHERE 
                reservas.id_reservas = id_re;
       END
           
                  
                                          ");



                                          DB::statement("
                                          CREATE
    PROCEDURE app_reservas_entregada(IN id_Usuario INT)

	BEGIN
SELECT ri.id_reservas, r.fecha_entrega, SUM(ri.cantidad) AS cantidad ,
SUM(ri.precio * ri.cantidad) AS precio_total
FROM reservas r INNER JOIN reservas_item ri ON r.`id_reservas` =r.`id_reservas` WHERE id_usuario = id_Usuario
GROUP BY ri.id_reservas;
	END
                      
                             
                                                     ");




                                                     DB::statement("
                                         CREATE
    PROCEDURE pedidos(IN id_usuario INT)

	BEGIN
	
SELECT r.id_reservas, SUM(cantidad) AS cantidad, SUM(precio * cantidad) AS precio,fecha_entrega FROM reservas r INNER JOIN reservas_item ri ON r.id_reservas = ri.id_reservas
WHERE r.id_usuario = 2 AND fecha_entrega IS NOT NULL
GROUP BY r.id_reservas 
;
	END
                      
                             
                                                     ");
            }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
