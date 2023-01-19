<?php
function createLogFile() {
    $date = date("Y-m-d");
    $fileName = "log_" . $date . ".txt";

    if(!file_exists($fileName)) {
        $file = fopen($fileName, "w");
    }
}

function getLogFileName() {
    $date = date("Y-m-d");
    $fileName = "log_" . $date . ".txt";
    return $fileName;
}

function logButtonClick($button) {
    $fileName = getLogFileName();
    $log = "[" . date("Y-m-d H:i:s") . "]"." Button '". $button ."' clicked \n";
    $file = fopen($fileName, "a+");
    fwrite($file, $log);
    fclose($file);
}

function logUserLogin($username, $password) {
    $fileName = getLogFileName();
    $log = "[" . date("Y-m-d H:i:s") . "] User logged in: " . $username . "\n";
    $file = fopen($fileName, "a+");
    fwrite($file, $log);
    fclose($file);
}

createLogFile();

$button = "miBoton";
$username = "admin";
$password = "admin123";

logButtonClick($button);
logUserLogin($username, $password);

