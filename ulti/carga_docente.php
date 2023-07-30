<?php

  // INICIO SESION
  session_start();

  // AGREGO LAS FUNCIONES NECESARIAS PARA EL FUNCIONAMIENTO DE LA CARGA DE DOCENTES
  include 'bd_conexion.php';
  include 'bd_select.php';
  include 'bd_insert.php';
  include_once 'constantes.php';
  include_once 'inscripcion_funciones.php';

  // GENERO LA CONEXIÓN CON LA BD
  $conexion = conexionDB();

  // REVISO QUE HAYA UNA SESION ACTIVA DE USUARIO,
  // DE LO CONTRARIO VUELVE A LA PAGINA DE INICIO.
  if(!isset($_SESSION["user"])){
    //header("location:index.html");
    //echo "Verdadero </br>";
  }

  // VARIABLES NECESARIAS
  $errores = "";
  $archivoSubido = false;
  $archivoValido = false;
  $archivoExtension = "";
  $archivoNombre = "";
  $archivoCarpeta = CARPETA;
  $archivoDirectorio = __DIR__;
  $archivoGuardar = "";
  $archivoError = "";

  /***************************************************************************************/
  // INICIO DE VALIDACIONES DEL FORMULARIO
  /***************************************************************************************/
  // VALIDACION DE NOMBRE
  if(conDatos($_POST['nombre'])){
    $nombre = sanitizarString($_POST['nombre']);
  }
  else{
    $errores .= "<p>Por favor ingrese un nombre válido.</p>";
  }

  // VALIDACION DE APELLIDO
  if(conDatos($_POST['apellido'])){
    $apellido = sanitizarString($_POST['apellido']);
  }
  else{
    $errores .= "<p>Por favor ingrese un apellido válido.</p>";
  }

  // VALIDACION DE DOMICILIO
  if(conDatos($_POST['domicilio'])){
    $domicilio = sanitizarString($_POST['domicilio']);
  }
  else{
    $errores .= "<p>Por favor ingrese un domicilio válido.</p>";
  }

  // VALIDACION DE NÚMERO DE DOMICILIO
  if(conDatos($_POST['nro_domicilio'])){
    $nro_domicilio = sanitizarInt($_POST['nro_domicilio']);
  }
  else{
    $errores .= "<p>Por favor ingrese un número de domicilio válido.</p>";
  }

  // VALIDACION DE DNI
  if(conDatos($_POST['dni'])){
    $dni = sanitizarInt($_POST['dni']);
  }
  else{
    $errores .= "<p>Por favor ingrese un número de DNI válido.</p>";
  }

  // VALIDACION DE CELULAR
  if(conDatos($_POST['celular'])){
    $celular = sanitizarInt($_POST['celular']);
  }
  else{
    $errores .= "<p>Por favor ingrese un número de Celular válido.</p>";
  }

  // VALIDACION DE USUARIO
  if(conDatos($_POST['usuario'])){
    if(valMail(sanitizarString($_POST['usuario']))){
      $usuario = sanitizarString($_POST['usuario']);
    }
    else{
      $errores .= "<p>Por favor ingrese un mail válido.</p>";  
    }
  }
  else{
    $errores .= "<p>Por favor ingrese un mail.</p>";
  }

  // ASIGNACION DE ROL
  $rol = $_SESSION['viene_de'];

  // ASIGNACION DE CONTRASEÑA
  $contrasenia = $dni;

  // ASIGNACION DE CARRERA
  if(isset($_POST['carrera'])){
    $carrera = sanitizarInt($_POST["carrera"]);
  }
  else{
    $errores .= "<p>Por favor elija una de las carreras listadas.</p>";
  }

  // VALIDACION DE AÑO DE INGRESO
  if(conDatos($_POST['anio'])){
    $anio = sanitizarInt($_POST['anio']);
  }
  else{
    $errores .= "<p>Por favor ingrese un número de año válido.</p>";
  }

  // ASIGNACION DE LEGAJO
  if($errores === ""){
    $legajo = legajoFinal($conexion, $carrera, $anio, $rol, ROL_DOCENTE);
  }

  // VALIDACION DE REDES
  /*
    Las validaciones de redes, solamente revisan que el formato
    de la url sea el valido, es decir, no revisa si la página
    señalada, esta disponible o no.
  */
  // VALIDACION DE FACEBOOK
  if(conDatos($_POST['rd_face'])){
    if(valUrl($_POST['rd_face'])){
      $rd_face = $_POST['rd_face'];
    }
    else{
      $errores .= "<p>Por favor ingrese una url de Facebook válida.</p>";  
    }
  }
  else{
    $errores .= "<p>Por favor ingrese una url de Facebook.</p>";
  }

  // VALIDACION DE INSTAGRAM
  if(conDatos($_POST['rd_insta'])){
    if(valUrl($_POST['rd_insta'])){
      $rd_insta = $_POST['rd_insta'];
    }
    else{
      $errores .= "<p>Por favor ingrese una url de Instagram válida.</p>";  
    }
  }
  else{
    $errores .= "<p>Por favor ingrese una url de Instagram.</p>";
  }

  //USAR ESTA FUNCION PARA MOSTRAR LA URL DESPUES DE BUSCARLA EN LA BD htmlspecialchars($_POST['redes'], ENT_QUOTES, 'UTF-8');

  // VALIDACION DE TWITTER
  if(conDatos($_POST['rd_twitter'])){
    if(valUrl($_POST['rd_twitter'])){
      $rd_twitter = $_POST['rd_twitter'];
    }
    else{
      $errores .= "<p>Por favor ingrese una url de Twitter válida.</p>";  
    }
  }
  else{
    $errores .= "<p>Por favor ingrese una url de Twitter.</p>";
  }

  // ASIGNACION DE FECHA DE INSCRIPCION
  $inscripcionFecha = date('Y-m-d H:i:s');

  // VALIDO QUE HAYA UNA IMAGEN SUBIDA
  $archivoError = imgValSubida($_FILES["foto"]["error"]);

  if($archivoError === "0"){
    $foto = $_FILES["foto"];
    $archivoSubido = true;
    $archivoValido = imgValTipoPermitido(imgExtension($foto));
  }
  else if($archivoError === "4"){
    $foto = IMAGEN_DE_PERFIL;
    $archivoSubido = false;
    $archivoValido = true;
  }
  else{
    $errores = $archivoError;
    $archivoSubido = false;
    $archivoValido = false;
  }

  // VALIDO QUE HAYA UN ARCHIVO Y QUE SU EXTENSIÓN SEA VÁLIDA
  if($archivoSubido && $archivoValido){
    $archivoNombre = imgNombre($legajo, imgExtension($foto));
    $archivoGuardar = imgRutaGuardar($archivoDirectorio, $archivoCarpeta, $archivoNombre);
  }
  else if(!$archivoSubido && $archivoValido){
    $archivoNombre = imgNombre($legajo, $foto);
    $archivoGuardar = imgRutaGuardar($archivoDirectorio, $archivoCarpeta, $archivoNombre);
  }
  else{
    $errores .= "<p>No es una imagen válida.</p>";
    $errores .= "<p>La imagen de perfil debe tener alguno de los tipos permitidos: " .
               ".jpg; .jpeg; .jpe; .png; .gif; .bmp;</p>";
  }

  // MUESTRO ALGUN ERROR QUE PUEDA HABER OCURRIDO
  //echo "Errores: </br>" . $errores . "</br>";

  /***************************************************************************************/
  // FIN DE VALIDACIONES DEL FORMULARIO RECIBIDO
  /***************************************************************************************/

  /***************************************************************************************/
  // INICIO DE REVISIONES DE DATOS DEL NUEVO DOCENTE CON DOCENTES YA REGISTRADOS
  /***************************************************************************************/

  //BUSCO EL DNI EN LA BD

  /*
  //CREAR FUNCION PARA SELECCIONAR LOS DOCENTES INSCRIPTOS
  $dniBD = selectDniAlumnosInscriptos($conexion, $dni);
  $carreraBD = selectCarreraAlumnosInscriptos($conexion, $dni);
  */

  $resultadoCarrera = $carreraBD->fetchAll();
  $yaInscripto = false;

  // ESTE BUCLE REVISA EN SI EL DOCENTE SE INSCRIBIO EN ALGUNA CARRERA
  for ($i=0; $i < count($resultadoCarrera); $i++) { 
    $resultadoCarrera[$i]["carrera"] == $carrera ? $yaInscripto = true : "";
  }

  if($dniBD == $dni && $yaInscripto === true){
    $errores .= "<p>Ya existe un docente en la carrera con el DNI ingresado.</p>";
    $errores .= "<p>DNI: $dni.</p>";
    $errores .= "<p>Por favor revise los datos ingresados e intente nuevamente.</p>";
  }
  
  /***************************************************************************************/
  // FIN DE REVISIONES DE DATOS DEL NUEVO DOCENTE CON DOCENTES YA REGISTRADOS
  /***************************************************************************************/

  /***************************************************************************************/
  // INICIO DE GUARDADO EN BASE DE DATOS
  /***************************************************************************************/

  if($errores === ""){
    // ENVIO LOS DATOS A LA BD
    //CREAR FUNCION DE AGRERGAR DOCENTE EN BD
    /*
    $insert = agregarAlumno(
      $conexion, $legajo, $dni, $nombre, $apellido, 
      $rol, $usuario, $contrasenia, $domicilio, $nro_domicilio, 
      $celular, $anio, $carrera, $rd_face, $rd_insta, $rd_twitter, $archivoGuardar, $inscripcionFecha);
    */
  
    if(is_bool($insert)){
      $_SESSION['docente_inscripto'] = "<script>alert('El docente no fue inscripto, revise los datos ingresados')</script>";
    }
  
    if(is_int($insert)){
      $_SESSION['docente_inscripto'] = "<script>alert('El docente fue inscripto satisfactoriamente inscripto')</script>";

      // LIBRERO EL CURSOR ASOCIADO
      $insert->closeCursor();

       // GUARDO LA IMAGEN EN EL SERVIDOR
      if($archivoGuardar !== "" && $archivoSubido && $archivoValido){
        $fueCopiado = imgSubir($foto['tmp_name'], $archivoGuardar);
      }
    }
    
    echo "True";

    // REDIRIJO NUEVAMENTE AL FORMULARIO
    header("location:inscripcion_docente.php");
  }
  else{
    // ASIGNO LOS ERRORES PARA SER MOSTRADOS EN LA PAGINA DE INSCRIPCION
    $_SESSION['errores'] = $errores;

    // REDIRIJO NUEVAMENTE AL FORMULARIO
    header("location:inscripcion_docente.php");
  }

  /***************************************************************************************/
  // FIN DE GUARDADO EN BASE DE DATOS
  /***************************************************************************************/
  
  // ZONA DE PRUEBAS INICIO

  /*
  echo "Nombre: " . $nombre . ".</br>";
  echo "Apellido: " . $apellido . ".</br>";
  echo "Usuario: " . $usuario . ".</br>";
  echo "Contraseña: " . $contrasenia . ".</br>";
  echo "Domicilio: " . $domicilio . ".</br>";
  echo "Número de domicilio: " . $nro_domicilio . ".</br>";
  echo "Rol: " . $rol . ".</br>";
  echo "Dni: " . $dni . ".</br>";
  echo "Celular: " . $celular . ".</br>";
  echo "Legajo: " . $legajo . ".</br>";
  echo "Carrera: " . $carrera . ".</br>";
  echo "Año: " . $anio . ".</br>";
  echo "Facebook: " . $rd_face . ".</br>";
  echo "Instagram: " . $rd_insta . ".</br>";
  echo "Twitter: " . $rd_twitter . ".</br>";
  */

  // ZONA DE PRUEBAS FIN
