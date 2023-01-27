<?php 
$_GET['Titulo'] = 'Recuperar Contrasenya';
$_GET['idBody'] = 'bodyRecoverPassword';
?>
<?php include "header.php"; ?>

<div class="autocenter">
    <div id="divLogin" class="autocenter">
        <h1>Recuperar Contrasenya</h1>
        <form class="formForgotPass" action="./checkForm.php" method="post">
            <label for="inputForgotPass">Introdueix un correu</label>
            <input name="inputForgotPass" id="inputForgotPass" type="text">
            <br>
            <button class="btnSubmit" type="submit">Enviar</button>
        </form>
    </div>
</div>

<?php include "footer.php"; ?>
