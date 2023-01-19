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
    <title>Dashboard-Enquestes</title>
    <!-- <script src="enquestes.js"></script> -->
</head>
<body onload="creationDashboard('body')">
    <?php
    require_once('template.php');
    headerTemplate();
    ?>
    <?php
        try {
            $hostname = "localhost";
            $dbname = "EnquestaProfessors";
            $username = "admin";
            $pw = "admin123";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
        } catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }

        //ARRAY TITOL QUESTION
        $arrayTitolQuestion =[];
        $stmt = $pdo ->prepare("SELECT text FROM pregunta;");            
        $stmt->execute();
        $row = $stmt->fetch();
        while($row){
            array_push($arrayTitolQuestion, $row['text']);
            $row = $stmt->fetch();
        }

        $_SESSION['arrayTitolEnquesta']=[];
        $stmt = $pdo ->prepare("SELECT titol FROM enquesta;");            
        $stmt->execute();
        $row = $stmt->fetch();
        while($row){
            array_push($_SESSION['arrayTitolEnquesta'], $row['titol']);
            $row = $stmt->fetch();
        }

        if(isset($_POST['inputName']) && isset($_POST['selectType'])){
            $name= $_POST['inputName'];
            $type= $_POST['selectType'];
            $idtype= '';
            $user= $_SESSION["usuario"][0];
            $iduser= '';

            $stmt = $pdo ->prepare("SELECT idtipus FROM tipus_pregunta WHERE tipus = '$type' ;");            
            $stmt->execute();
            $row = $stmt->fetch();
            if ($row){
                $idtype= $row['idtipus'];
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
    <?php
        $json_arrayPoll = json_encode($_SESSION['arrayTitolEnquesta']);
        $json_arrayQuestion = json_encode($arrayTitolQuestion);
    ?>
    <?php
    require_once('template.php');
    footerTemplate();
    ?>
    <script>
    var arrayTitolPoll = <?php echo $json_arrayPoll; ?>;
    var arrayTitolQuestion = <?php echo $json_arrayQuestion; ?>;
    </script>
    <script src="enquestes.js"></script>
</body>
</html>