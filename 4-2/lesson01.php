<?php
// 以下をfor文を使用して表示してください。

// 1
// 21
// 321

$sum = 0;

for($forval = 0;$forval < 3;$forval++)
{
    $sum += pow(10,$forval)*($forval+1);
    echo "{$sum}<br>";
}