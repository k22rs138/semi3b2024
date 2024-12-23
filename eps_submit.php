<?php
require_once('db_inc.php');

$uid = $_SESSION['uid']; //ログイン中のユーザのIDを取得
$sid = strtoupper($uid); //学籍番号（ユーザIDの大文字変換）を求める

// 変数の初期化。新規登録か編集かにより異なる。
$act = 'insert';// 新規登録の場合
$pid = 0;
$reason = '';

// 現在の希望を調べ、変数$pid、$reasonに代入
$sql = "SELECT * FROM tbl_wish WHERE sid = '{$sid}' ";
// データベースへ問合せのSQL($sql)を実行
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);

$row= $rs->fetch_assoc();
if ($row){ 
  $act = 'update';
  //続いて、連想配列$rowにあるpid,reason項目を$pid, $reasonに代入
  // ．．．
  $pid = $row['pid'];
  $reason = $row['reason'];
}
?>
<form action="?do=eps_save" method="post">
 

<input type="hidden" name="act" value="<?=$act?>">

<table>

<?php
//---ここへ希望登録画面をHTML・PHPで作る
//---操作区分($act)、学籍番号($sid)、本人希望($pid)、希望理由($reason)などの変数が使える
//---送信項目：操作区分(act:非表示送信)、本人希望(pid:ラジオボタン)、希望理由(reason:テキストエリア)

//if ($act=='insert'){
  //echo '<input type="text" name="uid">';//テキストボックス
//}else {
  //echo '<input type="hidden" name="uid" value="'.$uid.'">';//非表示送信
  //echo "<b>$uid</b>";
//}
?>
</td></tr>
<tr><td></td><td> 
  <input type="hidden" name="uid" value="$uid"></td></tr>
<tr><td>本人希望：</td><td>
  <input type="radio" name="pid" value="1">総合教育プログラム
  <input type="radio" name="pid" value="2">応用教育プログラム</td></tr>
<tr><td>希望理由</td><td>
  <textarea name="reason" rows="4" cols="40"></textarea></td></tr>

  </td></tr>
</table>
<input type="submit" value="希望登録"><input type="reset" value="取消">
 

</form>