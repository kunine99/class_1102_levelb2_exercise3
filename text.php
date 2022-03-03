<?php

date_default_timezone_set("Asia/Taipei");
session_start();

class DB
{


    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=web_21";

    protected $user = "root";

    protected $pw = '';

    protected $pdo;

    protected $table;

    //建立建構式，在建構時帶入table名稱會建立資料庫的連線
    public function __construct($table)
    {
        $this->table = $table;
        $this->pdo = new PDO($this->dsn, $this->user, $this->pw);
    }
    //此方法可能會有不帶參數，一個參數及二個參數的用法，因此使用不定參數的方式來宣告


    public function all(...$arg)
    {
        //在class中要引用內部的成員使用$this->成員名稱或方法
        //當參數數量不為1或2時，那麼此方法就只會執行選取全部資料這一句SQL語法
        $sql = "SELECT * FROM $this->table ";
        //依參數數量來決定進行的動作因此使用switch...case
        switch (count($arg)) {
           
            case 1:
                //判斷參數是否為陣列
                if (is_array($arg[0])) {
                    //使用迴圈來建立條件語句的字串型式，並暫存在陣列中
                    foreach ($arg[0] as $key => $value) {
                        $tmp[] = "`$key`='$value'";
                    }
                    //使用implode()來轉換陣列為字串並和原本的$sql字串再結合
                    $sql .= " WHERE " . implode(" AND ", $tmp);
                } else {
                    //如果參數不是陣列，那應該是SQL語句字串，因此直接接在原本的$sql字串之後即可
                    $sql .= $arg[0];
                }
                break;
                //執行連線資料庫查詢並回傳sql語句執行的結果
                 case 2:
                //第一個參數必須為陣列，使用迴圈來建立條件語句的陣列
                foreach ($arg[0] as $key => $value) {
                    $tmp[] = "`$key`='$value'";
                }
                //將條件語句的陣列使用implode()來轉成字串，最後再接上第二個參數(必須為字串)
                $sql .= " WHERE " . implode(" AND ", $tmp) . " " . $arg[1];
                break;
        }
        //fetchAll()加上常數參數FETCH_ASSOC是為了讓取回的資料陣列中只有欄位名稱
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function math($method, $col, ...$arg)
    {
        // 複製all *改成$math($col)
        //return的fetchall改成fetchColumn()
        $sql = "SELECT $method($col) FROM $this->table ";
        switch (count($arg)) {
            
            case 1:
                //判斷參數是否為陣列
                if (is_array($arg[0])) {
                    //使用迴圈來建立條件語句的字串型式，並暫存在陣列中
                    foreach ($arg[0] as $key => $value) {
                        $tmp[] = "`$key`='$value'";
                    }
                    //使用implode()來轉換陣列為字串並和原本的$sql字串再結合
                    $sql .= " WHERE " . implode(" AND ", $tmp);
                } else {
                    //如果參數不是陣列，那應該是SQL語句字串，因此直接接在原本的$sql字串之後即可
                    $sql .= $arg[0];
                }
                break;
                //執行連線資料庫查詢並回傳sql語句執行的結果
                case 2:
                //第一個參數必須為陣列，使用迴圈來建立條件語句的陣列
                foreach ($arg[0] as $key => $value) {
                    $tmp[] = "`$key`='$value'";
                }
                //將條件語句的陣列使用implode()來轉成字串，最後再接上第二個參數(必須為字串)
                $sql .= " WHERE " . implode(" AND ", $tmp) . " " . $arg[1];
                break;
        }
        //fetchColumn()只會取回的指定欄位資料預設是查詢結果的第1欄位的值
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
  



    public function del($id)
    {
        // 從id複製來的
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
            //update
            foreach ($array as $key => $value) {
                $tmp[] = "`$key`='$value'";
            }
            //建立更新資料(update)的sql語法
            $sql = "UPDATE $this->table SET " . implode(",", $tmp) . " WHERE `id`='{$array['id']}'";
        } else {
            //insert

            $sql = "INSERT INTO $this->table (`" . implode("`,`", array_keys($array)) . "`)VALUES('" . implode("','", $array) . "')";

            //建立新增資料(insert)的sql語法
            /* 覺得一行式寫法太複雜可以利用變數把語法拆成多行再組合
             * $cols=implode("`,`",array_keys($array));
             * $values=implode("','",$array);
             * $sql="INSERT INTO $table (`$cols`) VALUES('$values')";        
             */
        }

        //echo $sql;
        return $this->pdo->exec($sql);
    }
    public function q($sql)
    {
        // 從all 複製來的
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}



function dd($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

//此函式會獨立在 DB 這個類別外，但是會和共用檔放在一起，然後include到所有的頁面去使用
//主要目的是簡化header指令的語法，避免拚字錯誤之類的事發生。
function to($url)
{
    header("location:" . $url);
}


//建議使用首字母大寫來代表這是資料表的變數，方便和全小寫的變數做出區隔
$User = new DB('user');
$News = new DB('news');
$View = new DB('view');
$Que = new DB('que');
$Log = new DB('log');
//etc

// 在base檔判斷你有沒有曾經進來的紀錄
// 有->瀏灠人次加1
// 沒有->增加今日的新紀錄,瀏灠人次為1


if (!isset($_SESSION['view'])) {
    // 先判斷在view資料表裡面有沒有(有沒有這件事我們都是用math來算)
    // 請去找有沒有今天的紀錄，如果有(=已經大於0)，請撈出來
    //if代表有存在的話,就要+1
    if ($View->math('count', '*', ['date' => date("Y-m-d")]) > 0) {
        //$大寫的View表示資料表
        //find(這邊複製上面的['date'=>date("Y-m-d")])
        $view = $View->find(['date' => date("Y-m-d")]);
        $view['total']++;
        // +1之後就把東西存回去
        // $view['total'] += 1;
        $View->save($view);
        //再建一個session，表示我已經有記錄這個狀態了
        //這個人已經有session['view']了
        //$view['total']複製上面的就好
        $_SESSION['view'] = $view['total'];
    } else {
        // 沒有存在的話
        //會造成這個狀況的代表他是今天第一個來瀏覽的人，所以直接給他1
        $View->save(['date' => date("Y-m-d"), 'total' => 1]);
        $_SESSION['view'] = 1;
    }
}
