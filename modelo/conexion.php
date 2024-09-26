<?php 

class Conexion{
    //la clase de conexion para generar una llamada a la base de datos


    static public function conectar(){

        $link= new PDO("mysql:host=localhost;dbname=evaluacion","root" ,"");

        $link->exec("set names utf8");


        return $link;


    }


}


?>