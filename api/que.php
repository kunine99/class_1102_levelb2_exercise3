<?php include_once "../base.php";

// 先增加主題,主題是用post進來的subject
$subject=$_POST['subject'];
// 要增加到資料庫的名稱
//這筆資料text文字的內容是我的$subject
//他的parent是0,表示題目 id
//count表示統計,因為還沒有人投票,所以預設0
$Que->save(['text'=>$subject,'parent'=>0,'count'=>0]);

// 主題都還沒寫進去,要怎麼找你的問卷?
// 為解題方便直接去找id最大的就是最新新增的
//但在外面不能這樣做,搞不好有人為早你0.00001秒新增,這樣就會找錯
$parent_id=$Que->math("max","id");

//外面通常會限制問卷的題目內容不能重複,也通常會檢查問卷題目有沒有重複
//$parent_id=$Que->find(['text'=>$subject])['id'];
//也通常要檢查選項有沒有空白
//像是一開始就要放if($_POST['subject'])!=""{}   
//或是if(!empty($_POST['options']) &&) 這樣去檢查

//當作你一定會寫資料在裡面,每筆資料都給你撈出來
foreach($_POST['options'] as $opt){
// 新增的話告訴他你的文字應該是$opt的內容
//因為我這個options陣列只會存文字,然後他是一個陣列的方式存在,所以你的文字內容就是他
//parent就是我們剛抓到的$parent_id
//因為是新增,所以count應該是0(還沒有人投票)
    $Que->save(['text'=>$opt,'parent'=>$parent_id,'count'=>0]);


}




to("../back.php?do=que");



