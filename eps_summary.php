<h3>希望状況集計</h3>
<?php
require_once('db_inc.php');

// 一覧データを検索するSQL文

$sql = "SELECT pid, COUNT(*) as people FROM tbl_wish GROUP BY pid UNION
SELECT pid, 0 as people FROM tbl_program WHERE pid NOT IN (SELECT pid FROM tbl_wish)
ORDER BY pid;";


//データベースへ問合せのSQL文($sql)を実行する・・・
$rs = $conn->query($sql);
if (!$rs) die('エラー: ' . $conn->error);

//プログラムID(pid)、希望人数(people)の一覧表示
echo '<table border=1>';
$row= $rs->fetch_assoc();

//echo '<tr><th>プログラムID</th><th>希望者数</th></tr>';

/*
while ($row){
    echo '<tr>';
    
    //echo '<td>' . $row['pid']. '</td>';
    $i  = $row['pid'];     // ユーザ種別のコードを数値で取得
    $codes = array(1=>'総合教育', 2=>'応用教育', 0=>'未提出' ); //ユーザ種別を定義する配列
    echo '<td>' . $codes[$i] . '</td>';
    if($i == 0){
        echo '';
    }

    echo '<td>'. $row['people']. '</td>';
    //echo '<td>'. $row['decide']. '</td>';
    */

    if ($row) {
        echo '<tr><th>プログラムID</th><th>希望者数</th></tr>';
        
        $i  = $row['pid'];     // ユーザ種別のコードを数値で取得
        $codes = array(1=>'総合教育', 2=>'応用教育', 0=>'未提出' ); //ユーザ種別を定義する配列
        //echo '<td>' . $codes[$i] . '</td>';
        if($i == 1){
            echo '<td>' . $codes[$i] . '</td>';
        }
        if($i == 2){
            echo '<td>' . $codes[$i] . '</td>';
        }
        echo '<td>'.$row['people']. '</td>';
      }
    //$row = $rs->fetch_assoc();




echo '</table>';
?>