<h3>未提出者一覧</h3>
<?php
require_once('db_inc.php');

// 一覧データを検索するSQL
$sql = "SELECT * FROM tbl_student WHERE sid NOT IN (SELECT sid FROM tbl_wish)";

//データベースへ問合せのSQL文($sql)を実行する・・・
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);

//学籍番号(sid)、氏名(sname)、性別(sex)、GPA(gpa)、修得単位数(credit)の一覧表示
?>
<table border=1>
<tr><th>学籍番号</th><th>氏名</th><th>性別</th><th>GPA</th><th>修得単位数</th></tr>
<?php
$row= $rs->fetch_assoc();
while ($row){ // 最大1行しかないので、while文の代わり、if文を使う
  echo '<tr>';
  echo '<td>' . $row['sid'] . '</td>';
  //続いて、残り項目の出力
  echo '<td>' . $row['sname'] . '</td>';
  echo '<td>' . $row['sex'] . '</td>';
  echo '<td>' . $row['gpa'] . '</td>';
  echo '<td>' . $row['credit'] . '</td>'; 
  echo '</tr>';
  $row = $rs->fetch_assoc();

}
?>
</table>