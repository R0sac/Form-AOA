<?php
function connectionBBDD(){
    try {
        $hostname = "localhost";
        $dbname = "EnquestaProfessors";
        $username = "admin";
        $pw = "admin123";
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
?>