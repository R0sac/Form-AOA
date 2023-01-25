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
    $arrayQuestions = getListByQuery("SELECT * FROM question;");
    $arrayPolls = getListByQuery("SELECT * FROM poll;");
    $arrayTypesOfQuestion = getListByQuery("SELECT * FROM question_type;");
    $arrayOptionsOfTypeNumber = getListByQuery("SELECT * FROM creyentes_poll.option WHERE id <= 5;");
    $arrayTeachersAndStudents = getListByQuery("SELECT * FROM user u WHERE u.role >= 2;");
    $arrayTeachers = [];
    $arrayStudents = [];

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

    echo "<script>
        var arrayQuestions = ".json_encode($arrayQuestions).";\n;
        var arrayPolls = ".json_encode($arrayPolls).";\n;
        var arrayTypesOfQuestion = ".json_encode($arrayTypesOfQuestion).";\n;
        var arrayOptionsOfTypeNumber =  ".json_encode($arrayOptionsOfTypeNumber).";\n;
        var arrayTeachers = ".json_encode($arrayTeachers).";
        var arrayStudents = ".json_encode($arrayStudents).";
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
<?php//TODO PHP
    if(isset($_POST['systemLogSelector'])){
        $selector= $_POST['systemLogSelector'];
        $selectorName= $arrayTypesOfQuestion[$selector-1][1];
        $inputTitle= $_POST['systemLogInput'];
        logButtonClick("S","poll.php","El tipus de la nova pregunta es: '{$selectorName}'\n",$_SESSION['user'][2]);
        logButtonClick("S","poll.php","L'enunciat de la nova pregunta es: '{$inputTitle}'\n",$_SESSION['user'][2]);
        logButtonClick("S","poll.php","S'ha creat una nova pregunta correctament\n",$_SESSION['user'][2]);
    };

    // if(isset($_POST['systemLogInputTitlePoll'])){
    //     $inputTitle= $_POST['systemLogInputTitlePoll'];
    //     logButtonClick("S","poll.php","Per crear una enquesta l'enunciat es: '{$inputTitle}'\n",$_SESSION['user'][2]);
    //     logButtonClick("S","poll.php","S'ha creat una nova enquesta correctament'\n",$_SESSION['user'][2]);
    // }
?>
<?php include "footer.php"; ?>