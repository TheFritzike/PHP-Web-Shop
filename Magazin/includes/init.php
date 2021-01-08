<?php

require_once 'functions.php';
require_once 'config.php';

// initializare sesiune
if (!session_id()) {
    session_start();
}
ob_start();

/* Incercare conectare la MySQL db */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verificare conexiune
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$pdo = pdo_connect_mysql();

if($pdo === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
