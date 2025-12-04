<?php
require 'config.php';

// Set Timezone
date_default_timezone_set('Asia/Jakarta');

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT news.*, users.fullname FROM news JOIN users ON news.author_id = users.id WHERE news.id = ? AND status = 'published'");
$stmt->execute([$id]);
$news = $stmt->fetch();

if (!$news) {
    die("Berita tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($news['title']); ?> - Sahamsiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="topbar">
        <div class="logo">
            <span class="logo-mark">SS</span>
            <div class="logo-text">
                <h1>Sahamsiswa</h1>
                <p>Portal Berita Saham untuk Mahasiswa</p>
            </div>
        </div>
        <form class="search-bar" action="search.php" method="get">
            <input type="text" name="q" placeholder="Cari berita...">
            <button type="submit">Cari</button>
        </form>
    </header>

    <nav class="main-nav">
        <ul>
            <li><a href="index.php">Beranda</a></li>
            <li><a href="kategori.php?market=saham_id">Saham Indonesia</a></li>
            <li><a href="kategori.php?market=saham_us">Saham US</a></li>
            <li><a href="kategori.php?market=crypto">Crypto</a></li>
            <li><a href="kategori.php">Semua Kategori</a></li>
        </ul>
    </nav>

    <main class="page">
        <section class="content-layout">
            <article class="news-detail" style="grid-column: 1 / -1; background: #020617; padding: 2rem; border-radius: 1rem; border: 1px solid rgba(31,41,55,1);">
                <div class="headline-tag"><?php echo strtoupper($news['market']); ?></div>
                <h1 style="font-size: 2rem; margin: 1rem 0;"><?php echo htmlspecialchars($news['title']); ?></h1>
                
                <div class="news-meta-top" style="margin-bottom: 2rem; color: #9ca3af;">
                    <span>Oleh: <?php echo htmlspecialchars($news['fullname']); ?></span>
                    <span> | </span>
                    <span><?php echo date('l, d F Y H:i', strtotime('+15 hours', strtotime($news['published_at']))); ?> WIB</span>
                </div>

                <?php if($news['image']): ?>
                    <img src="uploads/<?php echo htmlspecialchars($news['image']); ?>" alt="News Image" style="width:100%; max-height: 400px; object-fit: cover; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <?php endif; ?>

                <div class="content" style="line-height: 1.8; color: #d1d5db;">
                    <?php echo nl2br(htmlspecialchars($news['content'])); ?>
                </div>
            </article>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2025 Sahamsiswa. Dibuat sebagai Final Project.</p>
    </footer>
</body>
</html>