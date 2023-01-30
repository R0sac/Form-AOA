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
    $pdo = connectionBBDD();
    $stmt = $pdo ->prepare("SELECT poll.id AS idPoll, user.email AS email, user.username AS username, poll.title AS titlePoll FROM ((poll_student INNER JOIN poll ON poll_student.idPoll = poll.id)INNER JOIN creyentes_poll.user ON poll_student.idStudent= user.id) WHERE poll.available= 1 AND user.role=3;");
    $stmt->execute();
    $row = $stmt->fetch();
    while($row){
        array_push($arrayIdPoll, $row['idPoll']);
        array_push($arrayNameStudents, $row['username']);
        array_push($arrayEmailStudents, $row['email']);
        array_push($arrayTitlePoll, $row['titlePoll']);
        $row = $stmt->fetch();
    };

    for($i=0;$i<5;$i++){
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
        $mail->addAddress($arrayEmailStudents[$i]);

        // Set the subject and body
        $mail->Subject = "Enquestes Pendents";
        $mail->Body = "
        Hola ".$arrayNameStudents[$i].",

        Tens pendent enquestes
        ";
        
        if ($mail->send()) {
            logButtonClick("S","cron.php","S'ha enviat correctament un missatge a ".$arrayEmailStudents[$i]."\n");
            
        } else {
            echo 'Error: ' . $mail->ErrorInfo;
            logButtonClick("E","cron.php","No s'ha enviat correctament un missatge a ".$arrayEmailStudents[$i]."\n");
        };

    };

?>