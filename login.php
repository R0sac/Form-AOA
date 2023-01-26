<?php
$_GET['Titulo'] = 'Log in';
$_GET['idBody'] = 'bodyLogin';
?>
<?php include "header.php";
include "log.php";?>
<div class="autocenter">
    <div id="mensajes">
</div>
</div>
<?php
    $pdo= connectionBBDD();
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
<div class="autocenter">
    <div id="divLogin">
        <h1>Iniciar Sessió</h1>
            <form id="login" action="checkForm.php" method="post">
                <label for="user"> Usuari</label><br>
                <input type="email" name ="user" ><br><br>
                <label for="pass"> Contrasenya</label><br>
                <input type="password" name ="pass" ><br><br>
                <button id="btnLogin" type="button">Iniciar Sessió</button><br><br>
                <a href="">He oblidat la contrasenya</a><br>
            </form>
    </div>
</div>
<script>
    $( document ).ready(function() {

        $("#btnLogin").click(() => {
            submitLogin();
        });
        
    });
</script>
<?php include "footer.php"; ?>

<?php
    if(isset($_POST['systemLog'])){
        logButtonClick("S","login.php","S'ha utilitzat el botó 'Login'\n");
    }
?>