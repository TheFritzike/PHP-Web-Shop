<?php
// Include config file
require_once "../includes/init.php";

// Page is set to home (home.php) by default, so when the visitor visits that will be the page they see.
$page = isset($_GET['page']) && file_exists('../pages/' . trim($_GET['page']) . '.php') ? trim($_GET['page']) : 'home';
// Include and show the requested page
require '../pages/'. $page . '.php';

?>