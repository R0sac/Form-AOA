$("#dashAdminEnquestes").click(function () {
    location.href='./poll.php';
});
function NewError(tipoMensaje,Texto) {
    var error = $(`<div class="${tipoMensaje}"><ul><li>${Texto}</li><span class="closebtn" onclick="this.parentElement.parentElement.style.display='none';">&times;</span></ul></div>`);7
    console.log(error);
    $('#mensajes').append(error);
}