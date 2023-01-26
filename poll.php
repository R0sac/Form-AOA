<?php 
$_GET['Titulo'] = 'Poll';
$_GET['idBody'] = 'bodyPoll';
$_GET['logout'] = ' ';
?>
<?php include "header.php";
$_SESSION["locationLogout"]= "poll.php";
include "log.php";
logButtonClick("S","poll.php","S'ha entrat a 'Enquestes' correctament\n",$_SESSION['user'][2]);?>

<div id="mensajes"></div>

<script src="./enquestes.js"></script>

<?php
    if(issetErrors()){
        for ($i=0; $i < count($_SESSION["errors"]) ; $i++) {
            echo "<script>NewError('".$_SESSION['errors'][$i][0]."','".$_SESSION['errors'][$i][1]."');</script>";
        }
        $_SESSION["errors"] = array();
    }
    else{
        $_SESSION["errors"] = array();
    }

    $arrayQuestions = getListByQuery("SELECT * FROM question WHERE available = true;");
    $arrayPolls = getListByQuery("SELECT * FROM poll WHERE available = true;");
    $arrayTypesOfQuestion = getListByQuery("SELECT * FROM question_type;");
    $arrayOptions = getListByQuery("SELECT * FROM `option`;");
    $arrayTeachersAndStudents = getListByQuery("SELECT * FROM user u WHERE u.role >= 2;");
    $arrayQuestionOptions = getListByQuery("SELECT * FROM `question_option`;");
    $arrayPollQuestion = getListByQuery("SELECT * FROM `poll_question`;");
    $arrayPollStudent = getListByQuery("SELECT * FROM `poll_student`;");
    $arrayPollTeacher = getListByQuery("SELECT * FROM `poll_teacher`;");
    $arrayTeachers = [];
    $arrayStudents = [];

    $arrayOptionsOfTypeNumber = [];
    // Dividing options of options of number
    for ($i=0; $i < count($arrayOptions); $i++) { 
        if ( intval($arrayOptions[$i]["id"]) <= 5) {
            array_push($arrayOptionsOfTypeNumber,$arrayOptions[$i]);
        }
    }

    // Dividing between teachers and alums
    for ($i=0; $i < count($arrayTeachersAndStudents); $i++) {
        switch ($arrayTeachersAndStudents[$i]["role"]) {
            case 2:
                array_push($arrayTeachers,$arrayTeachersAndStudents[$i]);
                break;
            
            case 3:
                array_push($arrayStudents,$arrayTeachersAndStudents[$i]);
                break;
        }
    }

    $arrayOfQuestionsFiltered = [];
    // Making a dictionary of question_options
    for ($i=0; $i < count($arrayQuestionOptions); $i++) { 
        if ( array_key_exists($arrayQuestionOptions[$i]["idQuestion"], $arrayOfQuestionsFiltered) ) {
            array_push( $arrayOfQuestionsFiltered[$arrayQuestionOptions[$i]["idQuestion"]]   ,$arrayQuestionOptions[$i]["idOption"]);
        }
        else{
            $arrayOfQuestionsFiltered[$arrayQuestionOptions[$i]["idQuestion"]] = [$arrayQuestionOptions[$i]["idOption"]];
        }
    }

    $arrayOfPollQuestionsFiltered = [];
    // Making a dictionary of poll_question
    for ($i=0; $i < count($arrayPollQuestion); $i++) { 
        if ( array_key_exists($arrayPollQuestion[$i]["idPoll"], $arrayOfPollQuestionsFiltered) ) {
            array_push( $arrayOfPollQuestionsFiltered[$arrayPollQuestion[$i]["idPoll"]]   ,$arrayPollQuestion[$i]["idQuestion"]);
        }
        else{
            $arrayOfPollQuestionsFiltered[$arrayPollQuestion[$i]["idPoll"]] = [$arrayPollQuestion[$i]["idQuestion"]];
        }
    }

    $arrayOfPollStudentFiltered = [];
    // Making a dictionary of poll_student
    for ($i=0; $i < count($arrayPollStudent); $i++) { 
        if ( array_key_exists($arrayPollStudent[$i]["idPoll"], $arrayOfPollStudentFiltered) ) {
            array_push( $arrayOfPollStudentFiltered[$arrayPollStudent[$i]["idPoll"]]   ,$arrayPollStudent[$i]["idStudent"]);
        }
        else{
            $arrayOfPollStudentFiltered[$arrayPollStudent[$i]["idPoll"]] = [$arrayPollStudent[$i]["idStudent"]];
        }
    }

    $arrayOfPollTeacherFiltered = [];
    // Making a dictionary of poll_teacher
    for ($i=0; $i < count($arrayPollTeacher); $i++) { 
        if ( array_key_exists($arrayPollTeacher[$i]["idPoll"], $arrayOfPollTeacherFiltered) ) {
            array_push( $arrayOfPollTeacherFiltered[$arrayPollTeacher[$i]["idPoll"]]   ,$arrayPollTeacher[$i]["idTeacher"]);
        }
        else{
            $arrayOfPollTeacherFiltered[$arrayPollTeacher[$i]["idPoll"]] = [$arrayPollTeacher[$i]["idTeacher"]];
        }
    }

    echo "<script>
        var arrayQuestions = ".json_encode($arrayQuestions).";\n;
        var arrayPolls = ".json_encode($arrayPolls).";\n;
        var arrayTypesOfQuestion = ".json_encode($arrayTypesOfQuestion).";\n;
        var arrayOptionsOfTypeNumber =  ".json_encode($arrayOptionsOfTypeNumber).";\n;
        var arrayTeachers = ".json_encode($arrayTeachers).";
        var arrayStudents = ".json_encode($arrayStudents).";
        var arrayQuestionOption = ".json_encode($arrayOfQuestionsFiltered).";
        var arrayOptions = ".json_encode($arrayOptions).";
        var arrayPollQuestion = ".json_encode($arrayOfPollQuestionsFiltered).";
        var arrayPollStudent = ".json_encode($arrayOfPollStudentFiltered).";
        var arrayPollTeacher = ".json_encode($arrayOfPollTeacherFiltered).";
    </script>";
?>

<script>
    $(function() {
        viewListQuestion('#pollContent',arrayQuestions);

        $('#btnCrearPregunta').click(() => {
            createQuestion('#pollContent',arrayTypesOfQuestion);
        });

        $('#btnCrearEncuesta').click(() => {
            createPoll('#pollContent',arrayQuestions, arrayTeachers, arrayStudents);
        });

        $('#btnListarPreguntas').click(() => {
            viewListQuestion('#pollContent',arrayQuestions);
        });

        $('#btnListarEncuestas').click(() =>{
            viewListPoll('#pollContent',arrayPolls);
        });

    });
</script>

<div class="containerPoll">
    <nav class="panel">
        <button id="btnCrearPregunta" class="btnPanelAdmin">Crear Pregunta</button>
        <button id="btnCrearEncuesta" class="btnPanelAdmin">Crear Enquesta</button>
        <button id="btnListarPreguntas" class="btnPanelAdmin">Llistat de Preguntes</button>
        <button id="btnListarEncuestas" class="btnPanelAdmin">Llistat d'Enquestes</button>
    </nav>
    <div class="pollContent" id="pollContent">

    </div>
</div>
<?php include "footer.php"; ?>