<?php
$host = "localhost";
$user = "root";        // XAMPP podrazumijevani user
$password = "";        // OVDJE OSTAVI PRAZNO ako nisi ručno postavljao lozinku
$dbname = "korisnici_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Neuspješna konekcija: " . $conn->connect_error);
} else {
    echo "Uspješno povezano s bazom!";
}

$conn->close();
?>
