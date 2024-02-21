<?php
error_reporting(0);
$msg = "";

function uploadFile($db) {
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./image/" . $filename;

    // Check if a file is selected
    if (empty($filename)) {
        return "Please select a file to upload!";
    }

    // Extension
    $x = pathinfo($filename);
    $fileExtension = strtolower($x['extension']);

    // Check if the uploaded file is a JPG
    if ($fileExtension == "jpg") {
        // Delete the previous JPG file
        $query = "SELECT filename FROM image ORDER BY time_stamp DESC LIMIT 1";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $previousJPGFileName = $row['filename'];
            $previousJPGFilePath = "./image/" . $previousJPGFileName;
            unlink($previousJPGFilePath);
        }

        $sql = "INSERT INTO image (filename) VALUES (?)";

        // Use prepared statement to prevent SQL injection
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, "s", $filename);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Move the uploaded image into the folder: image
            if (move_uploaded_file($tempname, $folder)) {
                return "Image uploaded successfully!";
            } else {
                return "Failed to move the uploaded image!";
            }
        } else {
            return "Failed to execute the database query!";
        }

        mysqli_stmt_close($stmt);
    } else {
        // Disallow PNG files
        return "Uploaded file extension doesn't support. Only support for 'JPG'";
    }
}

$db = mysqli_connect("localhost", "root", "", "upload");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['upload'])) {
    $msg = uploadFile($db);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="test23.css" />
</head>

<body>
    <div class="container">
        <div class="formcontainer">
            <div id="content">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input class="form-control" type="file" name="uploadfile" value="" required />
                    </div>

                    <button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    // Display success or error message
    if (!empty($msg)) {
        echo "<div class='alert alert-primary' role='alert'>$msg</div>";
    }

    // Display the image if it exists
    $query = "SELECT filename FROM image ORDER BY time_stamp DESC LIMIT 1";
    $result = mysqli_query($db, $query);

    if (isset($_POST['upload']) && $result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $lastUploadedFileName = $row['filename'];
            echo "<div id='display-image'><img src=./image/$lastUploadedFileName alt='Uploaded Image'></div>";
        }
    }
    ?>

</body>

</html>
