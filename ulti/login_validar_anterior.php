<?php 
// INICIO DE SESION
session_start();

// INCLUSIONES NECESARIAS PARA FUNCIONAMIENTO
include('bd_conexion.php');
include('bd_select.php');
include('constantes.php');

// VARIABLES NECESARIAS
$encontrado = false;

// RECUPERO DATOS DEL FORMULARIO
$usuario = $_POST["usuario"];
$clave = $_POST["clave"];

// ASIGNO EL USUARIO A VARIABLE DE SESION
$_SESSION['usuario'] = $usuario;

// VALOR POR DEFECTO DEL ROL
$rol = 0;

// GENERO LA CONEXIÓN CON LA BD
$conexion = conexionDB();

// REALIZO LA CONSULTA CON LA BD
$consulta = selectRolAdm($conexion, $usuario);

// COMPARO LOS DATOS RECIBIDOS
if($consulta === false || $consulta->rowCount() === 0){
    $consulta = selectRolAlu($conexion, $usuario);
    
    $resultado = $consulta->fetchAll();

    $rol = $resultado[0]["rol_alumno"];
}
else{
    $resultado = $consulta->fetchAll();

    $rol = $resultado[0]["rol_administrativo"];
}

// SEGUN LOS DATOS RECIBIDOS, REDIRECCIONA AL USUARIO CORESPONDIENTE
switch($rol){
    //REDIRECCION A ADMINISTRATIVO
    case 1:
        try {
            $consulta = selectAdministrativo($conexion, $usuario, $clave);

            $resultado = $consulta->fetchAll();

            $_SESSION["u_nombre"] = $resultado[0]["NOMBRE"];
            $_SESSION["u_apellido"] = $resultado[0]["APELLIDO"];
            $_SESSION["u_legajo"] = $resultado[0]["LEGAJO_ADM"];
            $_SESSION["u_dni"] = $resultado[0]["DNI"];
            $_SESSION["u_rol"] = $resultado[0]["ROL_ADMINISTRATIVO"];
            $_SESSION["u_carrera"] = $resultado[0]["CARRERA"];

            header("location:portalAdministrador.php");
        } catch (Throwable $th) {
            echo "<h1>Error al cargar datos del empleado/a.</h1>" . $th;    
        }
        break;
    //REDIRECCION A EMPLEADO
    case 2:
        try {
            $consulta = selectEmpleado($conexion, $usuario, $clave);

            $resultado = $consulta->fetchAll();

            $_SESSION["u_nombre"] = $resultado[0]["NOMBRE"];
            $_SESSION["u_apellido"] = $resultado[0]["APELLIDO"];
            $_SESSION["u_legajo"] = $resultado[0]["LEGAJO_DOC"];
            $_SESSION["u_dni"] = $resultado[0]["DNI"];
            $_SESSION["u_rol"] = $resultado[0]["ROL_DOCENTE"];
            $_SESSION["u_carrera"] = $resultado[0]["CARRERA"];

            header("location:portalDocente.php");
        } catch (Throwable $th) {
            echo "<h1>Error al cargar datos del empleado/a.</h1>" . $th;    
        }
        break;
    //REDIRECCION A ALUMNO
    case 3:
        try {
            $consulta = selectAlumno($conexion, $usuario, $clave);
    
            $resultado = $consulta->fetchAll();

            $_SESSION["u_nombre"] = $resultado[0]["NOMBRE"];
            $_SESSION["u_apellido"] = $resultado[0]["APELLIDO"];
            $_SESSION["u_legajo"] = $resultado[0]["LEGAJO_ALU"];
            $_SESSION["u_dni"] = $resultado[0]["DNI"];
            $_SESSION["u_rol"] = $resultado[0]["ROL_ALUMNO"];
            $_SESSION["u_carrera"] = $resultado[0]["CARRERA"];
            $_SESSION["u_anio"] = $resultado[0]["ANIO"];

            header("location:portalAlumno.php");
        } catch (Throwable $th) {
            echo "<h1>Error al cargar datos del alumno/a.</h1>" . $th;
        }
        break;
    default:
        echo "<h1>Ocurrio algún error, contactese con el establecimiento para solucionarlo.</h1>";
        break;
}

function esBooleano($consultaSQL){
    return $consultaSQL === false ? true : false;
}

function tieneResultados($consultaSQL){
    return $consultaSQL->rowCount() === 0 ? false : true;
}

function asignarRol($consultaSQL, $rolPersona){
    $resultado = $consultaSQL->fetchAll();
    
    return $resultado[0][$rolPersona];
}

function valConsulta($consultaSQL, $rolPersona, $persona){

    if(esBooleano($consultaSQL)){
        echo "La consulta no es valida! </br>";
        
        $encontrado = false;
    }
    else if(tieneResultados($consultaSQL)){
        echo "Se encontró el $persona! </br>";
    
        $consultaValida = asignarRol($consultaSQL, $rolPersona);
    
        $encontrado = true;
    
    }
    else{
        echo "No se encontró el $persona!</br>";
    
        $encontrado = false;
    }

    return $consultaValida;
}

// INICIO DE SECCION DE PRUEBAS
/*
if($consulta->rowCount()){

    try {
        $_SESSION["u_nombre"] = $resultado[0]["nombre"];
        $_SESSION["u_apellido"] = $resultado[0]["apellido"];
        $_SESSION["u_legajo"] = $resultado[0]["legajo_emp"];
        $_SESSION["u_dni"] = $resultado[0]["dni"];
        $_SESSION["u_rol"] = $resultado[0]["rol_empleado"];
        $_SESSION["u_carrera"] = $resultado[0]["carrera"];

        header("location:portalAdministrador.html");
    } catch (Throwable $th) {
        echo "<h1>Error al cargar datos del empleado/a.</h1>" . $th;    
    }
}
else{
    $consulta = selectAlumno($conexion, $usuario, $clave);
    
    $resultado = $consulta->fetchAll();

    if ($consulta->rowCount()) {
        try {
            $_SESSION["u_nombre"] = $resultado[0]["nombre"];
            $_SESSION["u_apellido"] = $resultado[0]["apellido"];
            $_SESSION["u_legajo"] = $resultado[0]["legajo_alu"];
            $_SESSION["u_dni"] = $resultado[0]["dni"];
            $_SESSION["u_rol"] = $resultado[0]["rol_alumno"];
            $_SESSION["u_carrera"] = $resultado[0]["carrera"];
            $_SESSION["u_anio"] = $resultado[0]["anio"];

            header("location:portalAlumno.php");
        } catch (Throwable $th) {
            echo "<h1>Error al cargar datos del alumno/a.</h1>" . $th;
        }
    }
    else{
        echo "<h1>Error de autentificacion</h1>";
    }
}
*/

// FIN DE SECCION DE PRUEBAS

//Cierro el cursor utilizado para la consulta
$consulta->closeCursor();