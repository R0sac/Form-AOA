<?php
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

?>