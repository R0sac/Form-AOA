//REDIRECCIONAR A OTRA PAGINA
function changeLocation(pag) {
    location.href=`./${pag}.php`;
}
//ERRORES, WARNINGS, INFO, SUCCESS
function NewError(tipoMensaje,Texto) {
    var error = $(`<div class="${tipoMensaje}"><ul><li>${Texto}</li><span class="closebtn" onclick="this.parentElement.parentElement.style.display='none';">&times;</span></ul></div>`);
    $('#mensajes').append(error);
}

//SUBMIT MANUAL
function submitLogin() {
    console.log("a");
    var user = $("[name=user]").val();
    var pass = $("[name=pass]").val();
    if (user && pass){
        $("#login").submit();
    }else{
        NewError("warning","Emplena el formulari");
        
    }
}

//BREADCRUMB
function addBreadcrumb(event){
    let clickButton= event.target;
    let nameButton= $(clickButton).text();
    $(".breadcrumb li:last-child").remove();
    $(".breadcrumb").append("<li>"+ nameButton +"</li>");
}

//BREADCRUMB PREDETERMINADO POLL.PHP
function defaultBreadcrumbPoll(){
    var url= window.location.href;
    var nameURLPage= $(".breadcrumb li:last-child").text();
    $(".breadcrumb li:last-child").empty().append("<a href='"+url+"'>"+ nameURLPage +"</a>");
    $(".breadcrumb").append("<li>Llistat de Preguntes</li>");
}