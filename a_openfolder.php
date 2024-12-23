<?php
$folderPath = 'C:\\Users\\User\\Desktop\\semi3a\\形式変換後画像';
if (is_dir($folderPath)) {
    // Windowsのエクスプローラーでフォルダーを開く
    shell_exec('explorer ' . escapeshellarg($folderPath));
    echo 'フォルダーを開きました。';
} else {
    echo 'フォルダーが見つかりません。';
}
?>
<a href="src/a_upload.php">戻る</a>