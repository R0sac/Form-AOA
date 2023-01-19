let arrayNameOption= ["Selecciona","Numeric","Text"];
let arrayValueOption= ["sel","numeric","text"];
let arrayNameButton= ["Cancelar", "Confirmar"];
let arrayIdButton= ["cancelar", "confirm"];
let arrayTypeButton= ['button', 'submit'];
let verSelect= false;
let verInput= false;

$(".dash-contenido").removeAttr("style");
$(document).ready(function(){
    $("#crearPregunta").click(function(){
        createQuestion(".dash-contenido");
        $('#cancelar').click(cancelButton);
        $('#confirm').click(confirmButton);
    });
    $('#crearEncuesta').click(function(){
        createPoll(".dash-contenido")
    });
    $('#listarPreguntas').click(function(){
        viewListQuestion(".dash-contenido",arrayTitolQuestion);
    });
        
    $('#listarEncuestas').click(function(){
        viewListPoll(".dash-contenido")
    });
});

//CREA DASHBOARD
function creationDashboard(elementDOM){
    new limpiarPantalla();
    createElements(elementDOM, "div", "dashboard", true);
    createElements(".dashboard", "nav", "panel", true);
    createElements(".dashboard", "div", "dash-contenido", true);
    createElements2(".panel", "button", "btnPanelAdmin", "crearPregunta", true,"Crear Pregunta");
    createElements2(".panel", "button", "btnPanelAdmin", "crearEncuesta", true, "Crear Enquesta");
    createElements2(".panel", "button", "btnPanelAdmin", "listarPreguntas", true, "Llistat de Preguntes");
    createElements2(".panel", "button", "btnPanelAdmin", "listarEncuestas", true, "Llistat d'Enquestes");
    createQuestion(".dash-contenido");
    $('#cancelar').click(cancelButton);
    $('#confirm').click(confirmButton);
}
function limpiarPantalla() {
    $("body").children().remove();
}

//CREAR PREGUNTA
function createQuestion(elementDOM){
    $(elementDOM).empty();
    $(elementDOM).append("<form class='contentRs formQuestion' method='POST'><p>NOM:</p><input id='nameQuestion' type='text' name='inputName'><p>TIPUS:</p></form>");
    createTypeQuestion(arrayNameOption,arrayValueOption,"form")
    $("form").append("<div id='buttonConfirm'></div>");
    createButtons(arrayNameButton, "#buttonConfirm", arrayIdButton,arrayTypeButton);
    //$("#buttonConfirm").append("<input type='submit'id='confirm' value='Confirmar'>")
    
    $("#confirm").attr("disabled","true");
    $("#typeQuestion").on('change',selected)
    $("#nameQuestion").on('input',inputName)
}

function createTypeQuestion(nameOption,valueOption,elementDOM){
    $(elementDOM).append("<select id='typeQuestion' name='selectType'></select>")
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

function createButtons(nameButtons, elementDOM, arrayId, typeButton){
    let i= 0;
    nameButtons.forEach(element => {
        $(elementDOM).append("<button type='"+typeButton[i]+"' id='"+ arrayId[i] +"'>" + element + "</button>");
        i++;
    });
}

function cancelButton(){
    createQuestion(".dash-contenido");
}

function confirmButton(){
    location.reload();
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
    arrayTitolPoll.forEach(element => {
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