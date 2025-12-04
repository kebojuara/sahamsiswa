<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT news.*, categories.name as category_name, users.fullname 
                     FROM news 
                     JOIN categories ON news.category_id = categories.id 
                     JOIN users ON news.author_id = users.id 
                     ORDER BY created_at DESC");
$news_list = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Berita - Admin</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { background: #020617; color: white; }
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
        .table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        .table th, .table td { padding: 1rem; border: 1px solid #334155; text-align: left; }
        .table th { background: #1e293b; color: #22c55e; }
        .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.8rem; border-radius: 4px; display: inline-block; margin-right: 5px; }
        .btn-edit { background: #3b82f6; color: white; }
        .btn-delete { background: #ef4444; color: white; }
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-flex">
            <h2>Manajemen Berita</h2>
            <div>
                <a href="index.php" class="btn-primary" style="background: #334155; margin-right: 10px;">Kembali</a>
                <a href="news_create.php" class="btn-primary">Tambah Berita</a>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Market</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($news_list as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                    <td><?php echo strtoupper($row['market']); ?></td>
                    <td>
                        <span style="color: <?php echo $row['status'] == 'published' ? '#4ade80' : '#fbbf24'; ?>">
                            <?php echo ucfirst($row['status']); ?>
                        </span>
                    </td>
                    <td><?php echo date('d/m/Y', strtotime($row['published_at'])); ?></td>
                    <td>
                        <a href="news_edit.php?id=<?php echo $row['id']; ?>" class="btn-sm btn-edit">Edit</a>
                        <a href="news_delete.php?id=<?php echo $row['id']; ?>" class="btn-sm btn-delete" onclick="return confirm('Yakin hapus?');">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>