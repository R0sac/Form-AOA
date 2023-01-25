<?php
function logButtonClick($typeLog, $locationLog, $textLog, $useLog='') {
    $fileName = getLogFileName();
    $log = "[".date("Y-m-d H:i:s")."][".$typeLog."][".$locationLog."][".$useLog."] ".$textLog;
    $file = fopen($fileName, "a+");
    fwrite($file, $log);
    fclose($file);
}

function getLogFileName() {
    $date = date("Y-m-d");
    $fileName = "./logs/log_" . $date . ".txt";
    return $fileName;
}