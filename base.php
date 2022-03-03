<?php
date_default_timezone_set("Asia/Taipei");
session_start();

class DB
{
    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=web_22";
    protected $user = 'root';
    protected $pw = '';
    protected $pdo;
    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
        $this->pdo = new PDO($this->dsn, $this->user, $this->pw);
    }

    public function all(...$arg)
    {
        $sql = " SELECT * FROM $this->table ";
        switch (count($arg)) {
            case 1:
                if (is_array($arg[0])) {
                    foreach ($arg[0] as $key => $value) {
                        $tmp[] = "`$key`='$value'";
                    }
                    $sql .= " WHERE " . implode("AND", $tmp);
                } else {
                    $sql .= $arg[0];
                }

                break;
            case 2:
                foreach ($arg[0] as $key => $value) {
                    $tmp[] = "`$key`='$value'";
                }
                $sql .= " WHERE " . implode(" AND ", $tmp) . " " . $arg[1];
                break;
        }

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function math($math, $col, ...$arg)
    {
        // 複製all *改成$math($col)
        $sql = " SELECT $math($col) FROM $this->table";

        switch (count($arg)) {
            case 1:
                if (is_array($arg[0])) {
                    foreach ($arg[0] as $key => $value) {
                        $tmp[] = "`$key`='$value'";
                    }
                    $sql .= " WHERE " . implode("AND", $tmp);
                } else {
                    $sql .= $arg[0];
                }

                break;
            case 2:
                foreach ($arg[0] as $key => $value) {
                    $tmp[] = "`$key`='$value'";
                }
                $sql .= " WHERE " . implode("AND", $tmp) . " " . $arg[1];
                break;
        }
        //return的fetchall改成fetchColumn()
        return $this->pdo->query($sql)->fetchColumn();
    }
    public function find($id)
    {
        //複製 all的sql語句,句尾多了where
        $sql = "SELECT * FROM $this->table WHERE ";

        //複製 all的is_array那部分
        //將arg[0]改成id
        //刪除where
        //else部分的要改成`id`='$id'
        if (is_array($id)) {
            foreach ($id as $key => $value) {
                $tmp[] = "`$key`='$value'";
            }
            $sql .= implode(" AND ", $tmp);
        } else {
            $sql .= "`id`='$id'";
        }

        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    public  function del($id)
    {
        //從id複製來的
        //select * 要改成delete
        //return要改成exec($sql)
        $sql = "DELETE FROM $this->table WHERE ";


        if (is_array($id)) {
            foreach ($id as $key => $value) {
                $tmp[] = "`$key`='$value'";
            }
            $sql .= implode(" AND ", $tmp);
        } else {
            $sql .= " `id`='$id'";
        }
        return $this->pdo->exec($sql);
    }


    public function save($array)
    {
        //判斷資料陣列中是否有帶有 'id' 這個欄位，有則表示為既有資料的更新
        //沒有 'id' 這個欄位則表示為新增的資料
        if (isset($array['id'])) {
            foreach ($array as $key => $value) {
                $tmp[] = "`$key`='$value'";
            }
            $sql="UPDATE $this->table SET" . implode(",", $tmp) ." WHERE `id`='{$array['id']}'";
        }else{
            $sql="INSERT INTO $this->table (`" . implode("`,`",array_keys($array)). "`)VALUES('" . implode("','",$array). "')";

        }
        return $this->pdo->exec($sql);
    }


    public function q($sql)
    {
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}

function dd($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}


function to($url)
{
    header("location:" . $url);
}

$Que = new DB('que');
$Log = new DB('log');
$User = new DB('user');
$News = new DB('news');
$View = new DB('view');


// 先判斷在view資料表裡面有沒有(有沒有這件事我們都是用math來算)
if(!isset($_SESSION['view'])){
    //請去找有沒有今天的紀錄，如果有(=已經大於0)，請撈出來
    //if代表有存在的話,就要+1
    if($View->math('count', '*' ,['date' => date("Y-m-d")]) > 0) { 
    //$大寫的View表示資料表
    //find(這邊複製上面的['date'=>date("Y-m-d")])
    $view=$View->find(['date' => date("Y-m-d")]);
    // $view['total'] += 1;
    $view['total']++;
    // +1之後就把東西存回去
    $View->save($view);
    //再建一個session，表示我已經有記錄這個狀態了
    //這個人已經有session['view']了
    //$view['total']複製上面的就好
    $_SESSION['view']=$view['total'];
    }else{
    // 沒有存在的話
    //會造成這個狀況的代表他是今天第一個來瀏覽的人，所以直接給他1
    $View->save(['date'=>date("Y-m-d"),'total'=>1]);
    $_SESSION['view'] = 1;
}

}
