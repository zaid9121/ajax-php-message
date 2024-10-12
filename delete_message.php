<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$messageId = $_POST['id'];
$userId = $_SESSION['user_id']; // Assuming user is logged in

// Check if the message belongs to the user
$stmt = $pdo->prepare('SELECT user_id FROM messages WHERE id = ?');
$stmt->execute([$messageId]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);

if ($message && $message['user_id'] == $userId) {
$stmt = $pdo->prepare('DELETE FROM messages WHERE id = ?');
$stmt->execute([$messageId]);
echo json_encode(['status' => 'success', 'message' => 'Message deleted successfully!']);
} else {
echo json_encode(['status' => 'error', 'message' => 'You cannot delete this message.']);
}
}
?>