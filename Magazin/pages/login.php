<?php

// Check if the user is already logged in, if yes then redirect him to cart page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: " . $_SERVER["PHP_SELF"] . "?page=cart&" . http_build_query($_GET));
  exit;
}

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Introduceti utilizator.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Introduceti parola.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT `uid`, `uname`, `upass` FROM `users` WHERE `uname` = ?";

        if($stmt = mysqli_prepare($link, $sql)) {
            // Set parameters
            $param_username = $username;

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

                    if(mysqli_stmt_fetch($stmt)) {
                        if(password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            if(isset($_GET['action']) && $_GET['action'] == 'add_to_cart') {
                                unset($_GET['page']);
                                header("location: " . $_SERVER["PHP_SELF"] . "?page=" . $_GET['return'] . '&' . http_build_query($_GET) );
                            } else {
                                header("location: " . $_SERVER["PHP_SELF"] . "?page=home");
                            }
                            exit();
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "Utilizator inexistent.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
                echo mysqli_error($link);
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>
<?=template_header('Login')?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body >
    <div class="wrapper" >
        <h2>Autentificare</h2>

        <?php if(!empty($_SESSION['registered'])) {
            unset($_SESSION['registered']);
            echo "<b>Inregistrat cu success!</b>";
        } ?>

        <p>Vă rugăm sa introduceţi credenţialele.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?' . http_build_query($_GET) ); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Utilizator</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Parola</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Autentificare">
            </div>
            <p>Nu aveți cont? <a href="index.php?page=register">Creați unul aici.</a></p>
        </form>
    </div>
</body>
</html>

<?=template_footer()?>