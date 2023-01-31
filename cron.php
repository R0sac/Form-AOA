<?php
    include('utilities.php');
    include "log.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

// Require the composer autoloader
    require 'vendor/autoload.php';

    $arrayEmailStudents= [];
    $arrayNameStudents=[];
    $arrayIdPoll= [];
    $arrayTitlePoll= [];
    $arrayIdStudent= [];
    try{
        $pdo = connectionBBDD();
        $stmt = $pdo ->prepare("SELECT poll.id AS idPoll, user.email AS email, user.username AS username, poll.title AS titlePoll, user.id AS idUser FROM ((poll_student INNER JOIN poll ON poll_student.idPoll = poll.id)INNER JOIN creyentes_poll.user ON poll_student.idStudent= user.id) WHERE poll.available= 1 AND user.role=3 AND poll_student.studentNotificated IS NULL;");
        $stmt->execute();
        $row = $stmt->fetch();
        while($row){
            array_push($arrayIdPoll, $row['idPoll']);
            array_push($arrayNameStudents, $row['username']);
            array_push($arrayEmailStudents, $row['email']);
            array_push($arrayTitlePoll, $row['titlePoll']);
            array_push($arrayIdStudent, $row['idUser']);
            $row = $stmt->fetch();
        };
        logButtonClick("S","cron.php","SELECT poll.id AS idPoll, user.email AS email, user.username AS username, poll.title AS titlePoll, user.id AS idUser FROM ((poll_student INNER JOIN poll ON poll_student.idPoll = poll.id)INNER JOIN creyentes_poll.user ON poll_student.idStudent= user.id) WHERE poll.available= 1 AND user.role=3 AND poll_student.studentNotificated IS NULL;"."\n");
    }
    catch (PDOException $e) {
        if ($pdo->inTransaction())
        {
           $pdo->rollBack();
        }
        logButtonClick("E","cron.php","Ha hagut un error en el Select\n");
    }



    print_r($arrayEmailStudents);
    echo "<br>";
    print_r($arrayNameStudents);
    echo "<br>";
    print_r($arrayIdPoll);
    echo "<br>";
    print_r($arrayIdStudent);

    // for($i=0;$i<5;$i++){
    //     if(count($arrayNameStudents)== $i){
    //         logButtonClick("S","cron.php","Ja no hi ha alumnes amb enquestes pendents\n");
    //         break;
    //     };

    //     try {
    //         $token = bin2hex(random_bytes(64));
    //         $idPoll= $arrayIdPoll[$i];
    //         $idStudent= $arrayIdStudent[$i];
    //         $pdo = connectionBBDD();
    //         $pdo->beginTransaction();
    //         $stmn = $pdo->prepare("UPDATE creyentes_poll.poll_student SET `studentNotificated`= ? WHERE idPoll= '$idPoll' AND idStudent= '$idStudent';");
    //         $stmn->bindParam(1,$token);
    //         $stmn->execute();
    //         $pdo->commit();
    //         logButtonClick("S","cron.php","UPDATE creyentes_poll.poll_student SET `studentNotificated`= $token WHERE idPoll= '$idPoll' AND idStudent= '$idStudent';"."\n");
    //     } 
    //     catch (PDOException $e) {
    //         if ($pdo->inTransaction())
    //         {
    //            $pdo->rollBack();
    //         }
    //         logButtonClick("E","cron.php","No s'ha pogut insertar un Token a ".$arrayEmailStudents[$i]." ".$arrayNameStudents[$i]."\n");
    //     }
        
    //     $mail = new PHPMailer;
    //     // Set up SMTP
    //     $mail->isSMTP();
    //     $mail->Mailer = "smtp";
    //     $mail->SMTPAuth = true;
    //     $mail->SMTPSecure = 'tls';
    //     $mail->Host = 'smtp.gmail.com';
    //     $mail->Port = 587;
    //     $mail->Username = 'asastremoreno.cf@iesesteveterradas.cat';
    //     $mail->Password =                                                                                                                                                                                                                      'canasta2000';

    //     // Set the sender and recipient
    //     $mail->addAddress($arrayEmailStudents[$i]);

    //     // Set the subject and body
    //     $mail->Subject = "Enquestes Pendents";
    //     $mail->Body = "
    //     Hola ".$arrayNameStudents[$i].",

    //     Tens pendent enquestes
    //     ";
        
    //     if ($mail->send()) {
    //         logButtonClick("S","cron.php","S'ha enviat correctament un missatge a ".$arrayEmailStudents[$i]." ".$arrayNameStudents[$i]."\n");
            
    //     } else {
    //         echo 'Error: ' . $mail->ErrorInfo;
    //         logButtonClick("E","cron.php","No s'ha enviat correctament un missatge a ".$arrayEmailStudents[$i]."\n");
    //     };

    // };

?>