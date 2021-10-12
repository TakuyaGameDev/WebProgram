<?php
// ＜アルゴリズムの注意点＞
// アルゴリズムではこれまでのように調べる力ではなく物事を論理的に考える力が必要です。
// 検索して答えを探して解いても考える力には繋がりません。
// まずは検索に頼らずに自分で処理手順を考えてみましょう。


// 「algorithm5」で作成したポーカープログラムにジョーカーを追加してください。
// ジョーカー１枚のみ、suitをjoker、numberを0と表す。
// 上記以外は不正として処理してください。

// 追加された役
// 「フォーカード」＋ジョーカーは「ファイブカード」

// 判定は強い役を優先してください。組み合わせの強さ順は以下とする。
// ロイヤルストレートフラッシュ > ストレートフラッシュ > ファイブカード > フォーカード > フルハウス > フラッシュ > ストレート > スリーカード > ツーペア > ワンペア
// ジョーカーが出た時点で最低でも「ワンペア」となること


// 手札
$cards = [
    ['suit'=>'spade', 'number'=>8],
    ['suit'=>'spade', 'number'=>7],
    ['suit'=>'diamond', 'number'=>6],
    ['suit'=>'diamond', 'number'=>4],
    ['suit'=>'joker', 'number'=>0],
];

$roleStrs = ["役無し","ワンペア","ツーペア","スリーカード","ストレート","フラッシュ","フルハウス","フォーカード","ファイブカード","ストレートフラッシュ","ロイヤルストレートフラッシュ"];
// 手持ちの数字の数
$cnt_number = [];
function exchangeCards(&$cards,&$cnt_number)
{
        // 並び替え後の配列
        $sortedCards = [['suit'=>"",'number'=>0],
        ['suit'=>"",'number'=>0],
        ['suit'=>"",'number'=>0],
        ['suit'=>"",'number'=>0],
        ['suit'=>"",'number'=>0],
    ];
    // 絵柄が何枚あるかを数えるカウント
    $suit_num = ["heart"=>0,"club"=>0,"spade"=>0,"diamond"=>0,"joker"=>0];

    // 絵柄を数える
    foreach($cards as $key=>$val)
    {
        $suit_num[$val["suit"]]++;
        $cnt_number[] = $val["number"];
    }
    // 配列を降順に並び替え
    rsort($cnt_number);

    echo "----before-----";
    echo "1:".$cnt_number[0];
    echo "2:".$cnt_number[1];
    echo "3:".$cnt_number[2];
    echo "4:".$cnt_number[3];
    echo "5:".$cnt_number[4];
    // 絵柄が多い順に並び替え
    arsort($suit_num);
    $s = 0;
    foreach($suit_num as $key=>$val)
    {
        for($i = 0;$i < $val;$i++)
        {
            $sortedCards[$s]["suit"] = $key;
            $s++;
        }
    }
    for($i = 0;$i < count($cards);$i++)
    {
        $name = $cards[$i]["suit"];
        $num = $cards[$i]["number"];
        for($s = 0;$s < count($sortedCards);$s++)
        {
            if($name === $sortedCards[$s]["suit"])
            {
                if($sortedCards[$s]["number"] !== 0)
                {
                    continue;
                }
                else
                {
                    $sortedCards[$s]["number"] = $num;
                    break;
                }
            }
        }
    }

    for($s = 0;$s < count($cards);$s++)
    {
        $cards[$s]["suit"] = $sortedCards[$s]["suit"];
        $cards[$s]["number"] = $sortedCards[$s]["number"];
    }
}

function judge($cards,$roleStrs,$cnt_number) {
    // この関数内に処理を記述
    // この関数内に処理を記述
    $tmpName = "";
    $tmpNum = 0;
    // ジョーカーの枚数
    $jokerNum = 0;
    // カードの不正チェック
    for($i = 0;$i < count($cards);$i++)
    {
        // 現在走査中のカード情報
        $name = $cards[$i]["suit"];
        $number = $cards[$i]["number"];
        // ジョーカーの枚数を加算していく
        if($name === "joker")
        {
            $jokerNum++;
        }
        // 走査中のカードが規定のカードかをチェック
        if($jokerNum >= 2)
        {
            if((($name !== "heart" && $name !== "spade" && $name !== "diamond" && $name !== "club"))
            || ($number > 13 || $number < 1) )
            {
                echo "手札が不正";
                return false;
            }
        }
        for($j = 0;$j < count($cards);$j++)
        {
            // 自身でなければチェックを入れる
            if($j !== $i)
            {
                if($name === $cards[$j]["suit"] &&
                   $number === $cards[$j]["number"])
                {
                    echo "手札が不正";
                    return false;
                }
            }
        }
        // 次のループで比較対象にするカード名と数字を格納
        $tmpName = $name;
        $tmpNum = $number;
    }

    // 役判定
    $twoCard = 0;
    $threeCard = 0;
    $roleResult = 0;
    $tmpSuit = "";
    $tmpNum = 0;
    $sameCnt = 0;
    $beg = 0;
    // ワンペアチェック
    $numArr = array_count_values($cnt_number);

    $jokerFlg = false;
    if($jokerNum < 1)
    {
        foreach($numArr as $num)
        {
            if($num == 2)
            {
                $sameCnt++;
            }
        }
    }
    else
    {
        foreach($cnt_number as $n)
        {
            if($n === 0)
            {
                $jokerFlg = true;
                $sameCnt = 1;
            }
        }
        foreach($numArr as $n)
        {
            if($jokerFlg)
            {
                if($n === 2)
                {
                    $roleResult = 3;
                }
            }
        }
        if(!$jokerFlg)
        {
            foreach($numArr as $num)
            {
                if($num == 2)
                {
                    $sameCnt++;
                }
            }
        }
    }
    if(!$jokerFlg)
    {
        if($sameCnt == 1)
        {
            $roleResult = 1;
            $twoCard = 1;
        }
        if($sameCnt == 2)
        {
            $roleResult = 2;
        }
    }

    foreach($numArr as $num)
    {
        if($num == 3)
        {
            $roleResult = 3;
            $threeCard = 1;
            break;
        }
    }



    $tmpNum = 0;
    $judgeCnt = 0;
    $strateFlg = false;
    if($jokerFlg)
    {
        if($cnt_number[3] === 1)
        {
            $cnt_number[4] += 5;
            rsort($cnt_number);
        }
        else{
            $cnt_number[4] = $cnt_number[3] - 1;
        }
    }
    // ストレート(連番5枚)
    if($cnt_number[1] === $cnt_number[0] - 1 &&
        $cnt_number[2] === $cnt_number[1] - 1 &&
        $cnt_number[3] === $cnt_number[2] - 1 &&
        $cnt_number[4] === $cnt_number[3] - 1)
    {
        $strateFlg = true;
    }

    if($strateFlg)
    {
        $roleResult = 4;
    }

    // フラッシュ
    $flashFlg = false;
    $sameCnt = 1;
    foreach($cards as $val)
    {
        if($val["suit"] === $tmpSuit)
        {
            $sameCnt++;
        }
        $tmpSuit = $val["suit"];
    }
    if($sameCnt === 5)
    {
        $flashFlg = true;
        $roleResult = 5;
    }
    // フルハウス
    if($twoCard && $threeCard)
    {
        $roleResult = 6;
    }

    foreach($numArr as $num)
    {
        if($num == 4)
        {
            $roleResult = 7;
        }
        if($jokerNum === 1 && $roleResult === 7)
        {
            $roleResult = 8;
        }
    }

    

    if($strateFlg && $flashFlg)
    {
        $roleResult = 9;
    }

    $royalStrateFlg = true;
    foreach($cnt_number as $num)
    {
        if($num !== 1 && $num !== 10 && $num !== 11 && $num !== 12 && $num !== 13)
        {
            $royalStrateFlashFlg = false;
        }
    }

    if($royalStrateFlg && $flashFlg)
    {
        $roleResult = 10;
    }
    // 結果を返す
    return $roleStrs[$roleResult];
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ポーカー役判定（ジョーカーあり）</title>
</head>
<body>
    <section>
        <?php exchangeCards($cards,$cnt_number)?>
        <p>手札は</p>
        <p><?php foreach($cards as $card): ?><?=$card['suit'].$card['number']." " ?><?php endforeach; ?></p>
        <p>役は<?php echo judge($cards,$roleStrs,$cnt_number) ?>です。</p>
    </section>
</body>
</html>