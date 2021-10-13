<?php
// 以下をfor文を使用して表示してください。

// 1
// 23
// 456
$cnt = 0;
for($i = 1;$i <= 3;$i++)
{
    if($i === 3)
    {
        $cnt = 1;
    }
    for($s = 0;$s < $i;$s++)
    {
        echo $s + $i + $cnt;
    }
    echo '<br>';
}

?>