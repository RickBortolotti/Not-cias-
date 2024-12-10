<?php
include '../includes/db.php';
include '../includes/auth.php';
checkAuth();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: dashboard.php');
    exit;
}

// Deleta a notícia
$stmt = $pdo->prepare('DELETE FROM news WHERE id = ?');
$stmt->execute([$id]);

header('Location: dashboard.php');
exit;
?>
