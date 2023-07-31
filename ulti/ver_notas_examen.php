<?php

// INICIO SESION
session_start();

// AGREGO LAS FUNCIONES NECESARIAS PARA EL FUNCIONAMIENTO DE LA CARGA DE ALUMNOS
include 'bd_conexion.php';
include 'bd_select.php';

// REVISO QUE HAYA UNA SESION ACTIVA DE USUARIO,
// DE LO CONTRARIO VUELVE A LA PAGINA DE INICIO.
if(!isset($_SESSION["usuario"])){
    //header("location:index.html");
    //echo "Verdadero </br>";
}

// DECLARAR VARIABLES
$listaMaterias = [];

// CONEXION CON LA BASE DE DATOS
$conexion = conexionDB();
//Busqueda de datos
$consulta = selectListaNotas($conexion);

//Se guardan datos
$resultado = $consulta->fetchAll();

include('ver_notas_examen.html');