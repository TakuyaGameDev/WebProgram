﻿<?php
// 以下をfor文を使用して表示してください。
// ヒント: forの中でforを３回使用

// ***1
// **121
// *12321
// 1234321
// 1から4まで回す
for ($i=1; $i < 5 ; $i++)
{
    // 上のfor文で現在回っている結果で回る回数が決まる
    for ($j = 3; $j >= $i ; $j--)
    {
        echo "*";
    }
    // 上のfor文で現在回っている結果で表示される数字が決まる
    for ($k=1; $k <= $i ; $k++) 
    {
        echo $k;
    }

    for ($l = 3; $l >= 6 - $k; $l--) 
    {
        echo $l - 4 + $i;
    }
    // 改行
    echo '<br>';
}

?>