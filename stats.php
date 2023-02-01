<?php 
$_GET['Titulo'] = 'Estadistiques';
$_GET['idBody'] = 'bodyStats';
$_GET['logout'] = '';
?>
<?php include "header.php";
$_SESSION["locationLogout"]= "stats.php";
include "log.php";
logButtonClick("S","stats.php","S'ha entrat a 'Stats' correctament\n",$_SESSION['user'][2]);?>
<?php
    $mail = $_SESSION["user"][1];
    $query = "select p.id,p.title as TituloEncuesta,pt.idTeacher,u.role,u.username,u.email from poll p inner join poll_teacher pt on p.id = pt.idPoll inner join creyentes_poll.user u on pt.idTeacher = u.id where p.available = 1 and email='$mail';";
    $results = getListByQuery($query);
    logButtonClick("S","View_Poll.php","$query'\n");
    echo "<h1 id='usuerName'>".$_SESSION['user'][2]."</h1>";
    echo "<div class='autocenter'>\n<div class='pollContent'>\n<ul>\n";
    for ($i=0; $i < count($results); $i++) {
        echo "<li href=''>".$results[$i]["TituloEncuesta"]."</li>\n";
    }
    echo "</ul>\n</div>\n</div>";
?>
<?php include "footer.php"; ?>