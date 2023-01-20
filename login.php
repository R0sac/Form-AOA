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
<div class="autocenter">
    <div id="divLogin">
        <h1>Iniciar Sessió</h1>
            <form method="post">
                <label for="user"> Usuari</label><br>
                <input type="email" name ="user" ><br><br>
                <label for="pass"> Contrasenya</label><br>
                <input type="password" name ="pass" ><br><br>
                <input id="btnLogin" type ="submit" value = "Iniciar Sessió" name='miBoton'><br><br>
                <a href="">He oblidat la contrasenya</a><br>
            </form>
    </div>
</div>
<?php 
    if(isset($_POST["user"] ) && isset($_POST["pass"])){
        $stmt = $pdo ->prepare("SELECT * FROM user u WHERE u.email = ? AND u.password =  sha2(?,512);");            
        $stmt->bindParam(1,htmlspecialchars($_POST['user']));
        $stmt->bindParam(2,htmlspecialchars($_POST['pass']));
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row){
            $_SESSION["user"] = [$row["id"],$row["email"],$row["username"],$row["role"]];
            header('Location: dashboard.php');
        }
    }
?>
<?php include "footer.php"; ?>

