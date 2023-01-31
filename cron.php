<?php
    include('utilities.php');
    include "log.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

// Require the composer autoloader
    require 'vendor/autoload.php';

    $arrayEmailStudents= [];
    $arrayNameStudents=[];
    $arrayTitlePoll= [];
    $arrayIdStudent= [];
    $infoIdPollStudent= [];
    $infoTitlePollStudent=[];
    $infoTokensStudent= [];
    try{
        $pdo = connectionBBDD();
        $stmt = $pdo ->prepare("SELECT poll_student.idStudent AS idStudent, user.email AS email, user.username AS username FROM ((poll_student INNER JOIN poll ON poll_student.idPoll = poll.id)INNER JOIN creyentes_poll.user ON poll_student.idStudent= user.id) WHERE poll.available= 1 AND user.role=3 AND poll_student.studentNotificated IS NULL GROUP BY poll_student.idStudent LIMIT 5;");
        $stmt->execute();
        $row = $stmt->fetch();
        while($row){
            array_push($arrayIdStudent, $row['idStudent']);
            array_push($arrayEmailStudents, $row['email']);
            array_push($arrayNameStudents, $row['username']);
            $idStudent= $row["idStudent"];
            $stmt2 = $pdo ->prepare("SELECT poll_student.idPoll AS idPoll, poll.title AS title FROM (poll_student INNER JOIN poll ON poll_student.idPoll = poll.id) WHERE poll.available= 1 AND poll_student.studentNotificated IS NULL AND poll_student.idStudent= $idStudent;");
            $stmt2->execute();
            $row2 = $stmt2->fetch();
            $arrayIdPollStudent= [];
            $arrayTitlePollStudent= [];
            $arrayTokensStudent=[];
            while($row2){
                $idPoll= $row2['idPoll'];
                array_push($arrayIdPollStudent, $idPoll);
                array_push($arrayTitlePollStudent, $row2['title']);

                try{
                    $token = bin2hex(random_bytes(64));
                    array_push($arrayTokensStudent, $token);
                    $pdo->beginTransaction();
                    $stmn3 = $pdo->prepare("UPDATE creyentes_poll.poll_student SET `studentNotificated`= ? WHERE idPoll= '$idPoll' AND idStudent= '$idStudent';");
                    $stmn3->bindParam(1,$token);
                    $stmn3->execute();
                    $pdo->commit();
                    logButtonClick("S","cron.php","UPDATE creyentes_poll.poll_student SET `studentNotificated`= $token WHERE idPoll= '$idPoll' AND idStudent= '$idStudent';"."\n");

                }
                catch (PDOException $e) {
                    if ($pdo->inTransaction())
                    {
                       $pdo->rollBack();
                    }
                    logButtonClick("E","cron.php","No s'ha pogut insertar un Token a ".$arrayEmailStudents[$i]." ".$arrayNameStudents[$i]."\n");
                }
                $row2 = $stmt2->fetch();
            };
            $infoIdPollStudent[$idStudent]= $arrayIdPollStudent;
            $infoTitlePollStudent[$idStudent]= $arrayTitlePollStudent;
            $infoTokensStudent[$idStudent]= $arrayTokensStudent;
            $row = $stmt->fetch();
        };
        logButtonClick("S","cron.php","SELECT poll_student.idStudent AS idStudent FROM ((poll_student INNER JOIN poll ON poll_student.idPoll = poll.id)INNER JOIN creyentes_poll.user ON poll_student.idStudent= user.id) WHERE poll.available= 1 AND user.role=3 AND poll_student.studentNotificated IS NULL GROUP BY poll_student.idStudent LIMIT 5;"."\n");
    }
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
        }
        logButtonClick("E","cron.php","Ha hagut un error a l'hora de fer el Select\n");
    };

    print_r($arrayIdStudent);
    echo "<br>";
    print_r($infoIdPollStudent);
    echo "<br>";
    print_r($infoTitlePollStudent);
    echo "<br>";
    print_r($arrayEmailStudents);

    foreach ($arrayIdStudent as $num => $ids) {
        $textMail= "";
        for($i=0;$i<count($infoIdPollStudent[$ids]);$i++){
            $title= $infoTitlePollStudent[$ids][$i];
            $getToken= $infoTokensStudent[$ids][$i];
            $textMail= $textMail.$title.": http://localhost/GIT/Form-AOA/prueba.php?token=".$getToken."\n\n";
        };

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
        $mail->addAddress($arrayEmailStudents[$num]);

        // Set the subject and body
        $mail->Subject = "ENQUESTES PENDENTS";
        $mail->Body = "
        Hola ".$arrayNameStudents[$num].",

        Tens pendent les següents enquestes:\n
        ".$textMail."
        ";
        
        if ($mail->send()) {
            logButtonClick("S","cron.php","S'ha enviat correctament un missatge a ".$arrayEmailStudents[$num]." ".$arrayNameStudents[$num]."\n");
            
        } else {
            echo 'Error: ' . $mail->ErrorInfo;
            logButtonClick("E","cron.php","No s'ha enviat correctament un missatge a ".$arrayEmailStudents[$num]."\n");
        };
    };

    // for($i=0;$i<5;$i++){
    //     if(count($arrayIdPollStudent)== $i){
    //         logButtonClick("S","cron.php","Ja no hi ha alumnes amb enquestes pendents\n");
    //         break;
    //     };
    // };

?>