﻿<?php
// 以下をfor文を使用して表示してください。

// ****5
// ***545
// **54345
// *5432345
// 543212345

for($i = 1;$i < 6;$i++)
{
    for($k = 4;$k >= $i;$k--)
    {
        echo "*";
    }
    for($j = 0;$j < $i;$j++)
    {
        echo 5-$j;
    }
    for($s = 6 - $i;$s < 5;$s++)
    {
        echo $s+1;
    }
    echo '<br>';
}