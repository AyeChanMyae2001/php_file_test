<?php
$error_message = ""; // Initialize the error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form is submitted, process the data
    $email = isset($_POST["exampleInputEmail1"]) ? $_POST["exampleInputEmail1"] : "";
    $password = isset($_POST["exampleInputPassword1"]) ? $_POST["exampleInputPassword1"] : "";

    // Validate the email and password (add more validation if needed)
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Email is valid, you can proceed with further processing

        // Assuming you want to redirect to 'another_page.php'
        header("Location: file.php");
        exit(); // Ensure that no further code is executed after the header is sent
    } else {
        // Email is not valid, handle the error
        $error_message = "Invalid email address. Please enter a valid email.";
    }

    // It's a good practice to hash the password before storage
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Now you can use $email and $hashedPassword for further processing
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <!-- Add other CSS files if needed -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <!-- Add other JS files if needed -->
  <link rel="stylesheet" href="test22.css">
  <title>Document</title>
</head>
<body>
    <div class="formcontainer">
        <div class="formbox">
            <!-- Display the error message if it's not empty -->
            <?php if (!empty($error_message)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="exampleInputEmail1" aria-describedby="emailHelp" required>
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="exampleInputPassword1" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
