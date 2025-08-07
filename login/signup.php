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
    $email = trim($_POST['email']);
    $pass = $_POST['password'];
    $pass_confirm = $_POST['password_confirm'];

    if (empty($username) || empty($email) || empty($pass) || empty($pass_confirm)) {
        $_SESSION['error'] = "Sva polja su obavezna.";
        header("Location: ../index.php#signup");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Neispravan email.";
        header("Location: ../index.php#signup");
        exit;
    }

    if ($pass !== $pass_confirm) {
        $_SESSION['error'] = "Lozinke se ne podudaraju.";
        header("Location: ../index.php#signup");
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM korisnici WHERE username = ? OR email = ?");
    if (!$stmt) {
        $_SESSION['error'] = "Greška u pripremi provjere korisnika.";
        header("Location: ../index.php#signup");
        exit;
    }
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Korisničko ime ili email već postoji.";
        $stmt->close();
        header("Location: ../index.php#signup");
        exit;
    }
    $stmt->close();

    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO korisnici (username, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        $_SESSION['error'] = "Greška u pripremi unosa korisnika.";
        header("Location: ../index.php#signup");
        exit;
    }
    $stmt->bind_param("sss", $username, $email, $pass_hash);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registracija uspješna. Dobrodošli!";
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['username'] = $username;
        $stmt->close();
        header("Location: ../dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = "Došlo je do greške prilikom registracije.";
        $stmt->close();
        header("Location: ../index.php#signup");
        exit;
    }
}
?>
