<?php 
$_GET['Titulo'] = 'Recuperar Contrasenya';
$_GET['idBody'] = 'bodyRecoverPassword';
?>
<?php include "header.php"; ?>

<div class="autocenter">
    <div id="mensajes"></div>
</div>

<?php
    if (isset($_GET["id"]) && isset($_GET["codeIdentifier"]) && ($_GET["codeIdentifier"] == md5("aoa_forms-".$_GET["id"]."-recPass")) ) {
        echo "
            <div class='autocenter'>
                <div id='divLogin'>
                    <h1>Recuperar Contrasenya</h1>
                    <form class='formForgotPass' id ='formForgotPass' action='./checkForm.php' method='post'>
                        <input type='text' name='idRecoverPass' value='".$_GET["id"]."' hidden/>
                        <label for='inputRecoverPass'>Introdueix la nova contrasenya</label>
                        <input name='inputRecoverPass' id='inputRecoverPass' type='password'>
                        <br>
                        <label for='inputRecoverPass2'>Repeteix la contrasenya</label>
                        <input name='inputRecoverPass2' id='inputRecoverPass2' type='password'>
                        <br>
                        <button class='btnSubmit' id='btnRecoverPass' type='button'>Enviar</button>
                    </form>
                </div>
            </div>
            
            <script>
                $( document ).ready(function() {
                    $('#btnRecoverPass').click(() => {
                        submitRecoverPass();
                    });
                });
            </script>";
    }
    else{
        echo "
            <div class='autocenter'>
                <div id='divLogin'>
                    <h1>Recuperar Contrasenya</h1>
                    <form class='formForgotPass' id ='formForgotPass' action='./checkForm.php' method='post'>
                        <label for='inputForgotPass'>Introdueix un correu</label>
                        <input name='inputForgotPass' id='inputForgotPass' type='text'>
                        <br>
                        <button class='btnSubmit' id='btnRecoverPass' type='button'>Enviar</button>
                    </form>
                </div>
            </div>
            
            <script>
                $( document ).ready(function() {
                    $('#btnRecoverPass').click(() => {
                        submitRecoverPassSendEmail();
                    });
                });
            </script>";
    }
?>


<?php
    if(issetErrors()){
        for ($i=0; $i < count($_SESSION["errors"]) ; $i++) {
            echo "<script>NewError('".$_SESSION['errors'][$i][0]."','".$_SESSION['errors'][$i][1]."');</script>";
        }
        $_SESSION["errors"] = array();
    }
    else{
        $_SESSION["errors"] = array();
    }
?>

<?php include "footer.php"; ?>
