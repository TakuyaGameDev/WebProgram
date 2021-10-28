<?php 
require_once(ROOT_PATH.'/Models/Db.php');

class Player extends Db
{
    private $table = "players";
    public function __construct($db = null)
    {
        parent::__construct($db);
    }

    /**
     * playersテーブルから全てのデータの取得
     * @param integer $id 選手ID
     * @param integer $page ページ番号
     * @return Array $result 全選手データ
     */
    // 全選手データの取得
    public function findAll($page = 0):Array
    {
        // FROMの後は必ず空欄を入れるように！
        // SQL文実行の為の文字列になるので
        $sql = 'SELECT * FROM '.$this->table;
        $sql .=' LIMIT 20 OFFSET '.(20*$page);
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    // ID番号での取得
    public function findById($id = 0):Array
    {
        $sql = 'SELECT * FROM '.$this->table;
        $sql .=' WHERE id = :id';
        $sth = $this->db->prepare($sql);
        $sth->bindParam(':id',$id,PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * playersテーブルから全データ数を取得
     * 
     * @return Int $count 全選手の件数
     */
    public function countAll():Int
    {
        $sql = 'SELECT count(*) as count FROM players';
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();
        return $count;
    }

}




?>