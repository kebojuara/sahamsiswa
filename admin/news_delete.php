<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT image FROM news WHERE id = ?");
$stmt->execute([$id]);
$news = $stmt->fetch();

if ($news) {
    if ($news['image'] && file_exists('../uploads/' . $news['image'])) {
        unlink('../uploads/' . $news['image']);
    }

    $del = $pdo->prepare("DELETE FROM news WHERE id = ?");
    $del->execute([$id]);
}

header("Location: news_index.php");
exit;
?>