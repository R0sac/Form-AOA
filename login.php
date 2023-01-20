<?php 
$_GET['Titulo'] = 'Log in';
$_GET['idBody'] = 'bodyLogin';
?>
<?php include "header.php"; ?>
<div id="mensajes">
</div>
<?php
    $pdo= connectionBBDD(); 
?>
<?php  
    if($_SESSION["errors"]){
        for ($i=0; $i <count($_SESSION["errors"]) ; $i++) {
            for ($j=0; $j < $_SESSION["errors"][$i]; $j++) {
                echo "<script>NewError('error','no tens rol per entrar en aquesta pagina');</script>";
            }
        }
    }
?>
<div class="autocenter">
    <div id="divLogin">
        <h1>Iniciar Sessió</h1>
            <form action="checkForm.php" method="post">
                <label for="user"> Usuari</label><br>
                <input type="email" name ="user" ><br><br>
                <label for="pass"> Contrasenya</label><br>
                <input type="password" name ="pass" ><br><br>
                <input id="btnLogin" type ="submit" value = "Iniciar Sessió" name='miBoton'><br><br>
                <a href="">He oblidat la contrasenya</a><br>
            </form>
    </div>
</div>

<?php include "footer.php"; ?>

