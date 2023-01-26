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
        $available = true;

        $pdo = connectionBBDD();
        $pdo->beginTransaction();
        $stmn = $pdo->prepare("INSERT INTO `question` (`text`, `idTypeQuestion`,`available`) VALUES (?,?,?)");
        $stmn->bindParam(1,$questionTitle);
        $stmn->bindParam(2,$typeQuestion);
        $stmn->bindParam(3,$available);
        $stmn->execute();
        $pdo->commit();
    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
        } 
        // TODO poner mensaje error
    }
}

function editTextQuestion($typeQuestion, $questionTitle, $idQuestionToEdit){
    try {
        $available = true;
        $notAvailable = false;

        $pdo = connectionBBDD();
        $pdo->beginTransaction();

        $stmn = $pdo->prepare("UPDATE `question` SET `available`=? WHERE id=?");
        $stmn->bindParam(1,$notAvailable);
        $stmn->bindParam(2,$idQuestionToEdit);
        $stmn->execute();

        $stmn = $pdo->prepare("INSERT INTO `question` (`text`, `idTypeQuestion`,`available`) VALUES (?,?,?)");
        $stmn->bindParam(1,$questionTitle);
        $stmn->bindParam(2,$typeQuestion);
        $stmn->bindParam(3,$available);
        $stmn->execute();
        $pdo->commit();
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
        $available = true;

        $pdo = connectionBBDD();
        $pdo->beginTransaction();

        $stmn = $pdo->prepare("INSERT INTO `question` (`text`, `idTypeQuestion`,`available`) VALUES (?,?,?)");
        $stmn->bindParam(1,$questionTitle);
        $stmn->bindParam(2,$typeQuestion);
        $stmn->bindParam(3,$available);
        $stmn->execute();

        $lastId = $pdo->lastInsertId();
        
        $arrayOptions = [1,2,3,4,5];
        foreach ($arrayOptions as $key => $value) {
            $stmn = $pdo->prepare("INSERT INTO question_option (idQuestion,idOption) values (?, ?);");
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

function editNumberQuestion($typeQuestion, $questionTitle, $idQuestionToEdit){
    try {
        $available = true;
        $notAvailable = false;


        $pdo = connectionBBDD();
        $pdo->beginTransaction();

        $stmn = $pdo->prepare("UPDATE `question` SET `available`=? WHERE id=?");
        $stmn->bindParam(1,$notAvailable);
        $stmn->bindParam(2,$idQuestionToEdit);
        $stmn->execute();

        $stmn = $pdo->prepare("INSERT INTO `question` (`text`, `idTypeQuestion`,`available`) VALUES (?,?,?)");
        $stmn->bindParam(1,$questionTitle);
        $stmn->bindParam(2,$typeQuestion);
        $stmn->bindParam(3,$available);
        $stmn->execute();

        $lastId = $pdo->lastInsertId();
        
        $arrayOptions = [1,2,3,4,5];
        foreach ($arrayOptions as $key => $value) {
            $stmn = $pdo->prepare("INSERT INTO question_option (idQuestion,idOption) values (?, ?);");
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
        $available = true;

        $pdo = connectionBBDD();
        $pdo->beginTransaction();

        $stmn = $pdo->prepare("INSERT INTO `question` (`text`, `idTypeQuestion`,`available`) VALUES (?,?,?)");
        $stmn->bindParam(1,$questionTitle);
        $stmn->bindParam(2,$typeQuestion);
        $stmn->bindParam(3,$available);
        $stmn->execute();

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
    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
        } 
    }
}

function editSimpleOptionQuestion($typeQuestion, $questionTitle, $arrayOptions, $idQuestionToEdit){
    try {        
        $available = true;
        $notAvailable = false;


        $pdo = connectionBBDD();
        $pdo->beginTransaction();

        $stmn = $pdo->prepare("UPDATE `question` SET `available`=? WHERE id=?");
        $stmn->bindParam(1,$notAvailable);
        $stmn->bindParam(2,$idQuestionToEdit);
        $stmn->execute();


        $stmn = $pdo->prepare("INSERT INTO `question` (`text`, `idTypeQuestion`,`available`) VALUES (?,?,?)");
        $stmn->bindParam(1,$questionTitle);
        $stmn->bindParam(2,$typeQuestion);
        $stmn->bindParam(3,$available);

        $stmn->execute();

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
    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
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

        $lastIdOfPoll = $pdo->lastInsertId();

        // SAVING TEACHERS OF POLL
        foreach ($arrayTeachersId as $key => $idTeacher) {
            $stmn = $pdo->prepare("INSERT INTO `poll_teacher` (`idPoll`, `idTeacher`) values (?,?);");
            $stmn -> bindParam(1, $lastIdOfPoll);
            $stmn -> bindParam(2, $idTeacher);
            $stmn->execute();
        };

        // SAVING QUESTIONS OF POLL
        foreach ($arrayQuestionsId as $key => $idQuestion) {
            $stmn = $pdo->prepare("INSERT INTO `poll_question` (`idPoll`, `idQuestion`) values (?,?);");
            $stmn -> bindParam(1, $lastIdOfPoll);
            $stmn -> bindParam(2, $idQuestion);
            $stmn->execute();
        };

        // SAVING STUDENTS OF POLL
        foreach ($arrayStudentsId as $key => $idStudent) {
            $stmn = $pdo->prepare("INSERT INTO `poll_student` (`idPoll`, `idStudent`) values (?,?);");
            $stmn -> bindParam(1, $lastIdOfPoll);
            $stmn -> bindParam(2, $idStudent);
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

function editPoll($pollTitle, $startDate, $endDate, $arrayTeachersId, $arrayQuestionsId, $arrayStudentsId, $idPollToEdit){
    try {

        $actualDate = date('d-m-y h:i:s');
        $startDate = convertDateToDatetime($startDate);
        $endDate = convertDateToDatetime($endDate);
        $available = true;
        $notAvailable = false;

        $pdo = connectionBBDD();
        $pdo->beginTransaction();

        $stmn = $pdo->prepare("UPDATE `poll` SET `available`=? WHERE id=?");
        $stmn->bindParam(1,$notAvailable);
        $stmn->bindParam(2,$idPollToEdit);
        $stmn->execute();

        // SAVING POLL
        $stmn = $pdo->prepare("INSERT INTO `poll` (`title`, `createdAt`,`startDate`,`endDate`,`available`) VALUES (?,?,?,?,?)");
        $stmn->bindParam(1,$pollTitle);
        $stmn->bindParam(2,$actualDate);
        $stmn->bindParam(3,$startDate);
        $stmn->bindParam(4,$endDate);
        $stmn->bindParam(5,$available);

        $stmn->execute();

        $lastIdOfPoll = $pdo->lastInsertId();

        // SAVING TEACHERS OF POLL
        foreach ($arrayTeachersId as $key => $idTeacher) {
            $stmn = $pdo->prepare("INSERT INTO `poll_teacher` (`idPoll`, `idTeacher`) values (?,?);");
            $stmn -> bindParam(1, $lastIdOfPoll);
            $stmn -> bindParam(2, $idTeacher);
            $stmn->execute();
        };

        // SAVING QUESTIONS OF POLL
        foreach ($arrayQuestionsId as $key => $idQuestion) {
            $stmn = $pdo->prepare("INSERT INTO `poll_question` (`idPoll`, `idQuestion`) values (?,?);");
            $stmn -> bindParam(1, $lastIdOfPoll);
            $stmn -> bindParam(2, $idQuestion);
            $stmn->execute();
        };

        // SAVING STUDENTS OF POLL
        foreach ($arrayStudentsId as $key => $idStudent) {
            $stmn = $pdo->prepare("INSERT INTO `poll_student` (`idPoll`, `idStudent`) values (?,?);");
            $stmn -> bindParam(1, $lastIdOfPoll);
            $stmn -> bindParam(2, $idStudent);
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

function removeAvailabilityOfQuestion($idQuestion){
    try {
        $available = false;

        $pdo = connectionBBDD();
        $pdo->beginTransaction();
        $stmn = $pdo->prepare("UPDATE `question` SET `available`=? WHERE id=?");
        $stmn->bindParam(1,$available);
        $stmn->bindParam(2,$idQuestion);
        $stmn->execute();
        $pdo->commit();
    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
        } 
        // TODO poner mensaje error
    }
}

function removeAvailabilityOfPoll($idPoll){
    try {
        $available = false;

        $pdo = connectionBBDD();
        $pdo->beginTransaction();
        $stmn = $pdo->prepare("UPDATE `poll` SET `available`=? WHERE id=?");
        $stmn->bindParam(1,$available);
        $stmn->bindParam(2,$idPoll);
        $stmn->execute();
        $pdo->commit();
    } 
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
        } 
        // TODO poner mensaje error
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
                    // TO DO meter log de envío de pregunta realizado correctamente
                    break;

                case 2:   //Question type text      

                    if (isset($_POST["idQuestionEdit"])) {
                        editTextQuestion($_POST["questionType"], $_POST["questionTitle"], $_POST["idQuestionEdit"] );
                    }
                    else{
                        saveTextQuestion($_POST["questionType"], $_POST["questionTitle"]);
                    }      
                    // TO DO meter log de envío de pregunta realizado correctamente
                    break;
                    
                case 3:   //Question type simple option

                    if (isset($_POST["idQuestionEdit"])) {
                        editSimpleOptionQuestion($_POST["questionType"], $_POST["questionTitle"], $_POST['inputOptions'], $_POST["idQuestionEdit"] );
                    }
                    else{
                        saveSimpleOptionQuestion($_POST["questionType"], $_POST["questionTitle"], $_POST['inputOptions']);
                    }  

                    // TO DO meter log de envío de pregunta realizado correctamente
                    break;
            }

            break;
        
        case 'createPoll':
            if (isset($_POST["idPollEdit"])) {
                editPoll($_POST["pollTitle"], $_POST["inputStartDate"], $_POST["inputEndDate"], $_POST["inputTeachersId"], $_POST["inputQuestionsId"], $_POST["inputStudentsId"], $_POST["idPollEdit"]);
            }
            else{
                savePoll($_POST["pollTitle"], $_POST["inputStartDate"], $_POST["inputEndDate"], $_POST["inputTeachersId"], $_POST["inputQuestionsId"], $_POST["inputStudentsId"]);
            }  
            break;
    }
    header("Location: poll.php");

}
else if(isset($_POST["removeElement"])){ 
    switch ($_POST["removeElement"]) {

        case 'question':
            removeAvailabilityOfQuestion($_POST["removeIdQuestion"]);
            break;
        
        case 'poll':
            removeAvailabilityOfPoll($_POST["removeIdPoll"]);
            break;
    }
    header("Location: poll.php");

}


?>