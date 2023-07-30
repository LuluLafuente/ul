// DECLARANDO LAS VARIABLES
let fecha = new Date();
let fechaDia = fecha.getDate();
let fechaMes = fecha.getMonth();
let fechaAnio = fecha.getFullYear();
let fechaHora = fecha.getHours().toString()<10? 0 + fecha.getHours().toString() : fecha.getHours().toString();
let fechaMinuto = fecha.getMinutes().toString()<10? 0 + fecha.getMinutes().toString() : fecha.getMinutes().toString();
let fechaSegundo = fecha.getSeconds().toString()<10? 0 + fecha.getSeconds().toString() : fecha.getSeconds().toString();
let fechaCompleta = `${fechaDia}/${fechaMes + 1}/${fechaAnio} - ${fechaHora}:${fechaMinuto}:${fechaSegundo}`;
let vigencia = 30;
let constancias = ["Alumno Regular", "Examen", "Materias Aprobadas"];
let interesadoDefault = "quien corresponda";
let observacionesDefault = "-.";

// MENSAJE DE PRUEBA
//console.log("Hola");

// RECUPERANDO LOS ELEMENTOS CONTENEDORES
let contFechaDia = document.getElementById("fdh-dia");
let contFechaMes = document.getElementById("fdh-mes");
let contFechaAnio = document.getElementById("fdh-anio");
let contVigencia = document.getElementById("dias-vigencia");
let contFechaCompleta = document.getElementById("fecha-completa");
let interesadoCampo = document.getElementById("interesado-campo");
let interesado = document.getElementById("interesado");
let observacionesCampo = document.getElementById("observaciones-campo");
let observaciones = document.getElementById("observaciones");
let nroCopias = document.getElementById("cant-copias");
let certificadoTitulo = document.getElementById("certificado-titulo");

// AGREGAR LOS RADIO EN LOS CONTENEDORES
interesadoCampo.onkeydown = agregarInteresado;
interesadoCampo.onkeyup = agregarInteresado;
observacionesCampo.onkeydown = agregarObservaciones;
observacionesCampo.onkeyup = agregarObservaciones;

interesado.innerHTML = interesadoDefault;
observaciones.innerHTML = observacionesDefault;

/*
<input type="radio" name="alumno-constancia" id="alumno-regular" value="Alumno Regular">
    <label for="alumno-regular">Alumno Regular</label>
</div>
<div>
    <input type="radio" name="alumno-constancia" id="alumno-examen" value="alumnoExamen">
    <label for="alumno-examen">Examen</label>
</div>
<div>
    <input type="radio" name="alumno-constancia" id="alumno-aprobadas" value="alumnoAprobadas">
*/

// ASIGNANDO LAS FECHAS A LOS ELEMENTOS
contFechaDia.innerHTML = fechaDia;
contFechaMes.innerHTML = fechaMes;
contFechaAnio.innerHTML = fechaAnio;
contFechaCompleta.innerHTML = fechaCompleta.toString();

// ASIGNO LA VIGENCIA DEL CERTIFICADO
contVigencia.innerHTML = vigencia;

// FUNCIONES DE CAMPOS
function agregarInteresado(){
    if(interesadoCampo.value === ""){
        interesado.innerHTML = interesadoDefault;
    }
    else if(interesadoCampo.value.length === 0){
        interesado.innerHTML = interesadoDefault;
    }
    else{
        interesado.innerHTML = interesadoCampo.value;
    }
}

function agregarObservaciones(){
    if(observacionesCampo.value === ""){
        observaciones.innerHTML = observacionesDefault;
    }
    else if(observacionesCampo.value.length === 0){
        observaciones.innerHTML = observacionesDefault;
    }
    else{
        observaciones.innerHTML = observacionesCampo.value + ".<br>";
    }
}