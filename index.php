<!DOCTYPE html>
<?php

$upload_directory = 'uploads/';

if(isset($_POST["submit"])){

    $file_name = $_FILES["upload"]["name"];
    $file_size = $_FILES["upload"]["size"];
    $tempname = $_FILES['upload']['tmp_name'];

    if(strpos(file_get_contents("log.html"), $file_name) == false) {

        $open = fopen("log.html", 'a');
        fwrite($open, "<div style='margin: 1px'><span style='color: cornflowerblue'>" . "Filename: </span>" . $file_name . " " . "<span style='color: cornflowerblue'>Size: </span>" . $file_size . "bytes" . "</div>\n");
        fclose($open);

        if (move_uploaded_file($tempname, "uploads/" . $file_name)) {
            echo "Sucessful!";
        } else if (file_exists($file_name)){
            echo "Already exists in backup";
        }
    }
}

?>
<html>
    <script>
        function load() {
            $.ajax({
                url: "log.html",
                cache: "false",
                success: function(html) {
                    $("#container").html(html);
                }
            })
        }
        setInterval(load, 100);
    </script>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <meta charset="utf-8">
        <style>
            #outer {
                width: 500px;
                height: 600px;
                margin: auto;
                border: 1px solid black;
                border-radius: 5px;
                padding: 5px;
            }
            #container {
                width: 92%;
                height: 300px;
                margin: auto;
                border: 1px solid black;
                border-radius: 4px;
            }
            #form {
                height: 50px;
                width: 100%;
            }
            #submit {
                width: 100px;
                height: 20px;
                background-color: greenyellow;
                border: 1px solid black;
                border-radius: 3px;
            }
            #submit:hover {
                border: 1px solid cornflowerblue;
            }
            #upload {
                width: 390px;
                background-color: lightgray;
                border-radius: 3px;
                border: 1px solid transparent;
            }
            #upload:hover {
                border: 1px solid cornflowerblue;
            }
        </style>
    </head>
    <body>
        <div id="outer">
            <form id="form" action="" method="POST" enctype="multipart/form-data">
                <input type="file" id="upload" name="upload">
                <input type="submit" id="submit" name="submit" value="Backup this file">
            </form>
            <p style="margin-left:18px;margin-bottom: 5px;color:greenyellow;text-shadow:1px 1px 1px black">Backups stored on server.</p>
            <div id="container"></div>
            <p style="margin-left: 27px"><br/><span style="color: greenyellow;text-shadow: 1px 1px 1px black">Rules: </span></br/>1. The file uploaded must have an extension.<br/>2. The file size cannot exceed 50 mb.</p>
        </div>
    </body>
</html>
