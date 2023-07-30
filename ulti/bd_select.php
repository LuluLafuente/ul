<?php
    //FUNCION UTILIZADA PARA SELECCIONAR Y COMPARAR SI EL ADMINISTARTIVO EXISTE
    function selectAdministrativo($con, $u, $c){
        $consulta = $con->query("SELECT * 
                                   FROM administrativo 
                                  WHERE usuario = '$u' 
                                    AND contrasenia = '$c';");

        return $consulta;
    }

    //FUNCION UTILIZADA PARA SELECCIONAR Y COMPARAR SI EL EMPLEADO EXISTE
    function selectEmpleado($con, $u, $c){
        $consulta = $con->query("SELECT * 
                                   FROM docente 
                                  WHERE usuario = '$u' 
                                    AND contrasenia = '$c';");

        return $consulta;
    }

    //FUNCION UTILIZADA PARA SELECCIONAR Y COMPARAR SI EL ALUMNO EXISTE
    function selectAlumno($con, $u, $c){
        $consulta = $con->query("SELECT * 
                                   FROM alumno 
                                  WHERE usuario = '$u' 
                                    AND contrasenia = '$c';");

        return $consulta;
    }

    function selectMaterias($con){
        $consulta = $con->query("SELECT Id_Materia,
                                        Anio,
                                        Nombre
                                   FROM Materia;");

        return $consulta;
    }

    function selectAprobadas($con){
        $consulta = $con->query("SELECT *
                                   FROM vw_nota_alumno;");

        return $consulta;
    }

    function selectPlanEstudio($con, $carrera){
        $consulta = $con->query("SELECT *
                                   FROM vw_plan_estudio
                                  WHERE anio = $carrera");

        return $consulta;
        
    }

    function selectRolDoc($con, $mail){
        $consulta = $con->query("SELECT rol_docente
                                   FROM docente
                                  WHERE usuario = '$mail';");

        return $consulta;
    }

    function selectRolAdm($con, $mail){
        $consulta = $con->query("SELECT `rol_administrativo` 
                                   FROM `administrativo` 
                                  WHERE `usuario` = '$mail';");
        
        return $consulta;
    }

    function selectRolAlu($con, $mail){
        $consulta = $con->query("SELECT rol_alumno
                                   FROM alumno
                                  WHERE usuario = '$mail'");

        return $consulta;
    }

    function selectalumnosCursado($con, $idMateria){
        $consulta = $con->query("SELECT *
                                   FROM vw_cursado
                                  WHERE materia = '$idMateria'");

        return $consulta;
    }

    function selectAlumnosTodos($con, $idMateria){
        $consulta = $con->query("SELECT *
                                   FROM vw_cursado
                                  WHERE materia = '$idMateria'");

        return $consulta;
    }

    function selectAlumnosCantInsc($con, $anio){
        $consulta = $con->query("SELECT COUNT(anio)
                                   FROM alumno
                                  WHERE ANIO = $anio;");

        return $consulta;
    }

    function selectCarreraAbreviado($con, $nroCarrera){
        $consulta = $con->query("SELECT abreviado
                                   FROM carrera
                                  WHERE id_carrera = $nroCarrera;");

        $resultado = $consulta->fetchAll();

        return $resultado[0]["abreviado"];
    }

    function selectNroDeAlumnosInscriptos($con, $anio){
        $consulta = $con->query("SELECT COUNT(anio) AS 'anio'
                                   FROM alumno
                                  WHERE anio = $anio;");

        $resultado = $consulta->fetchAll();

        return $resultado[0]["anio"];
    }

    function selectNroDeDocentesInscriptos($con, $anio){
        $cantidad = 0;

        $consulta = $con->query("SELECT cantidad
                                   FROM vw_docentes_inscriptos
                                  WHERE anio = $anio;");

        echo "CANTIDAD: " . $consulta->rowCount() . "</br>";

        if ($consulta->rowCount() === 0) {
            $cantidad = 0;
        }
        else{
            $resultado = $consulta->fetchAll();

            $cantidad = $resultado[0]["fecha_insc"];
        }

        return $cantidad;
    }

    function selectDniAlumnosInscriptos($con, $dni){
        $consulta = $con->query("SELECT dni
                                   FROM alumno
                                  WHERE dni = $dni;");

        $resultado = $consulta->fetchAll();

        return !isset($resultado[0]["dni"]) ? 0 : $resultado[0]["dni"];
    }

    function selectCarreraAlumnosInscriptos($con, $dni){
        $consulta = $con->query("SELECT carrera
                                   FROM alumno
                                  WHERE dni = $dni;");

        return $consulta;
    }

    function selectListaNotas($con){
        $consulta = $con->query("SELECT * FROM vw_vista_cursado");

    return $consulta;
    }
?>