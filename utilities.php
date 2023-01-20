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

?>