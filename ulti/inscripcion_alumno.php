<?php

// INICIO SESION
session_start();

// AGREGO LAS FUNCIONES NECESARIAS PARA EL FUNCIONAMIENTO DE LA CARGA DE ALUMNOS
include 'bd_conexion.php';
include 'bd_select.php';
include 'constantes.php';

// REVISO QUE HAYA UNA SESION ACTIVA DE USUARIO,
// DE LO CONTRARIO VUELVE A LA PAGINA DE INICIO.
if(!isset($_SESSION["usuario"])){
    //header("location:index.html");
    //echo "Verdadero </br>";
}

// DECLARAR VARIABLES
$_SESSION['alumno_inscripto'] = "";
$_SESSION['viene_de'] = ROL_ALUMNO;
$nroAlumnos = 0;

// CONEXION CON LA BASE DE DATOS
$conexion = conexionDB();

$nroAlumnos = selectNroDeAlumnosInscriptos($conexion, date('Y'));

// ZONA DE PRUEBAS INICIO



// ZONA DE PRUEBAS FIN

include('inscripcion_alumno.html');