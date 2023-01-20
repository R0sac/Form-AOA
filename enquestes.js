var script = document.createElement('script');
script.src = 'https://code.jquery.com/jquery-3.6.3.min.js';
document.getElementsByTagName('head')[0].appendChild(script);

// let arrayNameOption= ["Selecciona","Numeric","Text", "Opcion Simple"];
// let arrayValueOption= ["sel","numeric","text", "simpleOption"];
// let arrayLabelTextCreationQuestion= ["Res satisfet","Poc satisfet","Neutral", "Molt Satisfet", "Totalment Satisfet"]
// let verSelect= false;
// let verInput= false;

// $(".dash-contenido").removeAttr("style");
// $(document).ready(function(){
//     $("#crearPregunta").click(function(){
//         createQuestion(".dash-contenido");
//         $('#cancelar').click(cancelButton);
//         $('#confirm').click(confirmButton);
//     });
//     $('#crearEncuesta').click(function(){
//         createPoll(".dash-contenido")
//     });
//     $('#listarPreguntas').click(function(){
//         viewListQuestion(".dash-contenido",arrayTitolQuestion);
//     });
        
//     $('#listarEncuestas').click(function(){
//         viewListPoll(".dash-contenido")
//     });
// });

//CREA DASHBOARD
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
        createInputElement(".divRadioButton","text","inputSimpleOption","inputSimpleOption","simpleOption")
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
    var objectJquery = $(elementDOM);
    objectJquery.empty();
    let cont= 1;
    objectJquery.append("<div class='containerQuestions' id='containerQuestions'></div>");

    var containerQuestions = $('#containerQuestions');

    arrayTextListQuestion.forEach(question => {
        containerQuestions.append(
        "<div class='divSingleQuestion' id='question-"+ cont + "'><p>" + question + "</p></div>"
        );
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