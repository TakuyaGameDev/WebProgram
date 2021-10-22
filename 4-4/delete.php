
<?php require_once 'DBManager.php'; ?>
<?php include 'header.php'; ?>
<?php 
session_start();
    try
    {
        //DBへの接続を確立
        $db = getDB();
        // id番号の取得(contact.phpから?でつないで変数を渡しているのできちんと反映されている)
        $id = $_GET['id'];
        // DELETE文を変数に格納
        $sql = "DELETE FROM contacts WHERE id = :id";
        
        // 削除するレコードのIDは空のまま、SQL実行の準備をする
        $stmt = $db->prepare($sql);
        
        // 削除するレコードのIDを配列に格納する
        $params = array(':id'=>$id);
        
        // 削除するレコードのIDが入った変数をexecuteにセットしてSQLを実行
        $stmt->execute($params);
 
        // 削除完了のメッセージ
        echo '削除完了しました';
    }
    catch (PDOException $e) 
    {
        print "エラーメッセージ：{$e->getMessage()}";
    } 
    finally
    {
        $db = null;
    }


?>



<a href="contact.php">フォームへ戻る</a>

<?php include 'footer.php'; ?>

