<?php session_start();
include('utilities.php');
$_SESSION["errors"] = array();
function logIn(){
    $user = htmlspecialchars($_POST['user']);
    $pass = htmlspecialchars($_POST['pass']);

    $pdo = connectionBBDD();
    $stmt = $pdo ->prepare("SELECT * FROM user u WHERE u.email = ? AND u.password =  sha2(?,512);");            
    $stmt->bindParam(1,$user);
    $stmt->bindParam(2,$pass);
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row){
        $_SESSION["user"] = [$row["id"],$row["email"],$row["username"],intval($row["role"])];
        header('Location: dashboard.php');
    }else{
        array_push($_SESSION["errors"],["error","Credencials incorrectes"]);
        header('Location: login.php');
    }
}

function sendQuestionTOBDD($typeQuestion, $questionTitle ,$questionText , $options=[]){
    switch (intval($_POST["questionType"])) {
        case 1:  //Question type number
            # code...
            break;
        case 2:   //Question type text
            
            break;
        case 3:   //Question type simple option
            # code...
            break;
    }

    try {
        $pdo = connectionBBDD();
        $pdo->beginTransaction();

        $pdo->exec("DROP TABLE fruit");
        $pdo->exec("UPDATE dessert SET name = 'hamburger'");

        $pdo->commit();

    } catch (\Throwable $th) {
        $pdo->rollBack();
        // TODO poner mensaje error
    }
}


if(isset($_POST["user"] ) && isset($_POST["pass"])){
    logIn();
}
else if (isset($_POST["typeOfForm"])){  //Apartado para los formularios de poll.php

    switch ($_POST["typeOfForm"]) {
        case 'createQuestion':

            sendQuestionTOBDD($_POST["typeOfForm"], );

            break;
        
        case 'createPoll':
            # code...
            break;
    }
}


?>