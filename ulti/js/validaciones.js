// DECLARACION DE VARIABLES
let campos = [];

// ASIGNACION DE VARIABLES
campos[0] = document.getElementById("nombre");
campos[1] = document.getElementById("usuario");
campos[2] = document.getElementById("domicilio");
campos[3] = document.getElementById("nro_domicilio");
campos[4] = document.getElementById("apellido");
campos[5] = document.getElementById("dni");
campos[6] = document.getElementById("celular");
campos[7] = document.getElementById("anio");
campos[8] = document.getElementById("rd_face");
campos[9] = document.getElementById("rd_insta");
campos[10] = document.getElementById("rd_twitter");
campos[11] = document.getElementById("rol");
campos[12] = document.getElementById("legajo");
campos[13] = document.getElementById("carrera");

// BOTONES
let btn_1 = document.getElementById("btn-crear-perfil");

// BOTONES APRETADOS
btn_1.onclick = valFormulario;

// FUNCIONES
// FUNCIÓN QUE VALIDA LOS DATOS ENVIADOS POR EL USUARIO
function valFormulario(){
    let mensaje = "";
    
    /*
    console.log(campos[1].value);
    console.log(campos[0].value);
    console.log(campos[4].value);
    console.log(campos[2].value);
    console.log(campos[3].value);
    console.log(campos[5].value);
    console.log(campos[6].value);
    console.log(campos[7].value);
    console.log(campos[8].value);
    console.log(campos[9].value);
    console.log(campos[10].value);
    console.log(campos[11].value);
    console.log(campos[12].value);
    console.log(campos[13].value);
    */

    console.log(valLetras(campos[0].value));
    console.log(valLetras(campos[2].value));
    console.log(valLetras(campos[4].value));
    console.log(valEntero(campos[3].value));
    console.log(valEntero(campos[5].value));
    console.log(valEntero(campos[6].value));
    console.log(valEntero(campos[7].value));
    console.log(valCarrera(campos[13].value));

    // VALIDANDO LOS CAMPOS
    mensaje += valLetras(campos[0].value, "Nombre: ");
    mensaje += valLetras(campos[4].value, "Apellido: ");
    mensaje += valLetras(campos[2].value, "Domicilio: ");
    mensaje += valEntero(campos[3].value, "Número de domicilio: ");
    mensaje += valEntero(campos[5].value, "DNI: ");
    mensaje += valEntero(campos[6].value, "Celular: ");
    mensaje += valEntero(campos[7].value, "Año: ");
    mensaje += valCarrera(campos[13].value, "Carrera: ");
    // USUARIO (MAIL)
    // RED FACE
    // RED INSTA
    // RED TWITTER

    // SI HAY ERRORES SE LOS PRESENTA AL USUARIO
    if(mensaje !== ""){
        alert("Revise los siguientes errores:\n" + mensaje);

        // DESACTIVA EL ENVIO A LA SIGUIENTE PAGINA DEL BOTON ENVIAR
        btn_1.addEventListener("click", evitarDefault, false);
    }
    else{
        // REACTIVA EL ENVIO A LA SIGUIENTE PAGINA DEL BOTON ENVIAR
        btn_1.removeEventListener("click", evitarDefault, true);
    }
}

// FUNCION QUE DESACTIVA EL ENVIO DE INFORMACIÓN NO FILTRADA
function evitarDefault(event){
    event.preventDefault();
}

// FUNCION QUE VALIDA LOS NÚMEROS DE LOS CAMPOS
// NÚMERO DE DOMICILIO, DNI, CELULAR, AÑO DE INGRESO
function valEntero(numero, campo){
    let entero;
    let mensaje = "";

    try {
        entero = parseInt(numero);
    } catch (error) {
        mensaje = campo + "Los datos ingresados no son números.\n"
    }

    if(Number.isInteger(entero)){
        mensaje = "";
    }
    else{
        mensaje = campo +  "Los datos ingresados no son números.\n";
    }
    
    return mensaje;
}

// FUNCIÓN QUE VALIDA LOS TEXTOS DE LOS CAMPOS
// NOMBRE, APELLIDO, DOMICILIO
function valLetras(dato, campo){
    let mensaje = "";
    let regex = /^[A-Za-zÑñÁáÉéÍíÓóÚúÜü ]{1,50}$/;

    let match = regex.exec(dato);

    if(match !== null){
        mensaje = "";
    }
    else{
        mensaje = campo + "Revise los datos ingresados, deben contener letras solamente.\n";
    }

    return mensaje;
}

// FUNCIÓN QUE VALIDA EL MAIL INGRESADO
function valMail(dato, campo){
    let mensaje = "";

    return mensaje;
}

// FUNCION QUE VALIDA LAS PÁGINAS DE REDES INGRESADAS
function valRedes(dato, campo){
    let mensaje = "";

    return mensaje;
}

// FUNCION QUE VALIDA LA CARRERA ELEGIDA
function valCarrera(car, campo){
    let mensaje = "";
    let nroCarrera = parseInt(car);
    let maxCarreras = 5;

    if(nroCarrera == 0){
        mensaje = campo + "Debe elejir una carrera.\n";
    }
    else if(nroCarrera > maxCarreras){
        mensaje = campo + `Debe elejir una carrera entre las ${maxCarreras - 1} disponibles.\n`;
    }
    else{
        mensaje = "";
    }

    return mensaje;
}
