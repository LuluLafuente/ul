<?php
    //FUNCION DE CONEXION CON LA BASE DE DATOS
    function conexionDB(){

        //DECLARO LAS VARIABLES PARA EL STRING DE CONEXION
        $host = "127.0.0.1";
        $dbNombre = "bd_prueba";
        $usuario = "isetEducativo";
        $contrasenia = "unaClaveMuyDificil1";

        //EJECUTO LA CONEXION CON LA CLASE PDO DE PHP
        $conexion = new PDO("mysql:host = $host; dbname=$dbNombre", "$usuario", "$contrasenia");

        //DEVUELVO EL RESULTADO DE LA OPERACION
        return $conexion;
    }
?>