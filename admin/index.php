<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require '../config.php';
$news_count = $pdo->query("SELECT COUNT(*) FROM news")->fetchColumn();
$cat_count = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Sahamsiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-layout { display: grid; grid-template-columns: 250px 1fr; min-height: 100vh; }
        .sidebar-admin { background: #0f172a; border-right: 1px solid #1e293b; padding: 2rem 1rem; }
        .admin-menu { list-style: none; margin-top: 2rem; }
        .admin-menu li { margin-bottom: 0.5rem; }
        .admin-menu a { display: block; padding: 0.75rem 1rem; color: #94a3b8; border-radius: 0.5rem; transition: all 0.2s; }
        .admin-menu a:hover, .admin-menu a.active { background: rgba(34, 197, 94, 0.1); color: #22c55e; }
        .main-content { padding: 2rem; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-top: 2rem; }
        .stat-card { background: #1e293b; padding: 1.5rem; border-radius: 0.75rem; border: 1px solid #334155; }
        .stat-card h3 { font-size: 0.9rem; color: #94a3b8; margin-bottom: 0.5rem; }
        .stat-card .number { font-size: 2rem; font-weight: 700; color: #e2e8f0; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar-admin">
            <h2 style="color: #22c55e; padding: 0 1rem;">Sahamsiswa Panel</h2>
            <ul class="admin-menu">
                <li><a href="index.php" class="active">Dashboard</a></li>
                <li><a href="news_index.php">Manajemen Berita</a></li>
                <li style="margin-top: 2rem;"><a href="logout.php" style="color: #f87171;">Logout</a></li>
            </ul>
        </aside>
        <main class="main-content">
            <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['fullname']); ?> 👋</h1>
                <a href="../index.php" target="_blank" class="btn-primary">Lihat Website</a>
            </header>
            <section class="stats-grid">
                <div class="stat-card">
                    <h3>Total Berita</h3>
                    <div class="number"><?php echo $news_count; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Kategori</h3>
                    <div class="number"><?php echo $cat_count; ?></div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>