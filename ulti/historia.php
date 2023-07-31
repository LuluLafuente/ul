<?php

//INICIO SESION
session_start();

//AGREGO LAS FUNCIONES NECESARIAS PARA EL FUNCIONAMIENTO DE LA CARGA DE ALUMNOS
include 'bd_conexion.php';
include 'bd_select.php';

//REVISO QUE HAYA UNA SESION ACTIVA DE USUARIO,
//DE LO CONTRARIO VUELVE A LA PAGINA DE INICIO.
if(!isset($_SESSION["usuario"])){
    //header("location:index.html");
    //echo "Verdadero </br>";
}
//DECLARAR VARIABLES
$listaMaterias = [];

//CONEXION CON LA BASE DE DATOS
$conexion = conexionDB();

//BUSCAR LA LISTA DE MATERIAS
$planEstudio = selectPlanEstudio($conexion, $_SESSION["u_carrera"]);
$consulta = selectHistoriaAlumno($conexion);
//GUARDO TODOS LOS RESULTADOS EN UNA VARIABLE
$resultado = $consulta->fetchAll();
$resultadoPlan = $planEstudio->fetchAll();
//$resultado2 = $consulta2->fetchAll();
include('historia.html');