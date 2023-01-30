<?php 
$_GET['Titulo'] = 'Poll';
$_GET['idBody'] = 'bodyViewPoll';
$_GET['logout'] = ' ';
?>
<?php include "header.php";
$_SESSION["locationLogout"]= "view_poll.php";
include "log.php";
logButtonClick("S","poll.php","S'ha entrat a 'View_Poll' correctament\n",$_SESSION['user'][2]);?>

<?php
    $query = "select p.title,q.id,q.text as Pregunta,q.idTypeQuestion,o.* from creyentes_poll.user u inner join poll_teacher pt on u.id = pt.idPoll inner join poll p on pt.idPoll = p.id inner join poll_question pq on p.id = pq.idPoll inner join question q on pq.idQuestion = q.id inner join question_option qo on q.id = qo.idQuestion inner join creyentes_poll.option o on qo.idOption = o.id where u.role= 3 and u.id= 4 and p.id = 4;"; 
    $results = getListByQuery($query);
    logButtonClick("S","View_Poll.php","$query'\n");
    $cont = count($results);
    echo "<script>

        var array = ".json_encode($results).";
        console.log(array);
    </script>";
?>