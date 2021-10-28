<?php
require_once(ROOT_PATH.'/Models/Player.php');
require_once(ROOT_PATH.'/Models/Goal.php');

class PlayerController
{
    // リクエストパラメータ(GET,POST)
    private $request;
    // Playerモデル
    private $player;
    // Goalモデル
    private $goal;
    // コンストラクタ
    public function __construct()
    {
        // リクエストパラメータの取得
        // GETメソッドでの取得
        $this->request['get'] = $_GET;
        // POSTメソッドでの取得
        $this->request['post'] = $_POST;
        // モデルオブジェクトの生成
        $this->player= new Player();

        // 別モデルとの連携---------------------
        $db = $this->player->get_db_handler();
        $this->goal = new Goal($db);
        // ------------------------------------
    }

    // データベースから取得したデータを返す関数
    public function index()
    {
        $page = 0;
        if(isset($this->request['get']['page']))
        {
            $page = $this->request['get']['page'];
        }
        $players = $this->player->findAll($page);
        $players_count = $this->player->countAll();
        $params =
        [
            'players' => $players,
            'pages' => $players_count / 20
        ];
        return $params;
    }
    // 内部でデータの有無を検証し、データを返す
    public function view()
    {
        // GETしてきたものが空だったらエラー表示
        if(empty($this->request['get']['id']))
        {
            echo "指定のパラメータが不正です。このページを表示できません。";
            exit;
        }
        // もし取得したデータの中に情報が入っていたら取得したデータを格納
        $player = $this->player->findById($this->request['get']['id']);
        // データを配列に格納してあげる
        $params = 
        [
            'player' => $player
        ];
        // 配列データを返す
        return $params;
    }
}

?>