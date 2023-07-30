<?php
    
    //FUNCION PARA AGREGAR LOS ALUMNOS A LA BASE DE DATOS
    function agregarAlumno(
        $con, $legajo, $dni, $nombre, $apellido, 
        $rol, $usuario, $contrasenia, $domicilio, $celular, 
        $nroDomicilio, $anio, $carrera, $red_fb, $red_ig, $red_tw, $foto, $fecha){

            echo "algo</br>";

        //EJECUTO LA CONSULTA CON LOS DATOS RECIBIDOS
        $alumnoAgregado = $con->query("INSERT INTO `Alumno` (`LEGAJO_ALU`,
                                                             `DNI`,
                                                             `NOMBRE`,
                                                             `APELLIDO`,
                                                             `ROL_ALUMNO`,
                                                             `USUARIO`,
                                                             `CONTRASENIA`,
                                                             `DOMICILIO`,
                                                             `CELULAR`,
                                                             `NRO_DOMICILIO`,
                                                             `ANIO`,
                                                             `CARRERA`,
                                                             `RED_FACEBOOK`,
                                                             `RED_INSTAGRAM`,
                                                             `RED_TWITTER`,
                                                             `FOTO_ALU`,
                                                             `FECHA_INSC`)
                                            VALUES           ('$legajo',
                                                             $dni,
                                                             '$nombre',
                                                             '$apellido',
                                                             $rol,
                                                             '$usuario',
                                                             '$contrasenia',
                                                             '$domicilio',
                                                             $celular,
                                                             $nroDomicilio,
                                                             $anio,
                                                             $carrera,
                                                             '$red_fb',
                                                             '$red_ig',
                                                             '$red_tw',
                                                             '$foto',
                                                             '$fecha');"
                                  );

        //DEVUELVO EL RESULTADO DE LA OPERACION
        return $alumnoAgregado;
    }

    
?>