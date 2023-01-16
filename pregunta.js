let arrayNameOption= ["Selecciona","Numeric","Text"];
let arrayValueOption= ["sel","numeric","text"];
let arrayNameButton= ["Cancelar", "Confirmar"]
let arrayIdButton= ["cancelar", "confirm"]
let verSelect= false;
let verInput= false;
createQuestion();

function createQuestion(){
    $("#contenido-crearpregunta").append("<form><p>NOM:</p><input id='nameQuestion'type='text'><p>TIPUS:</p></form>");
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