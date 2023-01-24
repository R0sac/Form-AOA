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

function saveTextQuestion($typeQuestion, $questionTitle){
    try {
        $pdo = connectionBBDD();
        $pdo->beginTransaction();
        $stmn = $pdo->prepare("INSERT INTO `question` (`text`, `idTypeQuestion`) VALUES (?,?)");
        $stmn->bindParam(1,$questionTitle);
        $stmn->bindParam(2,$typeQuestion);
        $stmn->execute();
        $pdo->commit();
        $lastId = $pdo->lastInsertId();
        return $lastId;
    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
        } 
        // TODO poner mensaje error
    }
}

function saveNumberQuestion($typeQuestion, $questionTitle){
    try {
        $pdo = connectionBBDD();
        $pdo->beginTransaction();
        $stmn = $pdo->prepare("INSERT INTO `question` (`text`, `idTypeQuestion`) VALUES (?,?)");
        $stmn->bindParam(1,$questionTitle);
        $stmn->bindParam(2,$typeQuestion);
        $stmn->execute();

        $lastId = $pdo->lastInsertId();
        
        $arrayOptions = [1,2,3,4,5];
        foreach ($arrayOptions as $key => $value) {
            $stmn = $pdo->prepare("INSERT INTO question_option (id_question,id_option) values (?, ?);");
            $stmn -> bindParam(1, $lastId);
            $stmn -> bindParam(2, $value);
            $stmn->execute();
        };
        $pdo->commit();
    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
        } 
    }
}

function saveSimpleOptionQuestion($typeQuestion, $questionTitle, $arrayOptions){
    try {
        $pdo = connectionBBDD();
        $pdo->beginTransaction();
        $stmn = $pdo->prepare("INSERT INTO `question` (`text`, `idTypeQuestion`) VALUES (?,?)");
        $stmn->bindParam(1,$questionTitle);
        $stmn->bindParam(2,$typeQuestion);
        $stmn->execute();

        $lastIdOfQuestion = $pdo->lastInsertId();
        foreach ($arrayOptions as $key => $value) {
            $stmn = $pdo->prepare("INSERT INTO `option` (`text`) values (?);");

            $stmn -> bindParam(1, $value);
            $stmn->execute();
            $lastIdOfOption = $pdo->lastInsertId();

            $stmn = $pdo->prepare("INSERT INTO question_option (id_question,id_option) values (?, ?);");
            $stmn->bindParam(1,$lastIdOfQuestion);
            $stmn->bindParam(2,$lastIdOfOption);
            $stmn->execute();
        };
    
        $pdo->commit();
    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
        } 
    }
}


if(isset($_POST["user"] ) && isset($_POST["pass"])){
    logIn();
}
else if (isset($_POST["typeOfForm"])){  //Apartado para los formularios de poll.php

    switch ($_POST["typeOfForm"]) {

        case 'createQuestion':
            
            switch (intval($_POST["questionType"])) {
                case 1:  //Question type number
                    saveNumberQuestion($_POST["questionType"], $_POST["questionTitle"]);
                    break;

                case 2:   //Question type text            
                    saveTextQuestion($_POST["questionType"], $_POST["questionTitle"]);
                    // TO DO meter log de envío de pregunta realizado correctamente
                    break;
                    
                case 3:   //Question type simple option
                    saveSimpleOptionQuestion($_POST["questionType"], $_POST["questionTitle"], $_POST['inputOptions']);
                    break;
            }

            break;
        
        case 'createPoll':
            # code...
            break;
    }
    header("Location: poll.php");

}


?>