let arrayNameOption= ["Selecciona","Numeric","Text"];
let arrayValueOption= ["sel","numeric","text"];
let arrayNameButton= ["Cancelar", "Confirmar"]
let arrayIdButton= ["cancelar", "confirm"]
let arrayTextListQuestion= ["PREGUNTA SOBRE LA VIDA", "PREGUNTA SOBRE LA MUERTE","PREGUNTA SOBRE LA MUSICA","PREGUNTA SOBRE LA TRILOGIA DE CIXIN LIU","PREGUNTA SOBRE LA VIDA", "PREGUNTA SOBRE LA MUERTE","PREGUNTA SOBRE LA MUSICA","PREGUNTA SOBRE LA TRILOGIA DE CIXIN LIU","PREGUNTA SOBRE LA VIDA", "PREGUNTA SOBRE LA MUERTE","PREGUNTA SOBRE LA MUSICA","PREGUNTA SOBRE LA TRILOGIA DE CIXIN LIU","PREGUNTA SOBRE LA VIDA", "PREGUNTA SOBRE LA MUERTE","PREGUNTA SOBRE LA MUSICA","PREGUNTA SOBRE LA TRILOGIA DE CIXIN LIU"]
let arrayTextListPoll= ["ENCUESTA SOBRE COLORES", "ENCUESTA SOBRE EL BICHO"]
let verSelect= false;
let verInput= false;

$(document).ready(function() {
    //creationDashboard("body");
    $(".dash-contenido").removeAttr("style");
    $('#crearPregunta').click(function() {
        createQuestion(".dash-contenido");
    });
  
    $('#crearEncuesta').click(function() {
        createPoll(".dash-contenido")
    });
    
    $('#listarPreguntas').click(function() {
        viewListQuestion(".dash-contenido",arrayTextListQuestion)
    });
    $('#listarEncuestas').click(function() {
        viewListPoll(".dash-contenido");
    });
});
//
function NewError(tipoMensaje,Texto) {
    var error = $(`<div class="${tipoMensaje}"><ul><li>${Texto}</li><span class="closebtn" onclick="this.parentElement.parentElement.style.display='none';">&times;</span></ul></div>`);7
    console.log(error);
    $('#mensajes').append(error);
}

function limpiarPantalla() {
    $("body").children().remove();
}

//CREACION DASHBOARD
function creationDashboard(elementDOM){
    $(elementDOM).empty();
    createElements(elementDOM, "div", "dashboard", true);
    createElements(".dashboard", "nav", "panel", true);
    createElements(".dashboard", "div", "dash-contenido", true);
    createElements2(".panel", "button", "btnPanelAdmin", "crearPregunta", true,"Crear Pregunta")
    createElements2(".panel", "button", "btnPanelAdmin", "crearEncuesta", true, "Crear Enquesta")
    createElements2(".panel", "button", "btnPanelAdmin", "listarPreguntas", true, "Llistat de Preguntes")
    createElements2(".panel", "button", "btnPanelAdmin", "listarEncuestas", true, "Llistat d'Enquestes")
}


//CREAR PREGUNTA
function createQuestion(elementDOM){
    $(elementDOM).empty();
    $(elementDOM).append("<form class='contentRs formQuestion'><p>NOM:</p><input id='nameQuestion'type='text'><p>TIPUS:</p></form>");
    createTypeQuestion(arrayNameOption,arrayValueOption,"form")
    $("form").append("<div id='buttonConfirm'></div>");
    createButtons(arrayNameButton, "#buttonConfirm", arrayIdButton)
    $("#confirm").attr("disabled","true");
    $("#typeQuestion").on('change',selected)
    $("#nameQuestion").on('input',inputName)
}

function createTypeQuestion(nameOption,valueOption,elementDOM){
    $(elementDOM).append("<select id='typeQuestion'></select>")
    let i= 0;
    nameOption.forEach(elem => {
        $("#typeQuestion").append("<option value='"+ valueOption[i] +"'>"+ elem +"</option>");
        i++;
    });
}

function selected(){
    if($(this).val()!='sel'){
        verSelect= true;
    }
    else{
        verSelect= false;
    }
    comprovation()
}

function inputName(){
    let ver= $("#nameQuestion").val().length;
    if(ver!=0){
        verInput= true;
    }
    else{
        verInput= false;
    }
    comprovation()
}

function comprovation(){
    if(verInput== true && verSelect== true){
        $('#confirm').prop("disabled", false);
    }
    else{
        $("#confirm").attr("disabled","true");
    }
}

function createButtons(nameButtons, elementDOM, arrayId){
    let i= 0;
    nameButtons.forEach(element => {
        $(elementDOM).append("<button id='"+ arrayId[i] +"'>" + element + "</button>");
        i++;
    });
}

// CREATE POLL
function createPoll(elementDOM){
    $(elementDOM).empty();
    createElements(elementDOM, "div","contentRs", true);
    createElements(".contentRs", "p","pPoll",true,"EN CONSTRUCCIÓ...");
}

// LLISTAT DE PREGUNTES
function viewListQuestion(elementDOM,arrayTextListQuestion){
    $(elementDOM).empty();
    createElements(elementDOM, "div","contentRs", true);
    let cont= 0;
    arrayTextListQuestion.forEach(element => {
        createElements('.contentRs', "div",`divViewQuestion ${cont}`, true);
        createElements(`.${cont}`, "li","liViewQuestion", true, element);
        cont++;
    });
}
// LLISTAT D'ENQUESTES
function viewListPoll(elementDOM){
    $(elementDOM).empty();
    createElements(elementDOM, "div","contentRs", true);
    let cont= 0;
    arrayTextListPoll.forEach(element => {
        createElements('.contentRs', "div",`divViewPoll ${cont}`, true);
        createElements(`.${cont}`, "li","liViewPoll", true, element);
        cont++;
    });
}

//
function createElements(parent,elementDOM, classes,cierreForzado,text=''){
    if (cierreForzado==true){
        $(parent).append("<"+elementDOM+" class='"+classes+"'>"+text+"</"+elementDOM+">") 
    }
    else{
        $(parent).append("<"+elementDOM+" class="+classes+">") 
    }
}

function createElements2(parent,elementDOM, classes,ids,cierreForzado,text=''){
    if (cierreForzado==true){
        $(parent).append("<"+elementDOM+" id='"+ids+"' class='"+classes+"'>"+text+"</"+elementDOM+">") 
    }
    else{
        $(parent).append("<"+elementDOM+" id='"+ids+"' class="+classes+">") 
    }
}