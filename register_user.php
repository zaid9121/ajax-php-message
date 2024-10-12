<?php

session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$username = trim($_POST['username']);
$password = $_POST['password'];

if (!empty($username) && !empty($password)) {
// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if username already exists
$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
$stmt->execute([$username]);
if ($stmt->rowCount() > 0) {
echo json_encode(['status' => 'error', 'message' => 'Username already exists.']);
exit;
}

// Insert user into the database
$stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
if ($stmt->execute([$username, $hashed_password])) {
echo json_encode(['status' => 'success']);
} else {
echo json_encode(['status' => 'error', 'message' => 'Registration failed.']);
}
} else {
echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
}
}
?>
