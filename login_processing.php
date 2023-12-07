<?php
session_start();

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'OnlineStore';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $conn->real_escape_string($_POST['username']);
$password = $conn->real_escape_string($_POST['password']);

$stmt = $conn->prepare("SELECT userID, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);

$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($userID, $hashed_password);
    $stmt->fetch();
    if (password_verify($password, $hashed_password)) {
        $_SESSION['userID'] = $userID;
        $_SESSION['username'] = $username;
        
        header('Location: index.php?page=home');
        exit();
    }
    else {
        echo "<script>alert('Incorrect password! Redirecting to login again...'); window.location.href='index.php?page=login';</script>";
        exit();
    }
} else {
    echo "<script>alert('usernotfound! Redirecting to login again...'); window.location.href='index.php?page=login';</script>";
    exit();
}

$stmt->close();
$conn->close();
?>
