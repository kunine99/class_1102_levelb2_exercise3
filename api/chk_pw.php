<?php include_once "../base.php";
//登入檢查密碼
// 懶的話可以複製chk_acc

// 我在前端用post的方式把東西送過來，所以這邊一定會拿到資料
////注意chk_acc只檢查一個,但這邊要檢查兩個所以要多一行
$acc=$_POST['acc'];
$pw=$_POST['pw'];

// 不可以直接find,這樣會把整筆資料撈出來,要用math
//count算筆數,全部的欄位,條件是acc這個欄位要等於前面用ajax傳過來的acc

////注意chk_acc只檢查一個,這邊也是要檢查兩個所以要多一行
$chk=$User->math('count','*',['acc'=>$acc,'pw'=>$pw]);
//SELECT count(*) from user where acc='admin'



//我會得到一個值
//如果這個值>0表示這筆資料已經在資料庫內了
if($chk>0){
    //帳號存在
    //既然我已經確定它是登入的使用者了,那我要建立一個session
    //告訴他這個人是$acc
    $_SESSION['login']=$acc;
    echo 1;
}else{
    //帳號或密碼錯誤
    echo 0;
}



?>