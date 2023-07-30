<?php

  // AGREGO LAS FUNCIONES NECESARIAS PARA EL FUNCIONAMIENTO DE LA CARGA DE ALUMNOS
  include_once 'constantes.php';

  // FUNCIONES PARA SANITIZAR EL FORMULARIO
  // SANITIZAR VARIABLES DEL FORMULARIO
  function sanitizarString($var){
    return filter_var($var, FILTER_SANITIZE_STRING);
  }

  function sanitizarInt($var){
    return filter_var($var, FILTER_SANITIZE_NUMBER_INT);
  }

  function valMail($var){
    return filter_var($var, FILTER_VALIDATE_EMAIL);
  }

  function valUrl($var){
    return filter_var($var, FILTER_SANITIZE_URL);
  }

  function conDatos($var){
    return !empty($var);
  }

  // FUNCIONES PARA LA SUBIDA DE LA FOTO
  // SUBE LA IMAGEN A LA BASE DE DATOS
  function imgSubir($nombreOriginal, $nombreNuevo){
    return move_uploaded_file($nombreOriginal, $nombreNuevo);
  }

  // CREA EL STRING CON LA RUTA PARA GUARDAR LA FOTO
  function imgRutaGuardar($imgDir, $imgCarp, $imgNombre){
    return ".\\\\" . $imgCarp . "\\\\" . $imgNombre;
  }

  // CREA EL STRING CON EL NOMBRE DE LA IMAGEN
  function imgNombre($imgLegajo, $imgExtension){
    return $imgLegajo . "." . $imgExtension;
  }

  function imgExtension($archivo){
    return pathinfo($archivo["name"], PATHINFO_EXTENSION);
  }

  //VALIDA QUE EL TIPO DE IMAGEN SEA EL PERMITIDO
  function imgValTipoPermitido($extensionImg){
    $valido = false;

    switch ($extensionImg) {
      case "jpg":
      case "jpe":
      case "jpeg":
        $valido = true;
        break;

      case "png":
        $valido = true;
        break;

      case "gif":
        $valido = true;
        break;

      case "bmp":
        $valido = true;
        break;
      
      default:
        $valido = false;
        break;
    }

    return $valido;
  }

  // VALIDA EL CODIGO DE ERROR DE LA IMAGEN SUBIDA
  function imgValSubida($archivo){
    $msj = "";

    switch ($archivo) {
      case UPLOAD_ERR_OK:
        $msj = "0";
        break;

      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
        $msj = "El tamaño del archivo, es mayor al permitido, utilice una imagen menor a " . TAMANIO_MAXIMO . "Mb.";
        break;

      case UPLOAD_ERR_PARTIAL:
        $msj = "Ocurrió un error al subir el archivo, intente subirlo nuevamente.";
        break;

      case UPLOAD_ERR_NO_FILE:
        $msj = "4";
        break;

      case UPLOAD_ERR_NO_TMP_DIR:
        $msj = "Hubo un error en el servidor y el archivo no pudo subirse, contacte con el administrador del sistema.";
        break;

      case UPLOAD_ERR_CANT_WRITE:
        $msj = "El archivo no pudo guardarse en el servidor, intente subirlo nuevamente.";
        break;

      case UPLOAD_ERR_EXTENSION:
        $msj = "Hubo un error en el servidor y el archivo no pudo subirse, contacte con el administrador del sistema.";
        break;
      
      default:
        $msj = "Hubo un error en el servidor y el archivo no pudo subirse, contacte con el administrador del sistema.";
        break;
    }

    return $msj;
  }

  // FUNCIONES DEL LEGAJO
  // DETERMINA EL LEGAJO CON SU FORMA FINAL XXXX-00-000-XX
  function legajoFinal($con, $legajoCarrera, $legajoAnio, $legajoRol, $tipo){

    if($legajoAnio === 0 || $legajoAnio === "" || is_null($legajoAnio)){
      $anio = legajoAnio();
    }
    else{
      $anio = $legajoAnio - 2000;
    }


    return "" . legajoCarrera($con, $legajoCarrera) . 
           "-" . $anio . 
           "-" . legajoNro($con, $anio, $tipo) . 
           "-" . legajoRol($legajoRol);
  }

  function legajoAnio(){
    return date('y');
  }

  function legajoNro($con, $anioInscripcion, $tipo){

    switch ($tipo) {
      case 1:
        $inscriptos = selectNroDeCoordinadoresInscriptos($con, $anioInscripcion);
        break;
      case 2:
        $inscriptos = selectNroDeDocentesInscriptos($con, $anioInscripcion);
        break;
      case 3:
        $inscriptos = selectNroDeAlumnosInscriptos($con, $anioInscripcion);
        break;
    }

    if($inscriptos == 0){
      $inscriptos = 1;
    }

    if($inscriptos < 10){
      $inscriptos = "00" . $inscriptos;
    }
    else if($inscriptos < 100){
      $inscriptos = "0" . $inscriptos;
    }

    return $inscriptos;
  }

  function legajoCarrera($con, $car){
    return selectCarreraAbreviado($con, $car);
  }

  function legajoRol($legajoRol){
    $rolAsignado = "";

    switch ($legajoRol) {
      case 1:
        $rolAsignado = "AD";
        break;
        
      case 2:
        $rolAsignado = "DC";
        break;
          
      case 3:
        $rolAsignado = "AL";
        break;
  
      default:
        break;
    }

    return $rolAsignado;
  }
