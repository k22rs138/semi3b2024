<?php
if (isset($_GET['file'])) {
    $file = urldecode($_GET['file']);
    $filePath = 'C:\\Users\\User\\Desktop\\semi3a\\形式変換後画像\\' . $file;

    if (file_exists($filePath)) {
        unlink($filePath);
        echo 'ファイルが削除されました。';
    } else {
        echo 'ファイルが見つかりません。';
    }
} else {
    echo 'ファイルが指定されていません。';
}
?>
<a href="src/a_upload.php">戻る</a>