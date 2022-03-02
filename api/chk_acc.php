<?php include_once "../base.php";
// 我在前端用post的方式把東西送過來，所以這邊一定會拿到資料
$acc=$_POST['acc'];
// 不可以直接find,這樣會把整筆資料撈出來,要用math
//count算筆數,全部的欄位,條件是acc這個欄位要等於前面用ajax傳過來的acc
$chk=$User->math('count','*',['acc'=>$acc]);
//SELECT count(*) from user where acc='admin'



//我會得到一個值
//如果這個值>0表示這筆資料已經在資料庫內了
if($chk>0){
    echo 1;
}else{
    echo 0;
}