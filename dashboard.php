<?php
    session_start();
    include "log.php";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body id="bodyDashboard">
    <?php
     create_log_file("mylog.txt", "Entrada en dashboard.php");   
    ?>
    <?php
        if($_SESSION["usuario"][1] === "profe"){
            ?>
            <div id="Dashprofe">
                <button id="dashProfePerfil" class="BtnDash">Perfil</button>
                <button id="dashProfeEstats" class="BtnDash">Estadistiques</button>
            </div>
            <?php
        }
        elseif ($_SESSION["usuario"][1] === "admin") {
            ?>
             <div id="DashAdmin">
                <button id="dashAdminUsuaris" class="BtnDash">Usuaris</button>
                <button id="dashAdminEnquestes" class="BtnDash">Enquestes</button>
                <button id="dashAdminEstats" class="BtnDash">Estadistiques</button>
            </div>
            <?php
        }


    ?>

    <a href="/login.php">Volver a login</a>
    <script src="script.js"></script>

</body>
</html>