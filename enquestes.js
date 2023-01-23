let arrayNameOption= ["Selecciona","Numeric","Text", "Opcion Simple"];
let arrayValueOption= ["sel","numeric","text", "simpleOption"];
let arrayLabelTextCreationQuestion= ["Res satisfet","Poc satisfet","Neutral", "Molt Satisfet", "Totalment Satisfet"]
let verSelect= false;
let verInput= false;
let divInputButtonClass= 0;

$(document).ready(function(){
    $('#cancelar').click(cancelButton);
    $('#confirm').click(confirmButton);
    $("#crearPregunta").click(function(){
        createQuestion(".dash-contenido");
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
}

function limpiarPantalla() {
    $("body").children().remove();
}

//CREAR PREGUNTA
function createQuestion(elementDOM){
    $(elementDOM).empty();
    $(elementDOM).append("<form class='contentRs formQuestion' method='POST'></form>");//CREA UN FORMULARIO VACIO
    createElements(".contentRs","p","pFormType",true,"TIPUS:");//AÑADE DENTRO DEL FORMULARIO UNA 'P'
    createTypeQuestion(arrayNameOption,arrayValueOption,".contentRs")//AÑADE DENTRO DEL FORMULARIO UN 'SELECT'
    createElements(".contentRs","div","divRadioButton",true);//AÑADE DENTRO DEL FORMULARIO UN 'DIV' PARA LAS OPCIONES DEL RADIO BUTTON
    createElements(".contentRs","p","pFormName",true,"NOM:");//AÑADE DENTRO DEL FORMULARIO UNA 'P'
    createInputElement(".contentRs","text", "nameQuestion","nameQuestion","inputName");//AÑADE DENTRO DEL FORMULARIO UN 'INPUT'
    createElements2(".contentRs", "div","buttonConfirm","buttonConfirm",true)//AÑADE DENTRO DEL FORMULARIO UN 'DIV' PARA LOS BOTONES
    createButtons("#buttonConfirm", "button", "cancelar", "cancelar", "Cancelar",);//AÑADE DENTRO DEL DIV_BOTONES UNOS DOS BOTONES
    
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
    $(".buttonAddInput").remove();
    if($(this).val()=='numeric'){
        verSelect= true;
        $(".divRadioButton").empty();
        arrayLabelTextCreationQuestion.forEach(element => {
            createInputElement(".divRadioButton","radio","inputRadioButton", "inputRadioButton", "typeQuestionRadio", element)
            createElements(".divRadioButton","label","labelRadioButton",true, element);
            $(".divRadioButton").append("<br>");
        });
    }

    else if($(this).val()=='text'){
        verSelect= true;
        $(".divRadioButton").empty();
        $(".divRadioButton").append("<textarea id='textArea' name='text' rows='4' cols='50' placeholder='Escriu aqui...' disabled>")
    }

    else if($(this).val()=='simpleOption'){
        verSelect= true;
        $(".divRadioButton").empty();
        $("#typeQuestion").after("<button type='button' class='buttonAddInput' >Mas</button>");
        for (let index = 0; index < 2; index++) {
            createElements(".divRadioButton","div", `divInputButton ${divInputButtonClass}`,true);
            createInputElement(`.${divInputButtonClass}`,"text","inputSimpleOption","inputSimpleOption","simpleOption");
            createButtons(`.${divInputButtonClass}`,"button","buttonCreateInputs","buttonCreateInputs","Eliminar"); 
            divInputButtonClass++;
        }
        $(".buttonCreateInputs").click(function(event){
            var targerRemove= $(event.target);
            $(targerRemove).parent().remove();
        });

        $(".buttonAddInput").click(createDivInputButton);
        // createInputElement(".divRadioButton","text","inputSimpleOption","inputSimpleOption","simpleOption");
    }

    else{
        $(".divRadioButton").empty();
        verSelect= false;
    }
    comprovation()
}

function createInputElement(parent, type, classe, ids, name, value=''){
    $(parent).append("<input type='"+type+"' class='"+classe+"' id='"+ids+"' name='"+name+"' value='"+value+"'>")
}

function createDivInputButton(){
    createElements(".divRadioButton","div", `divInputButton ${divInputButtonClass}`,true);
    createInputElement(`.${divInputButtonClass}`,"text","inputSimpleOption","inputSimpleOption","simpleOption");
    createButtons(`.${divInputButtonClass}`,"button","buttonCreateInputs","buttonCreateInputs","Eliminar");  
    divInputButtonClass++;
    $(".buttonCreateInputs").click(function(event){
        var targerRemove= $(event.target);
        $(targerRemove).parent().remove();
    });
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
        $(".confirm").remove()
        createButtons("#buttonConfirm", "submit", "confirm", "confirm", "Confirmar",);
    }
    else{
        $(".confirm").remove()
    }
}

function createButtons(parent, type, classe, ids,text){
    $(parent).append("<button type='"+type+"' class='"+classe+"' id='"+ ids +"'>" + text + "</button>");
}

function cancelButton(){
    verSelect= false;
    verInput= false;
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