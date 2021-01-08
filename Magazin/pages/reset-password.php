<?php
// Include config file
include_once "../includes/init.php";

// Definire variabile si initializare cu valori goale
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processare date din form la apasare submit
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validare noua parola
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Introduceti parola noua.";
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Parola trebuie sa contina minim 6 caractere.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }

    // Confirmare parola
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Confirmati parola.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Parole diferita.";
        }
    }

    // Verificare errori inainte de update la DB
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Preparare UPD
        $sql = "UPDATE users SET upass = ? WHERE uname = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Asociere variabile ca parametru
            mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_name);

            // Setare parametru
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_name = $_SESSION["username"];

            // Incercare de executare
            if(mysqli_stmt_execute($stmt)){
                // Parola updatata cu succes. Distrugere sessiune, redirectare catre login
                session_destroy();
                header("location:../web/index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Inchidere
            mysqli_stmt_close($stmt);
        }
    }

    // Inchidere conexiune
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px;position: absolute;height: 350px;z-index: 15;top: 30%;left: 50%;margin: -100px 0 0 -150px;background-color:#e1faf9;border:solid 1px;border-radius:5px; }
    </style>
</head>
<body >
    <div class="wrapper">
        <h2>Resetare Parola</h2>
        <p>Vă rugăm să completați acest formular pentru a vă reseta parola.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>Parola noua</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirmare Parola</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Trimite">
                <a class="btn btn-link" href="../web/index.php">Anulare</a>
            </div>
        </form>
    </div>
</body>
</html>