<!DOCTYPE html>
<?php

// Jacob Addis - file_backup web application.
// Created for project in Comp Systems Research Seminar.
// Takes a file as input from an HTML file selector and sends it to /uploads folder.
// Creates Record in mySQL database and displays all Database enties in GUI table format.
// Course Instructor: Christopher Diaz phd.
// Course ID: SCS 400 01.

require_once('database.php');
$db = db_connect();

$upload_directory = 'uploads/';

if(isset($_POST["submit"])){

    $file_name = $_FILES["upload"]["name"];
    $file_size = $_FILES["upload"]["size"];
    $tempname = $_FILES['upload']['tmp_name'];

    $sql = "INSERT INTO file_uploads ";             // CREATE TABLE file_uploads (
    $sql .= "(Filename, Size) ";                    // id INT(11) NOT NULL AUTO_INCREMENT,
    $sql .= "VALUES (";                             // Filename VARCHAR(200),
    $sql .= "'" . $file_name . "',";                // Size INT(20),
    $sql .= "'" . $file_size . "'";                 // PRIMARY KEY (id),
    $sql .= ")";                                    // UNIQUE (Filename) -- Using SQL to handle duplicates.
                                                    // );
    $result = mysqli_query($db, $sql);

    if($result) {
        echo "Database Query Sucessful";
    } else {
        echo "Duplicate Entry Detected. " . "  ";
    }

    if (move_uploaded_file($tempname, "uploads/" . $file_name)) {
        echo "Upload Complete!";
    } else {
        echo "Upload Failed!";
    }
}
function find_all_uploads() {                       // connects to DB and performs query.                                               //Finds and returns all rows.
    global $db;                                     // finds  and all rows in file_uploads table.
    $sql = "SELECT * FROM file_uploads ";
    $sql .= "ORDER BY id DESC";
    $result = mysqli_query($db, $sql);
    return $result;
}

$uploads_array = find_all_uploads();

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
                    </tr>

                    <?php while($file = mysqli_fetch_assoc($uploads_array)) { ?>
                        <tr>
                            <td> <?php echo $file['id']; ?> </td>
                            <td> <?php echo $file['Filename']; ?> </td>
                            <td> <?php echo $file['Size'] . " bytes"; ?> </td>
                        </tr>
                    <?php } ?>

                </table>
                <?php db_disconnect($db); ?>
            </div>
            <p style="margin-left: 27px"><br/><span style="color: greenyellow;text-shadow: 1px 1px 1px black">Rules: </span></br/>1. The file uploaded must have an extension.<br/>2. The file size cannot exceed 50 mb.<br/>3. The file must be unique.</p>
        </div>
    </body>
</html>
