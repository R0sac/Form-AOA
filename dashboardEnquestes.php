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
    <!-- <script src="enquestes.js"></script> -->
</head>
<body onload="creationDashboard('body')">
    <?php
        try {
            $hostname = "localhost";
            $dbname = "EnquestaProfessors";
            $username = "root";
            $pw = "";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
        } catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }
        if(isset($_POST['inputName']) && isset($_POST['selectType'])){
            $name= $_POST['inputName'];
            $type= $_POST['selectType'];
            $idtype= '';
            $user= $_SESSION["usuario"][0];
            $iduser= '';
            
            $stmt = $pdo ->prepare("INSERT INTO tipus_pregunta (tipus) VALUES ('$type');");
            $stmt->execute();

            $stmt = $pdo ->prepare("SELECT MAX(idtipus) as tipus FROM tipus_pregunta;");            
            $stmt->execute();
            $row = $stmt->fetch();
            if ($row){
                $idtype= $row['tipus'];
            }

            $stmt = $pdo ->prepare("SELECT idusuari FROM usuaris WHERE usuari = '$user' ;");            
            $stmt->execute();
            $row = $stmt->fetch();
            if ($row){
                $iduser= $row['idusuari'];
                $stmt = $pdo ->prepare("INSERT INTO pregunta (text,idusuari,idtipus) VALUES ('$name',$iduser,$idtype);");
                $stmt->execute();
            }
        }
    ?>
    <script src="enquestes.js"></script>
</body>
</html>