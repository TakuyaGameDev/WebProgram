<?php  

require_once(ROOT_PATH.'Controllers/PlayerController.php');
$player = new PlayerController();
$params = $player->index();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>オブジェクト指向 - 選手一覧</title>
        <link rel="stylesheet" type="text/css" href="/css/base.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
    </head>
<body>
    <h2>■選手一覧</h2>
    <table width="100%" border="5" rules="rows">
    <tr>
        <th>No</th>
        <th>背番号</th>
        <th>ポジション</th>
        <th>名前</th>
        <th>所属</th>
        <th>誕生日</th>
        <th>身長</th>
        <th>体重</th>
    </tr>
    <?php foreach($params['players'] as $player):?>
    <?php if($player['id'] % 2 == 0){ ?>
        <tr>
            <td><?=$player['id']; ?></td>
            <td><?=$player['uniform_num']; ?></td>
            <td><?=$player['position']; ?></td>
            <td><?=$player['name']; ?></td>
            <td><?=$player['club']; ?></td>
            <td><?=$player['birth']; ?></td>
            <td><?="{$player['height']}cm"; ?></td>
            <td><?="{$player['weight']}kg"; ?></td>
            <td><a href="view.php?id=<?=$player["id"] ?>">詳細</a></td>
        </tr>
        <?php }else{?>
        <tr bgcolor=#e0e0e0>
            <td><?=$player['id']; ?></td>
            <td><?=$player['uniform_num']; ?></td>
            <td><?=$player['position']; ?></td>
            <td><?=$player['name']; ?></td>
            <td><?=$player['club']; ?></td>
            <td><?=$player['birth']; ?></td>
            <td><?="{$player['height']}cm"; ?></td>
            <td><?="{$player['weight']}kg"; ?></td>
            <td><a href="view.php?id=<?=$player["id"] ?>">詳細</a></td>
        </tr>
        <?php };?>
    <?php endforeach;?>
    </table>

    <div id = 'paging'>
        <?php
        for($i = 0;$i <= $params['pages'];$i++)
        {
            if(isset($_GET['page']) && ($_GET['page'] == $i))
            {
                echo "<a href='?page=".$i."'>".($i+1)."</a>";
            }
            else
            {
                echo "<a href='?page=".$i."'>".($i+1)."</a>";
            }
        }
        ?>
    </div>
</body>
</html>