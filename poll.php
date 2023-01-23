<?php 
$_GET['Titulo'] = 'Poll';
$_GET['idBody'] = 'bodyPoll';
?>
<?php include "header.php"; ?>

<div id="mensajes"></div>

<script src="./enquestes.js"></script>

<?php
    $arrayQuestions = getListByQuery("SELECT * FROM question;");
    $arrayPolls = getListByQuery("SELECT * FROM poll;");
    $arrayTypesOfQuestion = getListByQuery("SELECT * FROM question_type;");
    $arrayOptionsOfTypeNumber = getListByQuery("SELECT * FROM option WHERE id <= 5;");
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
<?php //include "footer.php"; ?>