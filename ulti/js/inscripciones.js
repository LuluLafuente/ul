// DECLARANDO LAS VARIABLES
let fecha = new Date();
let fechaDia = fecha.getDate();
let fechaMes = fecha.getMonth();
let fechaAnio = fecha.getFullYear();

// RECUPERANDO LOS ELEMENTOS CONTENEDORES
let rol = document.getElementById("rol");
let carrera = document.getElementById("carrera");
let anio = document.getElementById("anio");
let legajo = document.getElementById("legajo");

// AGREGAR LAS FUNCIONES A LOS CONTENEDORES
anio.onblur = legajoFinal;
carrera.onchange = legajoFinal;

// FUNCIONES DE CAMPOS
// LA FUNCION ASIGNA EL LEGAJO TENTATIVO DEL ALUMNO
function legajoFinal(){
    legajo.value = legajoCarrera() + "-" + legajoAnio() + "-" + legajoNro() + "-" + legajoRol();
}

// LA FUNCION ASIGNA LA FECHA DE INSCRIPCION
function legajoAnio(){
    let asignarAnio = 0;

    if(anio.value === ""){
        asignarAnio = 0;
    }
    else if(anio.value >= 2000 && anio.value <= 3000){
        asignarAnio = anio.value - 2000;
    }
    else{
        asignarAnio = fechaAnio - 2000;
    }

    return asignarAnio;
}

// LA FUNCION ASIGNA LA ABREVIATURA DE LA CARRERA
function legajoCarrera(){
    let asignarCarrera = 0;
    let nroCarrera = parseInt(carrera.value);

    switch (nroCarrera) {
        case 1:
            asignarCarrera = "TSDS";
            break;

        case 2:
            asignarCarrera = "TSB";
            break;

        case 3:
            asignarCarrera = "TSGA";
            break;

        case 4:
            asignarCarrera = "TSARI";
            break;
    
        default:
            if(carrera == 0)
                alert("Debe elejir una carrera");
            break;
    }

    return asignarCarrera;
}

function legajoNro(){
    return "002";
}

// LA FUNCION ASIGNA EL ROL PARA EL LEJAJO
function legajoRol(){
    let asignarRol = "";

    switch (rol.value) {
        case "Alumno":
            asignarRol = "AL";
            break;

        case "Administrativo":
            asignarRol = "AD";
            break;

        case "Docente":
            asignarRol = "DC";
            break;
    
        default:
            break;
    }

    return asignarRol;
}