<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$messageId = $_POST['id'];
$newMessage = $_POST['message'];
$userId = $_SESSION['user_id']; // Assuming user is logged in

// Check if the message belongs to the user
$stmt = $pdo->prepare('SELECT user_id FROM messages WHERE id = ?');
$stmt->execute([$messageId]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);

if ($message && $message['user_id'] == $userId) {
$stmt = $pdo->prepare('UPDATE messages SET message = ? WHERE id = ?');
$stmt->execute([$newMessage, $messageId]);
echo json_encode(['status' => 'success', 'message' => 'Message updated successfully!']);
} else {
echo json_encode(['status' => 'error', 'message' => 'You cannot edit this message.']);
}
}
?>