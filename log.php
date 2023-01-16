<?php
function create_log_file($file_name, $log_message) {
    $file = fopen($file_name, "a");
    fwrite($file, date("Y-m-d H:i:s") . " - " . $log_message . "\n");
    fclose($file);
}
?>

