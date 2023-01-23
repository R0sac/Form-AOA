<?php session_start();?><!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Login</title>
</head>

<body id="bodyLogin">
    <?php
    require('utilities.php');
    require_once('template.php');
    headerTemplate();
    ?>
<div id="mensajes">
</div>
    <?php
        $pdo= connectionBBDD();  
    ?>
    <center>
    <div id="divLogin">
    <h1>Iniciar Sessió</h1>
        <form method="post">
            <label for="user"> Usuari</label><br>
            <input type="email" name ="user" ><br><br>
            <label for="pass"> Contrasenya</label><br>
            <input type="password" name ="pass" ><br><br>
            <input id="btnLogin" type ="submit" value = "Iniciar Sessió" name='miBoton'><br><br>
            <a href="">He oblidat la contrasenya</a><br>
            <!-- <button type="button" onclick="NewError('error','Login correcto')">Prueba</button>
            <button type="button" onclick="NewError('warning','Login correcto')">Prueba</button>
            <button type="button" onclick="NewError('succes','Login correcto')">Prueba</button>
            <button type="button" onclick="NewError('info','Login correcto')">Prueba</button> -->
        </form>
    </div>
    </center>
    <div>
    <?php 
        if(isset($_POST["user"] ) && isset($_POST["pass"])){
            $stmt = $pdo ->prepare("SELECT * FROM usuaris WHERE usuari = ? AND contrasenya =  sha2(?,512);");            
            $stmt->bindParam(1,htmlspecialchars($_POST['user']));
            $stmt->bindParam(2,htmlspecialchars($_POST['pass']));
            $stmt->execute();
            $row = $stmt->fetch();
            if ($row){
                $_SESSION["usuario"] = [$row["usuari"],$row["rol"]];
                header('Location: dashboard.php');
            }
        }
    ?>
    </div>
    <?php
    require_once('template.php');
    footerTemplate();
    ?>
    <script src="/script.js"></script>
</body>
</html>