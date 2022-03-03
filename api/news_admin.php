<?php include_once "../base.php";


//因為checkbox有個特性只會傳有顯示的值過來
//所以我們這邊要在前端塞一個隱藏欄位,免得漏掉沒有顯示的值
//這樣我才知道我前端送過來多少筆資料,哪一些要做修改


// 先判斷id存不存在
foreach ($_POST['id'] as $id) {
    // 如果他是存在的而且他的id又在這個裡面的話
    //如果$_POST['del']有被勾選的話,表示他要被刪除
    //勾選就算了,我的這個$id又在你的$_POST['del']這個陣列裡面
    if(isset($_POST['del']) && in_array($id,$_POST['del'])){
        //表示你就是要被刪除
        $News->del($id);
    }else{
        // 如果你沒有要被刪除,表示你是要被修改他的顯示
        //我們先把他撈出來
        $news=$News->find($id);
        // 他要顯示的就是=(isset($_POST['sh']) && in_array($id,$_POST['sh']))
        //如果這個sh的陣列式存在的表示有資料要顯示,而且我這個迴圈跑的id又剛好在裡面
        //表示他就是要顯示,他要顯示的我就設為1,不顯示就設為0
        $news['sh']=(isset($_POST['sh']) && in_array($id,$_POST['sh']))?1:0;
        $News->save($news);
    }
}

// 老師不建議的做法是因為那個做法會把整張資料表撈出來
// 但我們只要分頁的那3筆資料就好,這種做法有點多餘,所以才不建議


to("../back.php?do=news");