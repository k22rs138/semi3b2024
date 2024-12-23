<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>画像ファイル形式変換PHPプログラム</title>
</head>
<body>
    <h1>画像ファイル形式変換PHPプログラム</h1>
    <form action="src/a_upload.php" method="post" enctype="multipart/form-data">
        <label for="file">画像ファイルを選択 (JPEG/PNG, 最大10MB):</label>
        <input type="file" name="file" id="file" accept=".jpeg, .jpg, .png" required>
        <br>
        <label for="format">変換先形式を選択:</label>
        <input type="radio" name="format" value="jpeg" required> JPEG
        <input type="radio" name="format" value="png" required> PNG
        <br>
        <label for="width">幅 (px):</label>
        <input type="number" name="width" id="width">
        <br>
        <label for="height">高さ (px):</label>
        <input type="number" name="height" id="height">
        <br>
        <button type="submit">アップロードして変換</button>
    </form>

    <!-- <h2>変換された画像をダウンロード</h2>
    <?php
    if (isset($_GET['download_link'])) {
        echo '<form action="src/a_download.php" method="post">';
        echo '<input type="hidden" name="file" value="' . htmlspecialchars($_GET['download_link']) . '">';
        echo '<button type="submit">変換された画像をダウンロード</button>';
        echo '</form>';
    }
    ?> -->

    <h2>アップロードされたファイル一覧</h2>
    <ul>
        <?php
        $dir = '形式変換後画像';
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    echo '<li>' . htmlspecialchars($file) . ' <a href="src/a_delete.php?file=' . urlencode($file) . '">削除</a></li>';
                }
            }
        }
        ?>
    </ul>
    <h2>フォルダーを開く</h2>
    <form action="src/a_upload.php" method="post">
        <button type="submit">フォルダーを開く</button>
    </form>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file = $_FILES['file'];
    $format = $_POST['format'];
    $width = isset($_POST['width']) ? intval($_POST['width']) : null;
    $height = isset($_POST['height']) ? intval($_POST['height']) : null;

    // ファイルサイズのチェック (10MB以下)
    if ($file['size'] > 0.1 * 1024 * 1024) {
        die('ファイルサイズが大きすぎます。');
    }

    // アップロードされたファイルの保存
    $uploadDir = '形式変換後画像/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $filePath = $uploadDir . basename($file['name']);
    if (!move_uploaded_file($file['tmp_name'], $filePath)) {
        die('ファイルのアップロードに失敗しました。');
    }

    // 画像の読み込み
    $image = null;
    switch (mime_content_type($filePath)) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($filePath);
            break;
        case 'image/png':
            $image = imagecreatefrompng($filePath);
            break;
        default:
            die('対応していないファイル形式です。');
    }

    // 画像のリサイズ
    if ($width && $height) {
        $resizedImage = imagescale($image, $width, $height);
        imagedestroy($image);
        $image = $resizedImage;
    }

    // 画像の形式変換
    $newFilePath = $uploadDir . pathinfo($filePath, PATHINFO_FILENAME) . '.' . $format;
    switch ($format) {
        case 'jpeg':
            imagejpeg($image, $newFilePath);
            break;
        case 'png':
            imagepng($image, $newFilePath);
            break;
    }
    imagedestroy($image);

    // 元のファイルを削除
    unlink($filePath);

    // ダウンロードリンクの生成
    header('Location: src/a_upload.php?download_link=' . urlencode($newFilePath));
    exit;
}
?>