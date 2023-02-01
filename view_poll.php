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
    try{
        $accesToPoll= 0;
        $pdo = connectionBBDD();
        $stmt = $pdo ->prepare("SELECT studentNotificated AS token FROM poll_student WHERE studentNotificated IS NOT NULL;");
        $stmt->execute();
        $row = $stmt->fetch();
        while($row){
            if($row['token']== $token){
                $accesToPoll= 1;//AÑADIR LA ENCUESTA
                echo "SUCCES";
                break;
            }

            else{
                $accesToPoll= 0;
            }
            $row = $stmt->fetch();
        };
        //logButtonClick("S","cron.php","SELECT poll_student.idStudent AS idStudent FROM ((poll_student INNER JOIN poll ON poll_student.idPoll = poll.id)INNER JOIN creyentes_poll.user ON poll_student.idStudent= user.id) WHERE poll.available= 1 AND user.role=3 AND poll_student.studentNotificated IS NULL GROUP BY poll_student.idStudent LIMIT 5;"."\n");
    }
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
        $pdo->rollBack();
        }
        //logButtonClick("E","cron.php","Ha hagut un error a l'hora de fer el Select\n");
    };

    if($accesToPoll==0){
        header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ');
    };

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