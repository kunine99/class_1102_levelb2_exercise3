<?php include_once "../base.php";

// 先判斷有沒有這個$_POST['del']東西
if(isset($_POST['del'])){
    // 有的話表示有資料要刪除
    //每一筆資料都是一個id
    foreach ($_POST['del'] as $id) {
        // 如果有要刪除的資料我就做刪除的事情
        //要刪除的資料在$User->del($id);裡面
        $User->del($id);
    }
}

// 刪除完後回到這裡
to("../back.php?do=admin");
// 寫完後去複製reg.php到admin的form表單下面
?>