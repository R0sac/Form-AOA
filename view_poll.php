<?php 
$_GET['Titulo'] = 'Respondre Enquesta';
$_GET['idBody'] = 'bodyViewPoll';
$_GET['logout'] = ' ';
?>
<?php include "header.php";
$_SESSION["locationLogout"]= "view_poll.php";
include "log.php";
// logButtonClick("S","poll.php","S'ha entrat a 'View_Poll' correctament\n",$_SESSION['user'][2]);?>
<script src="./view_poll.js"></script>
<?php
    $query = "SELECT p.title,q.id AS idQuestion,q.text AS question,q.idTypeQuestion,o.*
    FROM creyentes_poll.user u 
    INNER JOIN poll_student ps ON u.id = ps.idStudent 
    INNER JOIN poll p ON ps.idPoll = p.id 
    INNER JOIN poll_question pq ON p.id = pq.idPoll 
    INNER JOIN question q ON pq.idQuestion = q.id 
    LEFT OUTER JOIN question_option qo ON q.id = qo.idQuestion 
    LEFT OUTER JOIN creyentes_poll.option o ON qo.idOption = o.id 
    WHERE u.role= 3 AND u.id= 4 AND p.id = 28;"; 

    $results = getListByQuery($query);
    logButtonClick("S","View_Poll.php","$query'\n");
    $cont = count($results);
    echo 
    "<script>
        var arrayPoll = ".json_encode($results).";
    </script>";
?>
<h1 id="titlePoll"></h1>
<div id="pollContent" class="pollContent">
    <form id="formViewPoll" action="./checkForm.php" method="POST">

    </form>
</div>
<script>
    $(function() {
        $(`#titlePoll`).text(arrayPoll[0].title);
        var idOption = 0;
        printQuestion(idOption, arrayPoll);


    });
</script>
<?php include "footer.php"; ?>