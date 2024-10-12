<?php

session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$username = trim($_POST['username']);
$password = $_POST['password'];

if (!empty($username) && !empty($password)) {
// Prepare and execute the query
$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();

// Verify the password
if ($user && password_verify($password, $user['password'])) {
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
echo json_encode(['status' => 'success']);
} else {
echo json_encode(['status' => 'error', 'message' => 'Invalid username or password.']);
}
} else {
echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
}
}
?>
