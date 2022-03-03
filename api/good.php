<?php include_once "../base.php";


// 我會拿到我news的id
$news = $_POST['news'];
//我會知道我的type是什麼
$type = $_POST['type'];

// 然後要根據type做出不同的反應
switch ($type) {
    case 1:
        //收回讚
        $Log->del(['news'=>$news,'user'=>$_SESSION['login']]);
        $post=$News->find($news);
        $post['good']--;
        $News->save($post);
        break;

    case 2:
        //按讚
        //如果是按讚的話,在log這張資料表上幫我用save的方式寫進一筆資料
        //什麼資料呢?news文章xxx,被使用者user(就是登入的使用者)
        $Log->save(['news'=>$news,'user'=>$_SESSION['login']]);
        //找出文章
        $post=$News->find($news);
        $post['good']++;
        $News->save($post);
        break;
}