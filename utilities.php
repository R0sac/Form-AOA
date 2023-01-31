<?php
if(!isset($_SESSION["arrayNameBreadcrumb"])){
    $_SESSION["arrayNameBreadcrumb"]= [];
    $_SESSION["arrayLinkBreadcrumb"]= [];
}

function connectionBBDD(){
    try {
        $hostname = "localhost";
        $dbname = "creyentes_poll";
        $username = "root";
        $pw = "";
        $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
        return $pdo;
    } catch (PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }
};
function issetErrors(){
    if (isset($_SESSION["errors"])){
        return true;
    }else{
        return false;
    }
}

function getListByQuery($query){
    $arrayQuestions = [];
    $pdo = connectionBBDD();
    $stmt = $pdo -> prepare($query);            
    $stmt->execute();
    $row = $stmt->fetch();
    while($row){
        array_push($arrayQuestions, $row);
        $row = $stmt->fetch();
    }
    return $arrayQuestions;
}

//OBTIENE EL NOMBRE DE DEL DOCUMENTO PHP
function getNameLink(){
    $linkPhp= $_SERVER["PHP_SELF"];
    $arrayLinkPhp= explode("/", $linkPhp);
    $nameLinkPhp= end($arrayLinkPhp);
    $nameLink= "";
    for($i=0;$i<strlen($nameLinkPhp);$i++){
        if($nameLinkPhp[$i] == "."){
            break;
        };
        $nameLink= $nameLink.$nameLinkPhp[$i];
    };
    return $nameLink;
};

//CREA LAS MIGAS DE PAN
function breadcrumb($nameLink){
    if($nameLink != "Index"){
        $linkPage= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' 
        ? "https" 
        : "http") 
        . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        foreach ($_SESSION["arrayNameBreadcrumb"] as $num => $value) {
            if(ucfirst($value)==$nameLink){
                $_SESSION["arrayNameBreadcrumb"]= array_slice($_SESSION["arrayNameBreadcrumb"],0,$num);
                $_SESSION["arrayLinkBreadcrumb"]= array_slice($_SESSION["arrayLinkBreadcrumb"],0,$num);
                break;
            }
        }
        array_push($_SESSION["arrayNameBreadcrumb"], $nameLink);
        array_push($_SESSION["arrayLinkBreadcrumb"], $linkPage);
    }
};
?>