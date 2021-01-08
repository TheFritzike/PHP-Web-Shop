<?php

// Definire variabile si initializare cu valori goale
$username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
$password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
$confirm_password = isset($_POST["confirm_password"]) ? trim($_POST["confirm_password"]) : "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validare username
    if(empty($username)){
        $username_err = "Introduceti username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT `uid` FROM `users` WHERE `uname` = ?";


        if($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            $param_username = $username;

            // Set parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "Nume utilizator exista deja.";
                }
            } else {
                echo "Oops! Ceva nu e in ordine utilizator. Incercati din nou.";
                echo mysqli_error($link);
            }

            // Close statement
            // mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if(empty($password)) {
        $password_err = "Introduceti parola.";
    } elseif(strlen($password) < 6) {
        $password_err = "Parola trebuie sa aibe minim 6 caractere.";
    }

    // Validate confirm password
    if(empty($confirm_password)){
        $confirm_password_err = "Confirmati parola.";
    } else if(empty($password_err) && ($password != $confirm_password)) {
        $confirm_password_err = "Parola nu coincide.";
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users (`uname`, `upass`) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                $_SESSION['registered'] = true;
                header("location: " . $_SERVER["PHP_SELF"] . "?page=login");
                exit();
            } else {
                echo "Oops! Ceva nu e in ordine. Incercati din nou.";
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
<?=template_header('Register')?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px;position: absolute;z-index: 15;top: 30%;left: 50%;margin: -100px 0 0 -150px;border:thin 1px;border-radius:5px; }
    </style>
</head>
<body >
    <div class="wrapper" >
        <h2>Înregistrează-te</h2>

        <p>Vă rugăm să completați acest formular pentru a vă crea un cont.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?page=register'); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Utilizator</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Parola</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirmare Parola</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Salveaza">
                <input type="reset" class="btn btn-default" value="Resetare">
            </div>
            <p>Aveti deja cont? <a href="index.php?page=home">Autentificare aici</a>.</p>
        </form>
    </div>
</body>
</html>

<?=template_footer()?>