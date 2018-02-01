<!DOCTYPE html>
<?php

require_once('database.php');
$db = db_connect();

$upload_directory = 'uploads/';

if(isset($_POST["submit"])){
                                                    // SQL : file_backup
    $file_name = $_FILES["upload"]["name"];         // CREATE TABLE file_uploads (
    $file_size = $_FILES["upload"]["size"];         // id INT(11) NOT NULL AUTO_INCREMENT,
    $tempname = $_FILES['upload']['tmp_name'];      // Filename VARCHAR(200),
                                                    // Size INT(15),
    $sql = "INSERT INTO file_uploads ";             // PRIMARY KEY (id)
    $sql .= "(Filename, Size) ";                    // );
    $sql .= "VALUES (";
    $sql .= "'" . $file_name . "',";
    $sql .= "'" . $file_size . "'";
    $sql .= ")";

    $result = mysqli_query($db, $sql);

}
function find_all_uploads() {                       //connects to DB and performs query.
                                                    //Finds and returns all rows.
    global $db;
    $sql = "SELECT * FROM file_uploads ";
    $sql .= "ORDER BY id ASC";
    $result = mysqli_query($db, $sql);
    return $result;
}

?>
<html>
    <script>

    </script>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="utf-8">
        <style>

        </style>
    </head>
    <body>
        <div id="outer">
            <form id="form" action="" method="POST" enctype="multipart/form-data">
                <input type="file" id="upload" name="upload">
                <input type="submit" id="submit" name="submit" value="Backup this file">
            </form>
            <p style="margin-left:18px;margin-bottom: 5px;color:greenyellow;text-shadow:1px 1px 1px black">Backups stored on server.</p>
            <div id="container">
                <table class="list">
                    <tr>
                    <th>ID</th>
                    <th>Filename</th>
                    <th>Size</th>
                    <th></th>
                    </tr>

                    <?php while() ?>
                </table>
            </div>
            <p style="margin-left: 27px"><br/><span style="color: greenyellow;text-shadow: 1px 1px 1px black">Rules: </span></br/>1. The file uploaded must have an extension.<br/>2. The file size cannot exceed 50 mb.</p>
        </div>
    </body>
</html>
