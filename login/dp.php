<?php
// db.php
$host = "localhost";
$user = "root";      // tvoj MySQL korisnik
$pass = "bazaza1poso";          // tvoja MySQL lozinka, često je prazna na localhostu
$dbname = "korisnici_db";

$mysqli = new mysqli($host, $user, $pass, $dbname);

if ($mysqli->connect_errno) {
    die("Greška pri konekciji s bazom: " . $mysqli->connect_error);
}

// Postavi charset na utf8mb4
$mysqli->set_charset("utf8mb4");
?>
