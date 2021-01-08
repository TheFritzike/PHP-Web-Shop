<?php
function pdo_connect_mysql() {
    // Update the details below with your MySQL details
    try {
    	return new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8', DB_USERNAME, DB_PASSWORD);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}
// Template header, feel free to customize this
function template_header($title) {
// Get the amount of items in the shopping cart, this will be displayed in the header.
$num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
$username = !empty($_SESSION) && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true ? $_SESSION["username"] : "";

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $title ?></title>
		<link href="assets/css/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            body{ font: 14px sans-serif; }
            .wrapper{ width: 350px; padding: 20px;position: absolute;z-index: 15;top: 30%;left: 50%;margin: -100px 0 0 -150px;border:thin 1px;border-radius:5px; }
        </style>
	</head>
	<body>
        <header>
            <div class="content-wrapper">
                <h1>Magazin online</h1>
                <nav>
                    <a href="index.php">Acasa</a>
                    <a href="index.php?page=products">Produse</a>
                </nav>
                <div class="link-icons">
                    <?php if($username) { ?>
                        <a href="index.php?page=logout">
                            Logout
                        </a>
                        <?=$username?>
                        <!-- <a href="index.php?page=reset-password">
                            Res-Psw
                        </a> -->
                    <?php } else { ?>
                        <a href="index.php?page=login">
                            Login
                        </a>
                    <?php } ?>
                    <a href="index.php?page=cart">
						<i class="fas fa-shopping-cart"></i>
						<span><?=$num_items_in_cart?></span>
					</a>
                </div>
            </div>
        </header>
        <main>
<?php
}
// Template footer
function template_footer() {
$year = date('Y');
echo <<<EOT
        </main>
        <footer>
            <div class="content-wrapper">
                <p>&copy; $year, Proiect: Coșul de cumpărături</p>
            </div>
        </footer>
        <script src="assets/js/script.js"></script>
    </body>
</html>
EOT;
}
?>