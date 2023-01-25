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