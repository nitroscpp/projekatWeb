<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$dbname = "korisnici_db";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Neuspješna konekcija: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $pass = $_POST['password'];

    if (empty($username) || empty($pass)) {
        $_SESSION['error'] = "Sva polja su obavezna.";
        header("Location: index.php#login");
        exit;
    }

    $stmt = $conn->prepare("SELECT id, password FROM korisnici WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        if (password_verify($pass, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit;
        } else {
            $_SESSION['error'] = "Pogrešna lozinka.";
            header("Location: index.php#login");
            exit;
        }
    } else {
        $_SESSION['error'] = "Korisnik ne postoji.";
        header("Location: index.php#login");
        exit;
    }
}
?>
