<?php session_start(); 
$_SESSION["errors"] = array();
function logIn(){
    $stmt = $pdo ->prepare("SELECT * FROM usuaris WHERE usuari = ? AND contrasenya =  sha2(?,512);");            
    $stmt->bindParam(1,htmlspecialchars($_POST['user']));
    $stmt->bindParam(2,htmlspecialchars($_POST['pass']));
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row){
        $_SESSION["usuario"] = [$row["usuari"],$row["rol"]];
        header('Location: dashboard.php');
    }else{
        $_SESSION["errors"]= array_push($_SESSION["errors"],["error","Usuari o cotrasenya incorrectes"]);
    }
}
if(isset($_POST["user"] ) && isset($_POST["pass"])){
    logIn();
}
?>