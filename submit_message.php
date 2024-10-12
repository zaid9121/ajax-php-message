<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$message = $_POST['message'];
$userId = $_SESSION['user_id']; // Assuming user is logged in

if (!empty($message) && !empty($userId)) {
$stmt = $pdo->prepare('INSERT INTO messages (message, user_id) VALUES (?, ?)');
$stmt->execute([$message, $userId]);
echo json_encode(['status' => 'success']);
} else {
echo json_encode(['status' => 'error', 'message' => 'Message cannot be empty']);
}
}
?>