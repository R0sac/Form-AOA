<?php session_start();
include('utilities.php');
$_SESSION["errors"] = array();
function logIn(){
    $pdo = connectionBBDD();
    $stmt = $pdo ->prepare("SELECT * FROM usuaris WHERE usuari = ? AND contrasenya =  sha2(?,512);");            
    $stmt->bindParam(1,htmlspecialchars($_POST['user']));
    $stmt->bindParam(2,htmlspecialchars($_POST['pass']));
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row){
        $_SESSION["usuario"] = [$row["usuari"],$row["rol"]];
        header('Location: dashboard.php');
    }else{
        array_push($_SESSION["errors"],["error","Credencials incorrectes"]);
        header('Location: login.php');
    }
}
if(isset($_POST["user"] ) && isset($_POST["pass"])){
    logIn();
}
?>