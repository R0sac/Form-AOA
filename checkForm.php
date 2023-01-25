<?php session_start();
include('utilities.php');
include "log.php";//
$_SESSION["errors"] = array();
function logIn(){
    $user = htmlspecialchars($_POST['user']);
    $pass = htmlspecialchars($_POST['pass']);

    $pdo = connectionBBDD();
    $stmt = $pdo ->prepare("SELECT * FROM user u WHERE u.email = ? AND u.password =  sha2(?,512);");            
    $stmt->bindParam(1,$user);
    $stmt->bindParam(2,$pass);
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row){
        $_SESSION["user"] = [$row["id"],$row["email"],$row["username"],intval($row["role"])];
        logButtonClick("S","login.php","S'ha iniciat la sessió correctament\n",$_SESSION['user'][2]);//
        header('Location: dashboard.php');
    }else{
        array_push($_SESSION["errors"],["error","Credencials incorrectes"]);
        logButtonClick("E","login.php","Credencials incorrectes\n");//
        header('Location: login.php');
    }
}
if(isset($_POST["user"] ) && isset($_POST["pass"])){
    logIn();
}
?>