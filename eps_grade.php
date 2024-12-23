<h3>成績確認</h3>
<?php
require_once('db_inc.php');
$uid = $_SESSION['uid']; //ログイン中のユーザのIDを取得
$sid = strtoupper($uid); //ユーザIDを大文字に変換し学籍番号を求める

// 一覧データを検索するSQL文
$sql = "SELECT * FROM tbl_student WHERE sid= '{$sid}' ";
//データベースへ問合せのSQL文($sql)を実行する・・・
//$conn = new mysqli("localhost","root","","wp2024");
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);

// 問合せ結果を表形式で出力する。
echo '<table border=1>';
$row= $rs->fetch_assoc();
if ($row) {
  echo '<tr><th>学籍番号</th><td>' .$row['sid'] . '</td></tr>';
  echo '<tr><th>氏名</th><td>' . $row['sname']. '</td></tr>';
  //echo '<tr><th>性別</th><td>' . $row['sex'] . '</td></tr>';
  if($row['sex'] ==1){
    echo '<tr><th>性別</th><td>' . '男' . '</td></tr>';
  }else{
    echo '<tr><th>性別</th><td>' . '女' . '</td></tr>';
  }
  echo '<tr><th>GPA</th><td>' . $row['gpa'] . '</td></tr>';
  echo '<tr><th>習得単位数</th><td>' . $row['credit'] . '</td></tr>';
}
echo '</table>';
//学籍番号(sid)、氏名(sname)、性別(sex)、GPA(gpa)、修得単位数(credit)を表示

?>