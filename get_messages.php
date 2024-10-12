<?php
require 'config.php';
session_start();

$userId = $_SESSION['user_id']; // Assuming user is logged in

$stmt = $pdo->prepare('
SELECT messages.id, messages.message, messages.created_at, users.username, messages.user_id
FROM messages
JOIN users ON messages.user_id = users.id
ORDER BY messages.created_at DESC
');
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($messages as &$message) {
$message['canEdit'] = $message['user_id'] == $userId; // Check if the logged-in user is the owner
$message['canDelete'] = $message['user_id'] == $userId; // Check if the logged-in user is the owner
}

echo json_encode($messages);
?>