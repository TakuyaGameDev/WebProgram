<?php
require_once(ROOT_PATH.'Controllers/PlayerController.php');
$player = new PlayerController();
$detailParams = $player->view();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>選手詳細</title>
        <link rel="stylesheet" type="text/css" href="/css/base.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
    </head>
<body>
    <div id = "box">
        <h2>■選手詳細</h2>
    </div>
    <div id = "dtTbl">
        <table width="60%" border="5" rules="rows">
            <tr>
                <td>No</td>
                <td><?=$detailParams["player"]["id"] ?></td>
            </tr>
            <tr bgcolor="#e0e0e0">
                <td>背番号</td>
                <td><?=$detailParams["player"]["uniform_num"] ?></td>
            </tr>
            <tr>
                <td>ポジション</td>
                <td><?=$detailParams["player"]["position"] ?></td>
            </tr>
            <tr bgcolor="#e0e0e0">
                <td>名前</td>
                <td><?=$detailParams["player"]["name"] ?></td>
            </tr>
            <tr>
                <td>所属</td>
                <td><?=$detailParams["player"]["club"] ?></td>
            </tr>
            <tr bgcolor="#e0e0e0">
                <td>誕生日</td>
                <td><?=$detailParams["player"]["birth"] ?></td>
            </tr>
            <tr>
                <td>身長</td>
                <td><?=$detailParams["player"]["height"] ?></td>
            </tr>
            <tr bgcolor="#e0e0e0">
                <td>体重</td>
                <td><?=$detailParams["player"]["weight"] ?></td>
            </tr>
        </table>
        <a href="#?id=<?=$detailParams["player"]["id"] ?>">編集</a>
        <a href="#?id=<?=$detailParams["player"]["id"] ?>">削除</a>
    </div>
    <div id = "rtnBtn"><a href="index.php">トップへ戻る</a></div>
</body>
</html>