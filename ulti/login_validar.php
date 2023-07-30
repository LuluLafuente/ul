<?php 
// INICIO DE SESION
session_start();

// INCLUSIONES NECESARIAS PARA FUNCIONAMIENTO
include('bd_conexion.php');
include('bd_select.php');
include('constantes.php');

// VARIABLES NECESARIAS
$encontrado = false;
$rol = 0;

// RECUPERO DATOS DEL FORMULARIO
$usuario = $_POST["usuario"];
$clave = $_POST["clave"];

// ASIGNO EL USUARIO A VARIABLE DE SESION
$_SESSION['usuario'] = $usuario;

// GENERO LA CONEXIÓN CON LA BD
$conexion = conexionDB();

// REALIZO LA CONSULTA CON LA BD
// BUSCO EL ALUMNO
if($rol == 0){
    $consulta = selectRolAlu($conexion, $usuario);
    
    $rol = valConsulta($consulta, ROL_BD_ALUMNO, ROL_PERS_ALUMNO);
}

// BUSCO EL DOCENTE
if($rol == 0){
    $consulta = selectRolDoc($conexion, $usuario);

    $rol = valConsulta($consulta, ROL_BD_DOCENTE, ROL_PERS_DOCENTE);
}

// BUSCO EL ADMINISTRATIVO
if($rol == 0){
    $consulta = selectRolAdm($conexion, $usuario);

    $rol = valConsulta($consulta, ROL_BD_ADMINISTRATIVO, ROL_PERS_ADMINISTRATIVO);
}

// SEGUN LOS DATOS RECIBIDOS, REDIRECCIONA AL USUARIO CORESPONDIENTE
switch($rol){
    //REDIRECCION A ADMINISTRATIVO
    case 1:
        try {
            // COMPRUEBO QUE LOS DATOS DE ACCESO SEAN CORRECTOS
            $consulta = selectAdministrativo($conexion, $usuario, $clave);
            
            // BUSCO LOS RESULTADOS
            $resultado = $consulta->fetchAll();

            // ASIGNO LAS VARIABLES DE SESION NECESARIAS
            $_SESSION["u_nombre"] = $resultado[0]["NOMBRE"];
            $_SESSION["u_apellido"] = $resultado[0]["APELLIDO"];
            $_SESSION["u_legajo"] = $resultado[0]["LEGAJO_ADM"];
            $_SESSION["u_dni"] = $resultado[0]["DNI"];
            $_SESSION["u_rol"] = $resultado[0]["ROL_ADMINISTRATIVO"];
            $_SESSION["u_foto"] = $resultado[0]["FOTO_ADM"];

            // CIERRO EL CURSOR UTILIZADO PARA LA CONSULTA
            finalizarConsulta($consulta);

            header("location:portalAdministrador.php");
        } catch (Throwable $th) {
            echo "<h1>Error al cargar datos del empleado/a.</h1>";
            echo "</br>";
            echo $th;
        }
        break;
    //REDIRECCION A EMPLEADO
    case 2:
        try {
            // COMPRUEBO QUE LOS DATOS DE ACCESO SEAN CORRECTOS
            $consulta = selectEmpleado($conexion, $usuario, $clave);

            // BUSCO LOS RESULTADOS
            $resultado = $consulta->fetchAll();

            // ASIGNO LAS VARIABLES DE SESION NECESARIAS
            $_SESSION["u_nombre"] = $resultado[0]["NOMBRE"];
            $_SESSION["u_apellido"] = $resultado[0]["APELLIDO"];
            $_SESSION["u_legajo"] = $resultado[0]["LEGAJO_DOC"];
            $_SESSION["u_dni"] = $resultado[0]["DNI"];
            $_SESSION["u_rol"] = $resultado[0]["ROL_DOCENTE"];
            $_SESSION["u_carrera"] = $resultado[0]["CARRERA"];
            $_SESSION["u_foto"] = $resultado[0]["FOTO_DOC"];

            // CIERRO EL CURSOR UTILIZADO PARA LA CONSULTA
            finalizarConsulta($consulta);

            header("location:portalDocente.php");
        } catch (Throwable $th) {
            echo "<h1>Error al cargar datos del empleado/a.</h1>";
            echo "</br>";
            echo $th;
        }
        break;
    //REDIRECCION A ALUMNO
    case 3:
        try {
            // COMPRUEBO QUE LOS DATOS DE ACCESO SEAN CORRECTOS
            $consulta = selectAlumno($conexion, $usuario, $clave);
    
            // BUSCO LOS RESULTADOS
            $resultado = $consulta->fetchAll();

            // ASIGNO LAS VARIABLES DE SESION NECESARIAS
            $_SESSION["u_nombre"] = $resultado[0]["NOMBRE"];
            $_SESSION["u_apellido"] = $resultado[0]["APELLIDO"];
            $_SESSION["u_legajo"] = $resultado[0]["LEGAJO_ALU"];
            $_SESSION["u_dni"] = $resultado[0]["DNI"];
            $_SESSION["u_rol"] = $resultado[0]["ROL_ALUMNO"];
            $_SESSION["u_carrera"] = $resultado[0]["CARRERA"];
            $_SESSION["u_anio"] = $resultado[0]["ANIO"];
            $_SESSION["u_foto"] = $resultado[0]["FOTO_ALU"];

            // CIERRO EL CURSOR UTILIZADO PARA LA CONSULTA
            finalizarConsulta($consulta);

            header("location:portalAlumno.php");
        } catch (Throwable $th) {
            echo "<h1>Error al cargar datos del alumno/a.</h1>";
            echo "</br>";
            echo $th;
        }
        break;
    // MUESTRA UN MENSAJE GENERICO DE ERROR
    default:
        echo "<h1>Ocurrio algún error, contactese con el establecimiento para solucionarlo y recuperar su acceso.</h1>";
        break;
}

// INICIO DE FUNCIONES
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
        //echo "La consulta no es valida! </br>";
        
        $consultaValida = 0;
    }
    else if(tieneResultados($consultaSQL)){
        //echo "Se encontró el $persona! </br>";
    
        $consultaValida = asignarRol($consultaSQL, $rolPersona);
    
        $encontrado = true;
    
    }
    else{
        //echo "No se encontró el $persona!</br>";
    
        $consultaValida = 0;
    }

    return $consultaValida;
}

function finalizarConsulta($consultaSQL){
    $consultaSQL->closeCursor();
}

// INICIO DE SECCION DE PRUEBAS



// FIN DE SECCION DE PRUEBAS