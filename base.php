<?php
date_default_timezone_set("Asiz/Taipei");
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
                    $sql .= "WHERE" . implode("AND", $tmp);
                } else {
                    $sql .= $arg[0];
                }

                break;
            case 2:
                foreach ($arg[0] as $key => $value) {
                    $tmp = "`$key`='$value'";
                }
                $sql .= "WHERE" . implode(" AND ", $tmp) . " " . $arg[1];
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
                    $sql .= "WHERE" . implode("AND", $tmp);
                } else {
                    $sql .= $arg[0];
                }

                break;
            case 2:
                foreach ($arg[0] as $key => $value) {
                    $tmp = "`$key`='$value'";
                }
                $sql .= "WHERE" . implode("AND", $tmp) . " " . $arg[1];
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
            $sql .= implode("AND", $tmp);
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
            $sql="UPDATE $this->table SET" . implode(",", $tmp) ."WHERE `id`='{$array['id']}'";
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
    echo print_r($array);
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
$View = new DB('View');
