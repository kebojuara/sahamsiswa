<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    $category_id = $_POST['category_id'];
    $market = $_POST['market'];
    $ticker = $_POST['ticker'];
    $content = $_POST['content'];
    $status = $_POST['status'];
    $author_id = $_SESSION['user_id'];
    
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $filename);
        $image = $filename;
    }

    $sql = "INSERT INTO news (category_id, title, slug, content, image, ticker_symbol, market, author_id, status, published_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$category_id, $title, $slug, $content, $image, $ticker, $market, $author_id, $status]);

    header("Location: news_index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Berita</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { background: #020617; color: white; padding: 2rem; }
        .form-container { max-width: 800px; margin: 0 auto; background: #0f172a; padding: 2rem; border-radius: 1rem; border: 1px solid #1e293b; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; color: #9ca3af; }
        input, select, textarea { width: 100%; padding: 0.75rem; background: #1e293b; border: 1px solid #334155; color: white; border-radius: 0.5rem; }
        textarea { height: 200px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 style="margin-bottom: 1.5rem; color: #22c55e;">Tambah Berita Baru</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Judul Berita</label>
                <input type="text" name="title" required>
            </div>
            <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label>Kategori</label>
                    <select name="category_id">
                        <?php foreach($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Market</label>
                    <select name="market">
                        <option value="saham_id">Saham Indonesia</option>
                        <option value="saham_us">Saham US</option>
                        <option value="crypto">Crypto</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Ticker Symbol (Contoh: BBCA, TSLA, BTC)</label>
                <input type="text" name="ticker">
            </div>
            <div class="form-group">
                <label>Gambar Utama</label>
                <input type="file" name="image">
            </div>
            <div class="form-group">
                <label>Isi Berita</label>
                <textarea name="content" required></textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
            <button type="submit" class="btn-primary" style="width: 100%;">Simpan Berita</button>
            <a href="news_index.php" style="display: block; text-align: center; margin-top: 1rem; color: #94a3b8;">Batal</a>
        </form>
    </div>
</body>
</html>