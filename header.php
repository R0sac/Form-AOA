<?php session_start();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/277f72a273.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="./utilities.js"></script>
    <title><?php echo $_GET['Titulo']; ?></title>
    <?php require('utilities.php'); ?>
</head>

<body id='<?php echo $_GET['idBody']; ?>'>
    
<script src="./utilities.js"></script>
<header class='headerAll'>

    <h2>Enquestes Professorat</h2>
    
</header>
<?php if(isset($_GET['logout'])){
        ?>
        <div class="containerLogoutBtn">
        <a class="buttonLogout" href='./logout.php'>
            <div class="logout" >SORTIR</div>
            <i class="fa fa-solid fa-right-from-bracket"></i>
        </a>
    </div>
    <?php
    };
    ?>