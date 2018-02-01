<?php

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "Illusion16");
define("DB_NAME", "file_backup");

function db_connect() {
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    return $connection;
}
function db_disconnect() {
    if(isset($connection)) {
        mysqli_close($connection);
    }
}

?>
