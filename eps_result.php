<h3>配属結果確認</h3>
<?php
require_once('db_inc.php');

$uid = $_SESSION['uid']; //ログイン中のユーザのIDを取得
$sid = strtoupper($uid); //学生であれば、学籍番号（ユーザIDの大文字変換）を求める

// 希望プログラムを検索するSQL文
$sql = "SELECT s.*,pid FROM tbl_student s, tbl_wish w WHERE s.sid=w.sid ORDER BY sid";

//データベースへ問合せのSQL文($sql)を実行する・・・
//$conn = new mysqli("localhost","root","","wp2024");
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);


$row= $rs->fetch_assoc();
//問合せ結果があれば希望(pid)を求め、変数$pidに代入。空（未提出）の場合は、0を$pidに代入。
if(isset($row['pid'])){
    $pid = $row['pid'];
}else{
    $pid = 0;
}

// 一覧データを検索するSQL文
$sql = "SELECT * FROM tbl_student WHERE sid='{$sid}';";

//データベースへ問合せのSQL文($sql)を実行する・・・
//$conn = new mysqli("localhost","root","","wp2024");
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);


// 問合せ結果を表形式で出力する。
echo '<table border=1>';
//$row= $rs->fetch_assoc();
if ($row) {
  echo '<tr><th>学籍番号</th><td>' .$row['sid'] . '</td></tr>';
  echo '<tr><th>氏名</th><td>' . $row['sname']. '</td></tr>';
  echo '<tr><th>性別</th>';
  $h  = $row['sex'];     // ユーザ種別のコードを数値で取得
    $codes = array(1=>'男', 2=>'女' ,0=>''); //ユーザ種別を定義する配列
    if($h == 1){
        echo '<td>' . $codes[1] . '</td>';
    }else if($h == 2){
        echo '<td>' . $codes[2] . '</td>';
    }else if($h == 0){
        echo '<td>' . $codes[0] . '</td>';
    }
  echo '</tr>';
  echo '<tr><th>GPA</th><td>' . $row['gpa'] . '</td></tr>';
  echo '<tr><th>習得単位数</th><td>' . $row['credit'] . '</td></tr>';
  echo '<tr><th>本人希望</th>' ;
  $i  = isset($row['pid']);     // ユーザ種別のコードを数値で取得
    $codes = array(1=>'総合教育', 2=>'応用教育', null=>'未提出' ); //ユーザ種別を定義する配列
    if($i == 1){
        echo '<td>' . $codes[1] . '</td>';
    }else if($i == 2){
        echo '<td>' . $codes[2] . '</td>';
    }else if($i == null){
        echo '<td>' . $codes[null] . '</td>';
    }
  echo '</tr>';

  echo '<tr><th>配属結果</th>';
  $j  = $row['decided'];     // ユーザ種別のコードを数値で取得
    $codes = array(1=>'総合教育', 2=>'応用教育', 0=>'' ); //ユーザ種別を定義する配列
    if($j == 1){
        echo '<td>' . $codes[1] . '</td>';
    }else if($j == 2){
        echo '<td>' . $codes[2] . '</td>';
    }else if($j ==0 ){
        echo '<td>' . $codes[0] . '</td>';
    }
  echo '</tr>';
}
echo '</table>';

// 学籍番号(sid)、氏名(sname)、性別(sex)、GPA(gpa)、修得単位数(credit)、本人希望($pid)、配属結果(decided)を表示

?>