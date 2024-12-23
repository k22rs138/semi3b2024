<h3>希望状況一覧</h3>
<?php
require_once('db_inc.php');

// 希望状況データを検索するSQL文
//$sql = "SELECT * FROM tbl_student , tbl_program ";
//$sql ="UPDATE tbl_wish SET pid=1,reason='',updated_at=now() WHERE sid='S0001'";
$sql ="SELECT *,pid,tbl_student.sid FROM tbl_student LEFT OUTER JOIN tbl_wish  ON tbl_student.sid=tbl_wish.sid ";
//データベースへ問合せのSQL文($sql)を実行する・・・
//$conn = new mysqli("localhost","root","","wp2024");
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);
// 問合せ結果を表形式で出力する。
echo '<table border=1>';
$row= $rs->fetch_assoc();

echo '<tr><th>学籍番号</th><th>氏名</th><th>性別</th><th>GPA</th><th>習得単位数</th><th>本人希望</th><th>配属結果</th><th>操作</th><th></th></tr>';
while ($row) {
    echo '<tr>';
    echo '<td>'. $row['sid']. '</td>';
    echo '<td>'. $row['sname']. '</td>';
    //echo '<td>'. $row['sex']. '</td>';
    $h  = $row['sex'];     // ユーザ種別のコードを数値で取得
    $codes = array(1=>'男', 2=>'女' ,0=>''); //ユーザ種別を定義する配列
    if($h == 1){
        echo '<td>' . $codes[1] . '</td>';
    }else if($h == 2){
        echo '<td>' . $codes[2] . '</td>';
    }else if($h == 0){
        echo '<td>' . $codes[0] . '</td>';
    }
    echo '<td>'. $row['gpa']. '</td>';
    echo '<td>'. $row['credit']. '</td>';

    //echo '<td>'. $row['pid']. '</td>';
    $i  = $row['pid'];     // ユーザ種別のコードを数値で取得
    $codes = array(1=>'総合教育', 2=>'応用教育', null=>'未提出' ); //ユーザ種別を定義する配列
    if($i == 1){
        echo '<td>' . $codes[1] . '</td>';
    }else if($i == 2){
        echo '<td>' . $codes[2] . '</td>';
    }else if($i == null){
        echo '<td>' . $codes[null] . '</td>';
    }
    //echo '<td>' . $codes[$i] . '</td>'; // ユーザ種別名を配列の要素として出力
    
    //echo '<td>'. $row['decided']. '</td>';
    $j  = $row['decided'];     // ユーザ種別のコードを数値で取得
    $codes = array(1=>'総合教育', 2=>'応用教育', 0=>'' ); //ユーザ種別を定義する配列
    if($j == 1){
        echo '<td>' . $codes[1] . '</td>';
    }else if($j == 2){
        echo '<td>' . $codes[2] . '</td>';
    }else if($j ==0 ){
        echo '<td>' . $codes[0] . '</td>';
    }
    
    //配属決定ボタン追加：「echo '</tr>';」の直前に追加し、
    echo '<td><a href="?do=eps_decide&sid=' . $row['sid'] . '">配属決定</a></td>';
    echo '<td><a href="?do=usr_delete&uid='.$row['sid'].'">削除</a></td>';// echo '</tr>';の直前に追加
    echo '</tr>';
    $row = $rs->fetch_assoc();

}
if (isset($_GET['sid'])){//「削除」ボタンが最初に押されたとき、確認画面が表示される
    $sid = $_GET['sid'];
    echo '<h2>'. $sid . 'を本当に削除しますか?</h2>';
    echo '<form action="?do=usr_delete" method="post">';
    echo '<input type="hidden" name="confirmed_sid" value="' . $sid . '">';
    echo '<input type="submit" value="削除"> <a href="?do=eps_list"><button type="button">戻る</button></a>';
    echo '</form>';
  }else if (isset($_POST['confirmed_sid'])){//「削除」ボタンが再度押されたとき、データが削除される
     $sid = $_POST['confirmed_sid'];
     $sql = "DELETE FROM tbl_user WHERE sid='{$sid}'";
     $rs = $conn->query($sql);
     header('Location:?do=eps_list');
  }else{
    //echo '<h2>削除するユーザIDは与えられていません</h2>';
    //echo '<a href="?do=eps_list">戻る</a>';
  }
echo '</table>';
//学籍番号(sid)、氏名(sname)、性別(sex)、GPA(gpa)、修得単位数(credit), 本人希望(pid)、配属結果(decided)、「配属決定」ボタンの一覧表示

?>