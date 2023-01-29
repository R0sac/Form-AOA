<?php session_start();
include('utilities.php');
include "log.php";
$_SESSION["errors"] = array();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Require the composer autoloader
require 'vendor/autoload.php';



function logIn(){
    $user = htmlspecialchars($_POST['user']);
    $pass = htmlspecialchars($_POST['pass']);

    $pdo = connectionBBDD();
    $stmt = $pdo ->prepare("SELECT * FROM creyentes_poll.user u WHERE u.email = ? AND u.password =  sha2(?,512);");            
    $stmt->bindParam(1,$user);
    $stmt->bindParam(2,$pass);
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row){
        $_SESSION["user"] = [$row["id"],$row["email"],$row["username"],intval($row["role"])];
        logButtonClick("S","checkForm.php","S'ha iniciat la sessió correctament\n",$_SESSION['user'][2]);
        header('Location: dashboard.php');
    }else{
        array_push($_SESSION["errors"],["error","Credencials incorrectes"]);
        logButtonClick("E","checkForm.php","El usuari o la contrasenya son incorrectes\n");
        header('Location: login.php');
    }
}

function saveTextQuestion($typeQuestion, $questionTitle){
    try {
        $available = 1;

        $pdo = connectionBBDD();
        $pdo->beginTransaction();
        $stmn = $pdo->prepare("INSERT INTO creyentes_poll.question (`text`, `idTypeQuestion`,`available`) VALUES (?,?,?);");
        $stmn->bindParam(1,$questionTitle);
        $stmn->bindParam(2,$typeQuestion);
        $stmn->bindParam(3,$available);
        $stmn->execute();
        $pdo->commit();
        logButtonClick("S","checkForm.php","INSERT INTO question (text, idTypeQuestion, available) VALUES ({$questionTitle},{$typeQuestion},{$available})\n",$_SESSION['user'][2]);
    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
        }
        logButtonClick("E","checkForm.php","Hi ha hagut un error a l'hora d'inserir una Pregunta del tipus 'Text'\n",$_SESSION['user'][2]);
    }
}

function editTextQuestion($typeQuestion, $questionTitle, $idQuestionToEdit){
    try {
        $available = 1;
        $notAvailable = 0;

        $pdo = connectionBBDD();
        $pdo->beginTransaction();

        $stmn = $pdo->prepare("UPDATE creyentes_poll.question SET `available`=? WHERE id=?;");
        $stmn->bindParam(1,$notAvailable);
        $stmn->bindParam(2,$idQuestionToEdit);
        $stmn->execute();
        logButtonClick("S","checkForm.php","UPDATE `question` SET `available`={$notAvailable} WHERE id={$idQuestionToEdit}\n",$_SESSION['user'][2]);

        $stmn = $pdo->prepare("INSERT INTO creyentes_poll.question (`text`, `idTypeQuestion`,`available`) VALUES (?,?,?);");
        $stmn->bindParam(1,$questionTitle);
        $stmn->bindParam(2,$typeQuestion);
        $stmn->bindParam(3,$available);
        $stmn->execute();
        $pdo->commit();
        logButtonClick("S","checkForm.php","INSERT INTO question (text, idTypeQuestion, available) VALUES ({$questionTitle},{$typeQuestion},{$available})\n",$_SESSION['user'][2]);
    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
        } 
        logButtonClick("E","checkForm.php","Hi ha hagut un error a l'hora d'actualitzar una Pregunta del tipus 'Text'\n",$_SESSION['user'][2]);
    }
}

function saveNumberQuestion($typeQuestion, $questionTitle){
    try {
        $available = 1;

        $pdo = connectionBBDD();
        $pdo->beginTransaction();

        $stmn = $pdo->prepare("INSERT INTO creyentes_poll.question (`text`, `idTypeQuestion`,`available`) VALUES (?,?,?);");
        $stmn->bindParam(1,$questionTitle);
        $stmn->bindParam(2,$typeQuestion);
        $stmn->bindParam(3,$available);
        $stmn->execute();
        logButtonClick("S","checkForm.php","INSERT INTO question (text, idTypeQuestion, available) VALUES ({$questionTitle},{$typeQuestion},{$available})\n",$_SESSION['user'][2]);

        $lastId = $pdo->lastInsertId();
        
        $arrayOptions = [1,2,3,4,5];
        foreach ($arrayOptions as $key => $value) {
            $stmn = $pdo->prepare("INSERT INTO creyentes_poll.question_option (idQuestion,idOption) values (?, ?);");
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
        } 
        logButtonClick("E","checkForm.php","Hi ha hagut un error a l'hora d'inserir una Pregunta del tipus 'Numeric'\n",$_SESSION['user'][2]);
    }
}

function editNumberQuestion($typeQuestion, $questionTitle, $idQuestionToEdit){
    try {
        $available = 1;
        $notAvailable = 0;


        $pdo = connectionBBDD();
        $pdo->beginTransaction();

        $stmn = $pdo->prepare("UPDATE creyentes_poll.question SET `available`=? WHERE id=?;");
        $stmn->bindParam(1,$notAvailable);
        $stmn->bindParam(2,$idQuestionToEdit);
        $stmn->execute();
        logButtonClick("S","checkForm.php","UPDATE `question` SET `available`={$notAvailable} WHERE id={$idQuestionToEdit}\n",$_SESSION['user'][2]);

        $stmn = $pdo->prepare("INSERT INTO creyentes_poll.question (`text`, `idTypeQuestion`,`available`) VALUES (?,?,?);");
        $stmn->bindParam(1,$questionTitle);
        $stmn->bindParam(2,$typeQuestion);
        $stmn->bindParam(3,$available);
        $stmn->execute();
        logButtonClick("S","checkForm.php","INSERT INTO question (text, idTypeQuestion, available) VALUES ({$questionTitle},{$typeQuestion},{$available})\n",$_SESSION['user'][2]);

        $lastId = $pdo->lastInsertId();
        
        $arrayOptions = [1,2,3,4,5];
        foreach ($arrayOptions as $key => $value) {
            $stmn = $pdo->prepare("INSERT INTO creyentes_poll.question_option (idQuestion,idOption) values (?, ?);");
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
        }
        logButtonClick("E","checkForm.php","Hi ha hagut un error a l'hora d'actualitzar una Pregunta del tipus 'Numeric'\n",$_SESSION['user'][2]);
    }
}

function saveSimpleOptionQuestion($typeQuestion, $questionTitle, $arrayOptions){
    try {
        $available = 1;

        $pdo = connectionBBDD();
        $pdo->beginTransaction();

        $stmn = $pdo->prepare("INSERT INTO creyentes_poll.question (`text`, `idTypeQuestion`,`available`) VALUES (?,?,?);");
        $stmn->bindParam(1,$questionTitle);
        $stmn->bindParam(2,$typeQuestion);
        $stmn->bindParam(3,$available);
        $stmn->execute();
        logButtonClick("S","checkForm.php","INSERT INTO question (text, idTypeQuestion, available) VALUES ({$questionTitle},{$typeQuestion},{$available})\n",$_SESSION['user'][2]);

        $lastIdOfQuestion = $pdo->lastInsertId();
        foreach ($arrayOptions as $key => $value) {
            $stmn = $pdo->prepare("INSERT INTO creyentes_poll.option (`text`) values (?);");

            $stmn -> bindParam(1, $value);
            $stmn->execute();
            $lastIdOfOption = $pdo->lastInsertId();

            $stmn = $pdo->prepare("INSERT INTO creyentes_poll.question_option (idQuestion,idOption) values (?, ?);");
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
        }
        logButtonClick("E","checkForm.php","Hi ha hagut un error a l'hora d'inserir una Pregunta del tipus 'Opció Simple'\n",$_SESSION['user'][2]);
    }
}

function editSimpleOptionQuestion($typeQuestion, $questionTitle, $arrayOptions, $idQuestionToEdit){
    try {        
        $available = 1;
        $notAvailable = 0;


        $pdo = connectionBBDD();
        $pdo->beginTransaction();

        $stmn = $pdo->prepare("UPDATE creyentes_poll.question SET `available`=? WHERE id=?;");
        $stmn->bindParam(1,$notAvailable);
        $stmn->bindParam(2,$idQuestionToEdit);
        $stmn->execute();
        logButtonClick("S","checkForm.php","UPDATE `question` SET `available`={$notAvailable} WHERE id={$idQuestionToEdit}\n",$_SESSION['user'][2]);

        $stmn = $pdo->prepare("INSERT INTO creyentes_poll.question (`text`, `idTypeQuestion`,`available`) VALUES (?,?,?);");
        $stmn->bindParam(1,$questionTitle);
        $stmn->bindParam(2,$typeQuestion);
        $stmn->bindParam(3,$available);

        $stmn->execute();
        logButtonClick("S","checkForm.php","INSERT INTO question (text, idTypeQuestion, available) VALUES ({$questionTitle},{$typeQuestion},{$available})\n",$_SESSION['user'][2]);

        $lastIdOfQuestion = $pdo->lastInsertId();
        foreach ($arrayOptions as $key => $value) {
            $stmn = $pdo->prepare("INSERT INTO creyentes_poll.option (`text`) values (?);");

            $stmn -> bindParam(1, $value);
            $stmn->execute();
            $lastIdOfOption = $pdo->lastInsertId();

            $stmn = $pdo->prepare("INSERT INTO creyentes_poll.question_option (idQuestion,idOption) values (?, ?);");
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
        }
        logButtonClick("E","checkForm.php","Hi ha hagut un error a l'hora d'actualitzar una Pregunta del tipus 'Opció Simple'\n",$_SESSION['user'][2]);
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
        $available = 1;

        $pdo = connectionBBDD();
        $pdo->beginTransaction();

        // SAVING POLL
        $stmn = $pdo->prepare("INSERT INTO creyentes_poll.poll (`title`, `createdAt`,`startDate`,`endDate`,`available`) VALUES (?,?,?,?,?);");
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
            $stmn = $pdo->prepare("INSERT INTO creyentes_poll.poll_teacher (`idPoll`, `idTeacher`) values (?,?);");
            $stmn -> bindParam(1, $lastIdOfPoll);
            $stmn -> bindParam(2, $idTeacher);
            $stmn->execute();
        };
        logButtonClick("S","checkForm.php","INSERT INTO `poll_teacher` (`idPoll`, `idTeacher`) values ({$lastIdOfPoll},{$idTeacher})\n",$_SESSION['user'][2]);

        // SAVING QUESTIONS OF POLL
        foreach ($arrayQuestionsId as $key => $idQuestion) {
            $stmn = $pdo->prepare("INSERT INTO creyentes_poll.poll_question (`idPoll`, `idQuestion`) values (?,?);");
            $stmn -> bindParam(1, $lastIdOfPoll);
            $stmn -> bindParam(2, $idQuestion);
            $stmn->execute();
        };
        logButtonClick("S","checkForm.php","INSERT INTO `poll_question` (`idPoll`, `idQuestion`) values ({$lastIdOfPoll},{$idQuestion})\n",$_SESSION['user'][2]);

        // SAVING STUDENTS OF POLL
        foreach ($arrayStudentsId as $key => $idStudent) {
            $stmn = $pdo->prepare("INSERT INTO creyentes_poll.poll_student (`idPoll`, `idStudent`) values (?,?);");
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
           $pdo->rollBack();
        } 
        logButtonClick("E","checkForm.php","Hi ha hagut un error a l'hora d'inserir una enquesta\n",$_SESSION['user'][2]);
    }
}

function editPoll($pollTitle, $startDate, $endDate, $arrayTeachersId, $arrayQuestionsId, $arrayStudentsId, $idPollToEdit){
    try {

        $actualDate = date('d-m-y h:i:s');
        $startDate = convertDateToDatetime($startDate);
        $endDate = convertDateToDatetime($endDate);
        $available = 1;
        $notAvailable = 0;

        $pdo = connectionBBDD();
        $pdo->beginTransaction();

        $stmn = $pdo->prepare("UPDATE creyentes_poll.poll SET `available`=? WHERE id=?;");
        $stmn->bindParam(1,$notAvailable);
        $stmn->bindParam(2,$idPollToEdit);
        $stmn->execute();
        logButtonClick("S","checkForm.php","UPDATE `poll` SET `available`={$notAvailable} WHERE id={$idPollToEdit}\n",$_SESSION['user'][2]);

        // SAVING POLL
        $stmn = $pdo->prepare("INSERT INTO creyentes_poll.poll (`title`, `createdAt`,`startDate`,`endDate`,`available`) VALUES (?,?,?,?,?);");
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
            $stmn = $pdo->prepare("INSERT INTO creyentes_poll.poll_teacher (`idPoll`, `idTeacher`) values (?,?);");
            $stmn -> bindParam(1, $lastIdOfPoll);
            $stmn -> bindParam(2, $idTeacher);
            $stmn->execute();
        };
        logButtonClick("S","checkForm.php","INSERT INTO `poll_teacher` (`idPoll`, `idTeacher`) values ({$lastIdOfPoll},{$idTeacher})\n",$_SESSION['user'][2]);

        // SAVING QUESTIONS OF POLL
        foreach ($arrayQuestionsId as $key => $idQuestion) {
            $stmn = $pdo->prepare("INSERT INTO creyentes_poll.poll_question (`idPoll`, `idQuestion`) values (?,?);");
            $stmn -> bindParam(1, $lastIdOfPoll);
            $stmn -> bindParam(2, $idQuestion);
            $stmn->execute();
        };
        logButtonClick("S","checkForm.php","INSERT INTO `poll_question` (`idPoll`, `idQuestion`) values ({$lastIdOfPoll},{$idQuestion})\n",$_SESSION['user'][2]);

        // SAVING STUDENTS OF POLL
        foreach ($arrayStudentsId as $key => $idStudent) {
            $stmn = $pdo->prepare("INSERT INTO creyentes_poll.poll_student (`idPoll`, `idStudent`) values (?,?);");
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
           $pdo->rollBack();
        }
        logButtonClick("E","checkForm.php","Hi ha hagut un error a l'hora d'actualitzar una enquesta\n",$_SESSION['user'][2]);
    }
}

function removeAvailabilityOfQuestion($idQuestion){
    try {
        $notAvailable = 0;

        $pdo = connectionBBDD();
        $pdo->beginTransaction();
        $stmn = $pdo->prepare("UPDATE creyentes_poll.question SET `available`=? WHERE id=?;");
        $stmn->bindParam(1,$notAvailable);
        $stmn->bindParam(2,$idQuestion);
        $stmn->execute();
        $pdo->commit();
        logButtonClick("S","checkForm.php","UPDATE `question` SET `available`={$available} WHERE id={$idQuestion}\n",$_SESSION['user'][2]);

    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
        } 
        logButtonClick("E","checkForm.php","Hi ha hagut un error a l'hora d'esborrar una pregunta\n",$_SESSION['user'][2]);
    }
}

function removeAvailabilityOfPoll($idPoll){
    try {
        $notAvailable = 0;

        $pdo = connectionBBDD();
        $pdo->beginTransaction();
        $stmn = $pdo->prepare("UPDATE creyentes_poll.poll SET `available`=? WHERE id=?;");
        $stmn->bindParam(1,$notAvailable);
        $stmn->bindParam(2,$idPoll);
        $stmn->execute();
        $pdo->commit();
        logButtonClick("S","checkForm.php","UPDATE `poll` SET `available`={$available} WHERE id={$idPoll}\n",$_SESSION['user'][2]);

    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
        } 
        logButtonClick("E","checkForm.php","Hi ha hagut un error a l'hora d'esborrar una enquesta\n",$_SESSION['user'][2]);
    }
}

function sendRecoverPass($correu){
    $arrayUser = getListByQuery("SELECT * from creyentes_poll.user u WHERE u.email ='".$correu."'")[0];
    logButtonClick("S","checkForm.php","SELECT * from creyentes_poll.user u WHERE u.email ='".$correu."'");

    if (!$arrayUser) {
        logButtonClick("W","forgot_password.php","Email de recuperació de contrasenya a email inexistent\n",$correu);
        array_push($_SESSION["errors"],["succes","Si l\'usuari existeix s\'ha enviat un correu de recuperació a ".$correu]);
        header("Location: forgot_password.php");
        return;
    }

    $codedIdentifier = md5("aoa_forms-".$arrayUser["id"]."-recPass");

    // Create a new PHPMailer object
    $mail = new PHPMailer;
    // Set up SMTP
    $mail->isSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->Username = 'asastremoreno.cf@iesesteveterradas.cat';
    $mail->Password =                                                                                                                                                                                                                      'canasta2000';

    // Set the sender and recipient
    $mail->addAddress($correu);

    // Set the subject and body
    $mail->Subject = "Recuperació de Contrasenya";
    $mail->Body = "
        Hola ".$arrayUser['username'].",

        Has oblidat la teva contrasenya?
        Hem rebut una petició per a restablir la contrasenya del teu compte.

        Per a resetejarla fes clic en el següent enllaç:
        http://localhost/aoa_forms/forgot_password.php?id=".$arrayUser['id']."&codeIdentifier=".$codedIdentifier;


    // Send the email
    if ($mail->send()) {

        logButtonClick("S","forgot_password.php","Email de recuperació de contrasenya enviat correctament\n",$correu);
        array_push($_SESSION["errors"],["succes","Si l\'usuari existeix s\'ha enviat un correu de recuperació a ".$correu]);
        header("Location: forgot_password.php");
    } else {
        echo 'Error: ' . $mail->ErrorInfo;
    }
}

function recoverPassword($idUser, $newPass){
    try {
        $pdo = connectionBBDD();
        $pdo->beginTransaction();
        $stmn = $pdo->prepare("UPDATE creyentes_poll.user u SET u.password = SHA2(?,512) WHERE id=?;");
        $stmn->bindParam(1,$newPass);
        $stmn->bindParam(2,$idUser);
        $stmn->execute();
        $pdo->commit();
        array_push($_SESSION["errors"],["succes","Contrasenya actualitzada"]);
        logButtonClick("S","checkForm.php","UPDATE creyentes_poll.user u SET u.password = SHA2(?,512) WHERE id=?;\n",$idUser);

    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
        } 
        logButtonClick("E","checkForm.php","Hi ha hagut un error a l'hora de canviar la contrasenya\n",$_SESSION['user'][2]);
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

                    if (isset($_POST["idQuestionEdit"])) {
                        editNumberQuestion($_POST["questionType"], $_POST["questionTitle"], $_POST["idQuestionEdit"] );
                    }
                    else{
                        saveNumberQuestion($_POST["questionType"], $_POST["questionTitle"]);
                    }
                    logButtonClick("S","checkForm.php","La pregunta del tipus 'Numeric' s'ha desat correctament\n",$_SESSION['user'][2]);
                    break;

                case 2:   //Question type text      

                    if (isset($_POST["idQuestionEdit"])) {
                        editTextQuestion($_POST["questionType"], $_POST["questionTitle"], $_POST["idQuestionEdit"] );
                    }
                    else{
                        saveTextQuestion($_POST["questionType"], $_POST["questionTitle"]);
                    }      
                    logButtonClick("S","checkForm.php","La pregunta del tipus 'Text' s'ha desat correctament\n",$_SESSION['user'][2]);
                    break;
                    
                case 3:   //Question type simple option

                    if (isset($_POST["idQuestionEdit"])) {
                        editSimpleOptionQuestion($_POST["questionType"], $_POST["questionTitle"], $_POST['inputOptions'], $_POST["idQuestionEdit"] );
                    }
                    else{
                        saveSimpleOptionQuestion($_POST["questionType"], $_POST["questionTitle"], $_POST['inputOptions']);
                    }  
                    logButtonClick("S","checkForm.php","La pregunta del tipus 'Opció Simple' s'ha desat correctament\n",$_SESSION['user'][2]);
                    break;
            }
            array_push($_SESSION["errors"],["succes","La pregunta ha estat creada"]);
            break;
        
        case 'createPoll':
            if (isset($_POST["idPollEdit"])) {
                editPoll($_POST["pollTitle"], $_POST["inputStartDate"], $_POST["inputEndDate"], $_POST["inputTeachersId"], $_POST["inputQuestionsId"], $_POST["inputStudentsId"], $_POST["idPollEdit"]);
            }
            else{
                savePoll($_POST["pollTitle"], $_POST["inputStartDate"], $_POST["inputEndDate"], $_POST["inputTeachersId"], $_POST["inputQuestionsId"], $_POST["inputStudentsId"]);
            } 
            logButtonClick("S","checkForm.php","La enquesta s'ha desat correctament\n",$_SESSION['user'][2]);
            array_push($_SESSION["errors"],["succes","La enquesta ha estat creada"]);
            break;
    }
    header("Location: poll.php");

}
else if(isset($_POST["removeElement"])){ 
    switch ($_POST["removeElement"]) {

        case 'question':
            removeAvailabilityOfQuestion($_POST["removeIdQuestion"]);
            logButtonClick("S","checkForm.php","S'ha esborrat la pregunta correctament\n",$_SESSION['user'][2]);
            array_push($_SESSION["errors"],["succes","La pregunta ha estat esborrada"]);
            break;
        
        case 'poll':
            removeAvailabilityOfPoll($_POST["removeIdPoll"]);
            logButtonClick("S","checkForm.php","S'ha esborrat l'enquesta correctament\n",$_SESSION['user'][2]);
            array_push($_SESSION["errors"],["succes","La enquesta ha estat esborrada"]);
            break;
    }
    header("Location: poll.php");

}
else if(isset($_POST["inputForgotPass"])){
    sendRecoverPass($_POST["inputForgotPass"]);
}
else if (isset($_POST["idRecoverPass"])) {
    recoverPassword($_POST["idRecoverPass"], $_POST["inputRecoverPass"]);
    header("Location: login.php");
}

?>