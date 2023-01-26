
<?php
    session_start();
    include "log.php";
    $locationLogout= $_SESSION["locationLogout"];
    logButtonClick("S","logout.php","S'ha sortit de la sessió correctament des de '{$locationLogout}'\n",$_SESSION['user'][2]);
    session_destroy();
    header("Location: login.php");
?>