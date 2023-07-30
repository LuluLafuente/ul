<?php

//INICIO SESION
session_start();

//CIERRO LA SESION DEL USUARIO
switch ($_SESSION["u_rol"]) {
    case 1:
        session_unset();
        session_destroy();
        header("location:index.html");
        break;

    case 2:
        session_unset();
        session_destroy();
        header("location:index.html");
        break;

    case 3:
        session_unset();
        session_destroy();
        header("location:loginAlumno.html");
        break;
    
    default:
        session_unset();
        session_destroy();
        header("location:index.html");
        break;
}
