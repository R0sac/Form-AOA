<?php
include('utilities.php');
if(isset($_GET['token'])){
    $token= $_GET['token'];
};

try{
    $pdo = connectionBBDD();
    $stmt = $pdo ->prepare("SELECT studentNotificated AS token FROM poll_student WHERE studentNotificated IS NOT NULL;");
    $stmt->execute();
    $row = $stmt->fetch();
    while($row){
        if($row['token']== $token){
            echo "LINK A OTRA PAGINA";
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

?>