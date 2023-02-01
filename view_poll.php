<?php 
$_GET['Titulo'] = 'Respondre Enquesta';
$_GET['idBody'] = 'bodyViewPoll';
$_GET['logout'] = ' ';
if(isset($_GET['token'])){
    $token= $_GET['token'];
}

else{
    header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ');
};

include "header.php";
$_SESSION["locationLogout"]= "view_poll.php";
include "log.php";
// logButtonClick("S","poll.php","S'ha entrat a 'View_Poll' correctament\n",$_SESSION['user'][2]);?>
<script src="./view_poll.js"></script>

<?php
        
    $pollOfUser = getListByQuery("SELECT idPoll, idStudent, answerDate FROM poll_student WHERE studentNotificated = '".htmlspecialchars($token)."';");
    logButtonClick("S","cron.php", "SELECT idPoll, idStudent FROM poll_student WHERE studentNotificated = '".htmlspecialchars($token)."';\n");
    if (!$pollOfUser) {
        header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ');
    }

    $userId = $pollOfUser[0]["idStudent"];
    $pollId = $pollOfUser[0]["idPoll"];
    $answered = $pollOfUser[0]["answerDate"];

    if ($answered) {
        $query = 
        "SELECT 
            u.id as userId,
            p.id as idPoll,
            p.title,
            q.id AS idQuestion,
            q.text AS question,
            q.idTypeQuestion,
            o.*,
            a.idOption as optionChoosed,
            a.textAnswer as answerText
        FROM creyentes_poll.user u 
        INNER JOIN poll_student ps ON u.id = ps.idStudent 
        INNER JOIN poll p ON ps.idPoll = p.id 
        INNER JOIN poll_question pq ON p.id = pq.idPoll 
        INNER JOIN question q ON pq.idQuestion = q.id 
        INNER JOIN answer a ON a.idPoll = p.id AND a.idStudent = u.id AND a.idQuestion = q.id
        LEFT OUTER JOIN question_option qo ON q.id = qo.idQuestion 
        LEFT OUTER JOIN creyentes_poll.option o ON qo.idOption = o.id
        WHERE u.id = ".$userId." AND p.id = ".$pollId.";";
        $results = getListByQuery($query);
        logButtonClick("S","View_Poll.php","$query'\n");
        echo 
        "<script>
            var arrayPoll = ".json_encode($results).";
            $(function() {
                $(`#titlePoll`).text(arrayPoll[0].title);
                var idOption = 0;
                printQuestionReadOnly(idOption, arrayPoll);
            });
        </script>";

    }
    else{
        $query = 
        "SELECT 
        p.startDate, 
        p.endDate, 
        u.id as userId, 
        p.startDate, 
        p.endDate, 
        p.id as idPoll, 
        p.title, 
        q.id AS idQuestion, 
        q.text AS question, 
        q.idTypeQuestion, 
        o.*
        FROM creyentes_poll.user u 
        INNER JOIN poll_student ps ON u.id = ps.idStudent 
        INNER JOIN poll p ON ps.idPoll = p.id 
        INNER JOIN poll_question pq ON p.id = pq.idPoll 
        INNER JOIN question q ON pq.idQuestion = q.id 
        LEFT OUTER JOIN question_option qo ON q.id = qo.idQuestion 
        LEFT OUTER JOIN creyentes_poll.option o ON qo.idOption = o.id 
        WHERE u.id= ".$userId." AND p.id = ".$pollId.";"; 
    
        $results = getListByQuery($query);
        logButtonClick("S","View_Poll.php","$query'\n");

        $actualDate = date("Y-m-d H:i:s");

        $startDate = date( "Y-m-d H:i:s", strtotime($results[0]["startDate"]));
        $endDate = date( "Y-m-d H:i:s", strtotime($results[0]["endDate"]));

        if ($actualDate > $endDate) {
            echo 
            "<script>
                var arrayPoll = ".json_encode($results).";
                $(function() {
                    $(`#titlePoll`).text('Aquesta enquesta ha caducat');
                    $(`#pollContent`).append('<p>L\'enquesta estava disponible fins ".date("d-m-Y H:i:s",strtotime($endDate))."</p>');
                });
            </script>";
        }
        else if($actualDate < $startDate ){
            echo 
            "<script>
                var arrayPoll = ".json_encode($results).";
                $(function() {
                    $(`#titlePoll`).text('Encara no està disponible aquesta enquesta');
                    $(`#pollContent`).append('<p>L\'enquesta estarà disponible el ".date("d-m-Y H:i:s",strtotime($startDate))."</p>');
                });
            </script>";
        }
        else{
            echo 
            "<script>
                var arrayPoll = ".json_encode($results).";
                $(function() {
                    $(`#titlePoll`).text(arrayPoll[0].title);
                    var idOption = 0;
                    printQuestion(idOption, arrayPoll);
                });
            </script>";
        }

    }
    
?>
<h1 id="titlePoll"></h1>
<div id="pollContent" class="pollContent">
    <form id="formViewPoll" action="./checkForm.php" method="POST">

    </form>
</div>

<?php include "footer.php"; ?>