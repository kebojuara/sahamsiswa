<?php
require 'config.php';

date_default_timezone_set('Asia/Jakarta');

$stmt = $pdo->query("SELECT news.*, users.fullname 
                     FROM news 
                     JOIN users ON news.author_id = users.id 
                     WHERE status = 'published' 
                     ORDER BY published_at DESC 
                     LIMIT 6");
$all_news = $stmt->fetchAll();

$headline = null;
$news_list = [];

if (!empty($all_news)) {
    $headline = $all_news[0];
    $news_list = array_slice($all_news, 1);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sahamsiswa - Portal Berita Saham</title>
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
            <input type="text" name="q" placeholder="Cari berita saham, ticker, atau kripto...">
            <button type="submit">Cari</button>
        </form>

        <a href="admin/login.php" class="login-link">Login Admin</a>
    </header>

    <nav class="main-nav">
        <ul>
            <li class="active"><a href="index.php">Beranda</a></li>
            <li><a href="kategori.php?market=saham_id">Saham Indonesia</a></li>
            <li><a href="kategori.php?market=saham_us">Saham US</a></li>
            <li><a href="kategori.php?market=crypto">Crypto</a></li>
            <li><a href="kategori.php">Semua Kategori</a></li>
        </ul>
    </nav>

    <main class="page">
        <?php if ($headline): ?>
        <section class="headline-section">
            <h2>Headline Hari Ini</h2>
            <article class="headline-card">
                <div class="headline-tag"><?php echo strtoupper(str_replace('_', ' ', $headline['market'])); ?></div>
                
                <?php if (!empty($headline['image_url'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($headline['image_url']); ?>" alt="Headline Image" style="width:100%; height:300px; object-fit:cover; margin-bottom:15px; border-radius:8px;">
                <?php endif; ?>
                
                <h3><?php echo htmlspecialchars($headline['title']); ?></h3>
                <p>
                    <?php echo substr(strip_tags($headline['content']), 0, 150); ?>...
                </p>
                <div class="headline-meta">
                    <span>Penulis: <?php echo htmlspecialchars($headline['fullname']); ?></span>
                    <span>Dipublikasikan: <?php echo date('d M Y H:i', strtotime('+15 hours', strtotime($headline['published_at']))); ?> WIB</span>
                </div>
                <a href="detail.php?id=<?php echo $headline['id']; ?>" class="btn-primary">Baca Selengkapnya</a>
            </article>
        </section>
        <?php endif; ?>

        <section class="content-layout">
            <section class="news-list">
                <div class="section-header">
                    <h2>Berita Terbaru</h2>
                </div>

                <?php foreach ($news_list as $news): ?>
                <article class="news-card">
                    <div class="news-meta-top">
                        <?php 
                            $badgeClass = '';
                            if($news['market'] == 'saham_id') $badgeClass = 'badge-id';
                            elseif($news['market'] == 'saham_us') $badgeClass = 'badge-us';
                            else $badgeClass = 'badge-crypto';
                        ?>
                        <span class="badge <?php echo $badgeClass; ?>"><?php echo strtoupper(str_replace('_', ' ', $news['market'])); ?></span>
                        <span class="ticker"><?php echo htmlspecialchars($news['ticker_symbol']); ?></span>
                    </div>
                    <h3><a href="detail.php?id=<?php echo $news['id']; ?>"><?php echo htmlspecialchars($news['title']); ?></a></h3>
                    <p>
                        <?php echo substr(strip_tags($news['content']), 0, 120); ?>...
                    </p>
                    <div class="news-meta-bottom">
                        <span><?php echo date('d M Y', strtotime('-9 hours', strtotime($news['published_at']))); ?></span>
                        <span>Oleh: <?php echo htmlspecialchars($news['fullname']); ?></span>
                    </div>
                </article>
                <?php endforeach; ?>
            </section>

            <aside class="sidebar">
                <section class="sidebar-section">
                    <h3>Ringkasan Market</h3>
                    <ul class="market-summary">
                        <li>
                            <span>BBCA</span>
                            <span class="value" id="price-bbca" style="font-weight:bold;">Loading...</span>
                        </li>
                        <li>
                            <span>TSLA</span>
                            <span class="value" id="price-tsla" style="font-weight:bold;">Loading...</span>
                        </li>
                    </ul>
                </section>

                <section class="sidebar-section">
                    <h3>Trending Ticker</h3>
                    <ul class="ticker-list">
                        <li><span>BBRI</span><span>Bank Rakyat Indonesia</span></li>
                        <li><span>TSLA</span><span>Tesla Inc.</span></li>
                        <li><span>ETH</span><span>Ethereum</span></li>
                    </ul>
                </section>
            </aside>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2025 Sahamsiswa. Dibuat sebagai Final Project.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            
            try {
                const resBBCA = await fetch('proxy.php?ticker=BBCA');
                const dataBBCA = await resBBCA.json();
                
                const quotes = dataBBCA.chart.result[0].indicators.quote[0].close;
                const validQuotes = quotes.filter(val => val !== null);
                const lastPrice = validQuotes[validQuotes.length - 1];

                const formattedPrice = Math.round(lastPrice).toLocaleString('id-ID');
                document.getElementById('price-bbca').innerText = formattedPrice;
            } catch (error) {
                document.getElementById('price-bbca').innerText = "-";
            }

            try {
                const resTSLA = await fetch('proxy.php?ticker=TSLA');
                const dataTSLA = await resTSLA.json();

                const quotes = dataTSLA.chart.result[0].indicators.quote[0].close;
                const validQuotes = quotes.filter(val => val !== null);
                const lastPrice = validQuotes[validQuotes.length - 1];

                const formattedPrice = parseFloat(lastPrice).toLocaleString('id-ID', {
                    minimumFractionDigits: 2, 
                    maximumFractionDigits: 2
                });
                document.getElementById('price-tsla').innerText = formattedPrice;
            } catch (error) {
                document.getElementById('price-tsla').innerText = "-";
            }
        });
    </script>
</body>
</html>