<?php
require 'config.php';

$market = $_GET['market'] ?? '';
$whereClause = "WHERE status = 'published'";
$params = [];

if ($market) {
    $whereClause .= " AND market = ?";
    $params[] = $market;
}

$stmt = $pdo->prepare("SELECT news.*, users.fullname FROM news JOIN users ON news.author_id = users.id $whereClause ORDER BY published_at DESC");
$stmt->execute($params);
$news_list = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kategori <?php echo htmlspecialchars($market); ?> - Sahamsiswa</title>
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
            <li class="<?php echo $market == 'saham_id' ? 'active' : ''; ?>"><a href="kategori.php?market=saham_id">Saham Indonesia</a></li>
            <li class="<?php echo $market == 'saham_us' ? 'active' : ''; ?>"><a href="kategori.php?market=saham_us">Saham US</a></li>
            <li class="<?php echo $market == 'crypto' ? 'active' : ''; ?>"><a href="kategori.php?market=crypto">Crypto</a></li>
            <li class="<?php echo $market == '' ? 'active' : ''; ?>"><a href="kategori.php">Semua Kategori</a></li>
        </ul>
    </nav>

    <main class="page">
        <section class="news-list">
            <div class="section-header">
                <h2>Arsip Berita: <?php echo $market ? strtoupper(str_replace('_', ' ', $market)) : 'Semua'; ?></h2>
            </div>

            <?php if (count($news_list) > 0): ?>
                <?php foreach ($news_list as $news): ?>
                <article class="news-card">
                    <div class="news-meta-top">
                        <span class="badge"><?php echo strtoupper(str_replace('_', ' ', $news['market'])); ?></span>
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
                <p>Belum ada berita di kategori ini.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2025 Sahamsiswa. Dibuat sebagai Final Project.</p>
    </footer>
</body>
</html>