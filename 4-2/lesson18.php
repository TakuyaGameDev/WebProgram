<?php
// 以下配列の中身をfor文を使用して表示してください。
// 表示はHTMLの<table>タグを使用すること

/**
 * 表示イメージ
 *  _________________________
 *  |_____|_c1|_c2|_c3|横合計|
 *  |___r1|_10|__5|_20|___35|
 *  |___r2|__7|__8|_12|___27|
 *  |___r3|_25|__9|130|__164|
 *  |縦合計|_42|_22|162|__226|
 *  ‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
 */

$arr = [
    'r1' => ['c1' => 10, 'c2' => 5, 'c3' => 20],
    'r2' => ['c1' => 7, 'c2' => 8, 'c3' => 12],
    'r3' => ['c1' => 25, 'c2' => 9, 'c3' => 130]
];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>テーブル表示</title>
<style>
table {
    border:1px solid #000;
    border-collapse: collapse;
}
th, td {
    width:50px;
    height:auto;
    border:1px solid #000;
    text-align: right;
}
</style>
</head>
<body>
    <!-- ここにテーブル表示 -->
    <table>
        <thead>
            <?php
            echo "<th></th><th>c1</th><th>c2</th><th>c3</th><th>横合計</th>";
            $colSum = array("c1"=>0,"c2"=>0,"c3"=>0);
            $allSum = 0;
            foreach($arr as $key1=>$val1)
            {
                $rowSum = 0;
                echo "<tr>";
                echo "<th>$key1</th>";
                foreach($val1 as $key2=>$val2)
                {
                    $colSum[$key2]+= $val2;
                    echo "<td>$val2</td>";
                    $rowSum += $val2;
                }
                echo "<td>$rowSum</td>";
                $allSum += $rowSum;
                echo "</tr>";
            }
            echo "<tr>";
            echo "<th>縦合計</th>";
            foreach($colSum as $value)
            {
                echo "<td>$value</td>";
            }
            echo "<td>$allSum</td>";
            echo "</tr>";
            ?>

        <thead>
    <tbody>
</body>
</html>