<?php
 /*=============================================
		index del proyecto, y el archivo .htacces hace que nos redireccione siempre acá
		=============================================*/
    require_once "controlador/rutasControlador.php";
    require_once "controlador/employeesControlador.php";
    require_once "modelo/employeesModel.php";
    $rutas=new ControladorRutas;
    $rutas->inicio();


?>