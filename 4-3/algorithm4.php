<?php
// ＜アルゴリズムの注意点＞
// アルゴリズムではこれまでのように調べる力ではなく物事を論理的に考える力が必要です。
// 検索して答えを探して解いても考える力には繋がりません。
// まずは検索に頼らずに自分で処理手順を考えてみましょう。


// 以下はポーカーの役を判定するプログラムです。
// cards配列に格納したカードの役を判定し、結果表示してください。
// cards配列には計5枚、それぞれ絵柄(suit)、数字(numeber)を格納する
// 絵柄はheart, spade, diamond, clubのみ
// 数字は1-13のみ

// 上記以外の絵柄や数字が存在した場合、または同一の絵柄、数字がcards配列に存在した場合、
// 役の判定前に「手札が不正です」と表示してください。
// 役判定は関数に記述し、関数を呼び出して結果表示すること
// プログラムが完成したらcards配列を差し替えてすべての役で検証を行い、提出時にテストケースを示すこと

// <役>
// ワンペア・・・同じ数字２枚（ペア）が１組
// ツーペア・・・同じ数字２枚（ペア）が２組
// スリーカード・・・同じ数字３枚
// ストレート・・・数字の連番５枚（13と1は繋がらない）
// フラッシュ・・・同じマークが５枚
// フルハウス・・・同じ数字３枚が１組＋同じ数字２枚（ペア）が１組
// フォーカード・・・同じ数字４枚
// ストレートフラッシュ・・・数字の連番５枚＋同じマークが５枚
// ロイヤルストレートフラッシュ・・・1, 10, 11, 12, 13で同じマーク
// ※下の方が強い

// 表示例1）
// 手札は 
// heart2 heart5 heart3 heart4 culb1
// 役はストレートです

// 表示例2）
// 手札は 
// heart1 spade2 diamond11 club13 heart9
// 役はなしです

// 表示例3）
// 手札は 
// heart1 heart1 heart3 heart4 heart5
// 手札は不正です


// 手札
$cards = [
    ['suit'=>'diamond', 'number'=>1],
    ['suit'=>'heart', 'number'=>1],
    ['suit'=>'spade', 'number'=>1],
    ['suit'=>'heart', 'number'=>12],
    ['suit'=>'club', 'number'=>13],
];

$roleStrs = ["役無し","ワンペア","ツーペア","スリーカード","ストレート","フラッシュ","フルハウス","フォーカード","ストレートフラッシュ","ロイヤルストレートフラッシュ"];
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
    $suit_num = ["heart"=>0,"club"=>0,"spade"=>0,"diamond"=>0];

    // 絵柄を数える
    foreach($cards as $key=>$val)
    {
        $suit_num[$val["suit"]]++;
        $cnt_number[] = $val["number"];
    }
    asort($cnt_number);

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
    $tmpName = "";
    $tmpNum = 0;

    // カードの不正チェック
    for($i = 0;$i < count($cards);$i++)
    {
        // 現在走査中のカード情報
        $name = $cards[$i]["suit"];
        $number = $cards[$i]["number"];
        
        // 走査中のカードが規定のカードかをチェック
        if(($name !== "heart" && $name !== "spade" && $name !== "diamond" && $name !== "club")
        || ($number > 13 || $number < 1))
        {
            echo "手札が不正";
            return false;
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

    foreach($numArr as $num)
    {
        if($num == 2)
        {
            $sameCnt++;
        }
    }
    if($sameCnt == 1)
    {
        $roleResult = 1;
        $twoCard = 1;
    }
    if($sameCnt == 2)
    {
        $roleResult = 2;
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
    // ストレート(連番5枚)
    $tmpNum = 0;
    $judgeCnt = 0;
    $strateFlg = false;
    // ストレート(連番5枚)
    if($cnt_number[0] === $cnt_number[1] - 1 &&
        $cnt_number[1] === $cnt_number[2] - 1 &&
        $cnt_number[2] === $cnt_number[3] - 1 &&
        $cnt_number[3] === $cnt_number[4] - 1)
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
            break;
        }
    }

    if($strateFlg && $flashFlg)
    {
        $roleResult = 8;
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
        $roleResult = 9;
    }

    // 結果を返す
    echo $roleStrs[$roleResult];
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ポーカー役判定</title>
</head>
<body>
    <section>
        <?php exchangeCards($cards,$cnt_number)?>
        <p>手札は</p>
        <p><?php foreach($cards as $card): ?><?=$card['suit'].$card['number']." " ?><?php endforeach; ?></p>
        <p>役は<?=judge($cards,$roleStrs,$cnt_number) ?>です。</p>
    </section>
</body>
</html>