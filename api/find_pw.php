<?php include_once "../base.php";

// 我用post的方式把資料送過來，然後設一個$eamil
$email = $_POST['email'];

// 用eamil去找有沒有這個user,這個user是來自這個資料表
// 不要用count的方式,因為我要拿到它的資料跟確定有沒有密碼
// 我的email的欄位必須要是$email
$user = $User->find(['email' => $email]);

// 比如說打出這一串 SELECT * FROM `user` WHERE email='aaa@gmail.com';
// 如果我的資料庫有我就找的到，沒有就會回傳空資料

// 所以我的user拿到的是空的就表示沒有這筆資料
if (empty($user)) {
    echo "查無此資料";
} else {
    echo "您的密碼為:" . $user['pw'];
}
