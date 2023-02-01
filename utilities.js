//REDIRECCIONAR A OTRA PAGINA
function changeLocation(pag) {
    location.href=`./${pag}.php`;
}
//ERRORES, WARNINGS, INFO, SUCCESS
function NewError(tipoMensaje,Texto) {
    var error = $(`<div class="${tipoMensaje}"><ul><li>${Texto}</li><span class="closebtn" onclick="this.parentElement.parentElement.style.display='none';">&times;</span></ul></div>`);
    $('#mensajes').append(error);
}
//CREA ELEMENTOS DOM SIN ID INCLUIDO
function createElements(parent,elementDOM, classes,cierreForzado,text=''){
    if (cierreForzado==true){
        $(parent).append("<"+elementDOM+" class='"+classes+"'>"+text+"</"+elementDOM+">") 
    }
    else{
        $(parent).append("<"+elementDOM+" class="+classes+">") 
    }
}

//CREA ELEMENTOS DOM CON ID INCLUIDO
function createElements2(parent,elementDOM, classes,ids,cierreForzado,text=''){
    if (cierreForzado==true){
        $(parent).append("<"+elementDOM+" id='"+ids+"' class='"+classes+"'>"+text+"</"+elementDOM+">") 
    }
    else{
        $(parent).append("<"+elementDOM+" id='"+ids+"' class="+classes+">") 
    }
}

//SUBMIT MANUAL

function submitLogin() {
    var user = $("[name=user]").val();
    var pass = $("[name=pass]").val();
    if (user && pass){
        $("#login").submit();
    }else{
        NewError("warning","Emplena el formulari");
        
    }
}

function submitRecoverPassSendEmail() {
    var email = $("[name=inputForgotPass]").val();
    if (email) {
        $("#formForgotPass").submit();
    }
    else{
        NewError("warning","Emplena el formulari");   
    }
}

function submitRecoverPass(){
    var pass1 =  $("[name=inputRecoverPass]").val();
    var pass2 =  $("[name=inputRecoverPass2]").val();

    if (pass1 !== pass2) {
        NewError("warning","Les contrasenyes no coincideixen");
        return;
    }

    if (pass1.length < 8) {
        NewError("warning","La contrasenya ha de tenir com a mínim 8 caràcters");
        return;
    }

    if (/^(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+*!=]).*$/.test(pass1)) {
        $("#formForgotPass").submit();
        return;
    }

    NewError("warning","La contrasenya ha de tenir 1 majúscula 1 minúscula i un caràcter especial");
    return;

}

function submitSendPollsToStudent() {
    var email = $("[name=inputSendPollsStudent]").val();
    if (!email) {
        NewError("warning","Has d\'omplir l\'email");
        return;
    }

    $("#formSendPollStudent").submit();
    return;

}