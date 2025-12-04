<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
$stmt->execute([$id]);
$news = $stmt->fetch();

if (!$news) die("Berita tidak ditemukan");

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $market = $_POST['market'];
    $ticker = $_POST['ticker'];
    $content = $_POST['content'];
    $status = $_POST['status'];
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $filename);
        $sql = "UPDATE news SET title=?, category_id=?, market=?, ticker_symbol=?, content=?, status=?, image=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $category_id, $market, $ticker, $content, $status, $filename, $id]);
    } else {
        $sql = "UPDATE news SET title=?, category_id=?, market=?, ticker_symbol=?, content=?, status=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $category_id, $market, $ticker, $content, $status, $id]);
    }

    header("Location: news_index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Berita</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { background: #020617; color: white; padding: 2rem; }
        .form-container { max-width: 800px; margin: 0 auto; background: #0f172a; padding: 2rem; border-radius: 1rem; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; color: #9ca3af; }
        input, select, textarea { width: 100%; padding: 0.75rem; background: #1e293b; border: 1px solid #334155; color: white; border-radius: 0.5rem; }
        textarea { height: 200px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 style="margin-bottom: 1.5rem;">Edit Berita</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Judul Berita</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($news['title']); ?>" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id">
                    <?php foreach($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php if($cat['id'] == $news['category_id']) echo 'selected'; ?>>
                            <?php echo $cat['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Market</label>
                <select name="market">
                    <option value="saham_id" <?php if($news['market'] == 'saham_id') echo 'selected'; ?>>Saham Indonesia</option>
                    <option value="saham_us" <?php if($news['market'] == 'saham_us') echo 'selected'; ?>>Saham US</option>
                    <option value="crypto" <?php if($news['market'] == 'crypto') echo 'selected'; ?>>Crypto</option>
                </select>
            </div>
            <div class="form-group">
                <label>Ticker</label>
                <input type="text" name="ticker" value="<?php echo htmlspecialchars($news['ticker_symbol']); ?>">
            </div>
            <div class="form-group">
                <label>Ganti Gambar (Biarkan kosong jika tidak ingin mengganti)</label>
                <input type="file" name="image">
            </div>
            <div class="form-group">
                <label>Isi Berita</label>
                <textarea name="content" required><?php echo htmlspecialchars($news['content']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="published" <?php if($news['status'] == 'published') echo 'selected'; ?>>Published</option>
                    <option value="draft" <?php if($news['status'] == 'draft') echo 'selected'; ?>>Draft</option>
                </select>
            </div>
            <button type="submit" class="btn-primary" style="width: 100%;">Update Berita</button>
        </form>
    </div>
</body>
</html>