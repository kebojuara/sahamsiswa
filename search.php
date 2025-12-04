<?php
require 'config.php';

$q = $_GET['q'] ?? '';
$stmt = $pdo->prepare("SELECT news.*, users.fullname FROM news JOIN users ON news.author_id = users.id WHERE title LIKE ? AND status = 'published' ORDER BY published_at DESC");
$stmt->execute(["%$q%"]);
$results = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pencarian: <?php echo htmlspecialchars($q); ?> - Sahamsiswa</title>
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
            <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Cari berita...">
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
        <section class="news-list">
            <div class="section-header">
                <h2>Hasil Pencarian: "<?php echo htmlspecialchars($q); ?>"</h2>
            </div>

            <?php if (count($results) > 0): ?>
                <?php foreach ($results as $news): ?>
                <article class="news-card">
                    <div class="news-meta-top">
                        <span class="badge"><?php echo strtoupper($news['market']); ?></span>
                        <span class="ticker"><?php echo htmlspecialchars($news['ticker_symbol']); ?></span>
                    </div>
                    <h3><a href="detail.php?id=<?php echo $news['id']; ?>"><?php echo htmlspecialchars($news['title']); ?></a></h3>
                    <p><?php echo substr(strip_tags($news['content']), 0, 120); ?>...</p>
                    <div class="news-meta-bottom">
                        <span><?php echo date('d M Y', strtotime($news['published_at'])); ?></span>
                        <span>Oleh: <?php echo htmlspecialchars($news['fullname']); ?></span>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Tidak ditemukan berita dengan kata kunci tersebut.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2025 Sahamsiswa. Dibuat sebagai Final Project.</p>
    </footer>
</body>
</html>