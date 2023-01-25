
<?php
    session_start();
    include "log.php";//
    logButtonClick("S","logout.php","S'ha sortit de la sessió correctament\n",$_SESSION['user'][2]);//
    session_destroy();
    header("Location: login.php");
?>