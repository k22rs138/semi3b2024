<?php
require_once('db_inc.php');
$sid = $_GET['sid'];

$pid = 0;
$reason = '';

// 学生の希望状況を調べ、変数に$pid, $reasonに代入
$sql = "SELECT * FROM tbl_wish WHERE sid='{$sid}'";
$pid = 'pid';
$reason = 'reason';

// データベースへ問合せのSQL($sql)を実行
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);

// 問合せ結果を一行取得
$row= $rs->fetch_assoc();
if ($row){
  $pid = $row['pid'];
  $reason = $row['reason'];
}

// 学生情報を検索するSQL文
$sql = "SELECT * FROM tbl_student WHERE sid='{$sid}'";

// データベースへ問合せのSQL($sql)を実行
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);

// 問合せ結果を表形式で出力する。
//学籍番号(sid)、氏名(sname)、性別(sex)、GPA(gpa)、修得単位数(credit), 本人希望の一覧表示
?>
<table border=1>
<tr><th>学籍番号</th><th>氏名</th><th>性別</th><th>GPA</th><th>修得単位数</th><th>本人希望</th><th>操作</th></tr>
<form action="?do=eps_decide_save" method="post">
<input type="hidden" name="sid" value="<?=$sid?>">
<?php 
$row= $rs->fetch_assoc();
if ($row){ // 最大1行しかないので、while文の代わり、if文を使う
  echo '<tr>';
  echo '<td>' . $row['sid'] . '</td>';
  //続いて、残り項目の出力
  echo '<td>' . $row['sname'] . '</td>';
  echo '<td>' . $row['sex'] . '</td>';
  echo '<td>' . $row['gpa'] . '</td>';
  echo '<td>' . $row['credit'] . '</td>';
  //echo '<td>' . isset($row['pid']) . '</td>'; 
  //echo '<td>' . $pid . '</td>'; 
  echo '<td>';
  $pid;
  $codes = array(
    1 => '総合教育', 
    2 => '応用教育', 
  );
  echo '</td>';
  echo '<td>';
  // 配属決定のラジオボタン(name="decided")
  $decided = $row['decided'];
  $codes = array(
    1 => '総合教育', 
    2 => '応用教育', 
  );
  // foreach文で選択肢となるラジオボタンを出力する
  foreach ($codes as $key => $value) {
    echo '<label>';
    echo '<input type="radio" name="decided" value="' . $key . '">';
    echo $value;
    echo '</label><br>';
}
  
  echo '</td>';
  echo '</tr>';
}
?>

<tr>
<td ><button><a href="?do=eps_list">戻る</a></button></td><td colspan="5"></td>
<td><input type="submit" value="送信">&nbsp;<input type="reset" value="取消"></td>
</tr>
</form>
</table>