<?php session_start();
include('utilities.php');
include "log.php";
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
        logButtonClick("S","checkForm.php","S'ha iniciat la sessió correctament\n",$_SESSION['user'][2]);//
        header('Location: dashboard.php');
    }else{
        array_push($_SESSION["errors"],["error","Credencials incorrectes"]);
        logButtonClick("E","checkForm.php","El nom o la contrasenya son incorrectes\n");//
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
        logButtonClick("S","checkForm.php","INSERT INTO question (text, idTypeQuestion) VALUES ({$questionTitle},{$typeQuestion})\n",$_SESSION['user'][2]);
        $lastId = $pdo->lastInsertId();
        return $lastId;
    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
           logButtonClick("E","checkForm.php","Hi ha hagut un error a l'hora d'inserir una Pregunta del tipus 'Text'\n",$_SESSION['user'][2]);
        } 
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
        logButtonClick("S","checkForm.php","INSERT INTO question (text, idTypeQuestion) VALUES ({$questionTitle},{$typeQuestion})\n",$_SESSION['user'][2]);
        $lastId = $pdo->lastInsertId();
        
        $arrayOptions = [1,2,3,4,5];
        foreach ($arrayOptions as $key => $value) {
            $stmn = $pdo->prepare("INSERT INTO question_option (idQuestion,idOption) values (?, ?);");
            $stmn -> bindParam(1, $lastId);
            $stmn -> bindParam(2, $value);
            $stmn->execute();
        };
        $pdo->commit();
        logButtonClick("S","checkForm.php","INSERT INTO question_option (idQuestion,idOption) values ({$lastId}, {$value})\n",$_SESSION['user'][2]);
    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
           logButtonClick("E","checkForm.php","Hi ha hagut un error a l'hora d'inserir una Pregunta del tipus 'Numeric'\n",$_SESSION['user'][2]);
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
        logButtonClick("S","checkForm.php","INSERT INTO question (text, idTypeQuestion) VALUES ({$questionTitle},{$typeQuestion})\n",$_SESSION['user'][2]);
        $lastIdOfQuestion = $pdo->lastInsertId();
        foreach ($arrayOptions as $key => $value) {
            $stmn = $pdo->prepare("INSERT INTO `option` (`text`) values (?);");

            $stmn -> bindParam(1, $value);
            $stmn->execute();
            $lastIdOfOption = $pdo->lastInsertId();

            $stmn = $pdo->prepare("INSERT INTO question_option (idQuestion,idOption) values (?, ?);");
            $stmn->bindParam(1,$lastIdOfQuestion);
            $stmn->bindParam(2,$lastIdOfOption);
            $stmn->execute();
        };
        $pdo->commit();
        logButtonClick("S","checkForm.php","INSERT INTO `option` (`text`) values ({$value})\n",$_SESSION['user'][2]);
        logButtonClick("S","checkForm.php","INSERT INTO question_option (idQuestion,idOption) values ({$lastIdOfQuestion}, {$lastIdOfOption})\n",$_SESSION['user'][2]);
    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
            logButtonClick("E","checkForm.php","Hi ha hagut un error a l'hora d'inserir una Pregunta del tipus 'Opció Simple'\n",$_SESSION['user'][2]);
        } 
    }
}

function convertDateToDatetime($dateString) {
    return date('Y-m-d H:i:s',strtotime(str_replace('/','-',$dateString)));
}

function savePoll($pollTitle, $startDate, $endDate, $arrayTeachersId, $arrayQuestionsId, $arrayStudentsId){
    try {

        $actualDate = date('d-m-y h:i:s');
        $startDate = convertDateToDatetime($startDate);
        $endDate = convertDateToDatetime($endDate);
        $available = true;

        $pdo = connectionBBDD();
        $pdo->beginTransaction();

        // SAVING POLL
        $stmn = $pdo->prepare("INSERT INTO `poll` (`title`, `createdAt`,`startDate`,`endDate`,`available`) VALUES (?,?,?,?,?)");
        $stmn->bindParam(1,$pollTitle);
        $stmn->bindParam(2,$actualDate);
        $stmn->bindParam(3,$startDate);
        $stmn->bindParam(4,$endDate);
        $stmn->bindParam(5,$available);

        $stmn->execute();

        logButtonClick("S","checkForm.php","INSERT INTO `poll` (`title`, `createdAt`,`startDate`,`endDate`,`available`) VALUES ({$pollTitle},{$actualDate},{$startDate},{$endDate},{$available})\n",$_SESSION['user'][2]);

        $lastIdOfPoll = $pdo->lastInsertId();

        // SAVING TEACHERS OF POLL
        foreach ($arrayTeachersId as $key => $idTeacher) {
            $stmn = $pdo->prepare("INSERT INTO `poll_teacher` (`idPoll`, `idTeacher`) values (?,?);");
            $stmn -> bindParam(1, $lastIdOfPoll);
            $stmn -> bindParam(2, $idTeacher);
            $stmn->execute();
        };
        logButtonClick("S","checkForm.php","INSERT INTO `poll_teacher` (`idPoll`, `idTeacher`) values ({$lastIdOfPoll},{$idTeacher})\n",$_SESSION['user'][2]);

        // SAVING QUESTIONS OF POLL
        foreach ($arrayQuestionsId as $key => $idQuestion) {
            $stmn = $pdo->prepare("INSERT INTO `poll_question` (`idPoll`, `idQuestion`) values (?,?);");
            $stmn -> bindParam(1, $lastIdOfPoll);
            $stmn -> bindParam(2, $idQuestion);
            $stmn->execute();
        };
        logButtonClick("S","checkForm.php","INSERT INTO `poll_question` (`idPoll`, `idQuestion`) values ({$lastIdOfPoll},{$idQuestion})\n",$_SESSION['user'][2]);

        // SAVING STUDENTS OF POLL
        foreach ($arrayStudentsId as $key => $idStudent) {
            $stmn = $pdo->prepare("INSERT INTO `poll_student` (`idPoll`, `idStudent`) values (?,?);");
            $stmn -> bindParam(1, $lastIdOfPoll);
            $stmn -> bindParam(2, $idStudent);
            $stmn->execute();
        };
        logButtonClick("S","checkForm.php","INSERT INTO `poll_student` (`idPoll`, `idStudent`) values ({$lastIdOfPoll},{$idStudent})\n",$_SESSION['user'][2]);

    
        $pdo->commit();
    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {   
            logButtonClick("E","checkForm.php","Hi ha hagut un error a l'hora d'inserir una enquesta\n",$_SESSION['user'][2]);
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
                    logButtonClick("S","checkForm.php","La pregunta del tipus 'Numeric' s'ha desat correctament\n",$_SESSION['user'][2]);
                    break;

                case 2:   //Question type text            
                    saveTextQuestion($_POST["questionType"], $_POST["questionTitle"]);
                    logButtonClick("S","checkForm.php","La pregunta del tipus 'Text' s'ha desat correctament\n",$_SESSION['user'][2]);
                    break;
                    
                case 3:   //Question type simple option
                    saveSimpleOptionQuestion($_POST["questionType"], $_POST["questionTitle"], $_POST['inputOptions']);
                    logButtonClick("S","checkForm.php","La pregunta del tipus 'Opcio Simple' s'ha desat correctament\n",$_SESSION['user'][2]);
                    break;
            }

            break;
        
        case 'createPoll':
            savePoll($_POST["pollTitle"], $_POST["inputStartDate"], $_POST["inputEndDate"], $_POST["inputTeachersId"], $_POST["inputQuestionsId"], $_POST["inputStudentsId"]);
            logButtonClick("S","checkForm.php","El formulari s'ha desat correctament\n",$_SESSION['user'][2]);
            break;
    }
    header("Location: poll.php");

}


?>