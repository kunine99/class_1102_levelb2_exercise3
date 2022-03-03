<!--題目49頁 圖23 
    先做投票頁,有投票再來才有投票的結果 
-->
<?php
    // 我們到這個頁面時有丟一個id過來
    // 那我們現在可以利用這個id去抓到題目
    // $Que你傳過來的get
    //記住我要拿到的是$subject主題的資料
    $subject=$Que->find($_GET['id'])
    ?>
    <fieldset>
        <!-- 主題資料的內容我可以顯示在這個地方 -->
        <legend>目前位置：首頁 >問卷調查><?=$subject['text']?></legend>
        <h3><?=$subject['text']?></h3>
    <!-- 這邊要放選項的列表,所以要把他撈出來-->



<!-- 表單從這裡開始包 -->

<form action="api/vote.php" method="post">
    <?php
    // 因為選項不只一個,所以我要去找到all全部的
    //值是我的'parent'的$_GET['id']]資料
    // $options=$Que->all(['parent'=>$_GET['id']]);
    // $subject['id'] 和 $_GET['id'] 是一樣的東西,都是我主題的選項內容
    $options=$Que->all(['parent'=>$subject['id']]);

    // 因為我們會有編號用$key來做編號
    foreach($options as $key => $opt){
    // 因為中間內容會有很多的東西
    //所以看我們是要echo還是寫在外部都可以(我們這裡是用外部)
    ?>
    <!-- 我們裡面的東西要是radio button再加上圖線
    用p標籤方便隔開,用div太近了-->
    <p>
        <!-- radio是單選
            我不需要id,因為我要直接用form表單來做,所以直接給他value
            要顯示的是我的$opt['id'],因為我要知道這個選項的id是誰
            因為我們radio是單選所以name不用加陣列
            如果是多選name就要放opt[]-->
        <input type="radio" name="opt" value="<?=$opt['id']?>">
        <!-- 這邊是顯示文字 因為input本身是屬於行內標籤
             所以可加可不加span反正他都會顯示在後面-->
        <?=$opt['text']?>
    </p>

    <?php
    }
    ?>
    <!-- 迴圈結束後告訴他我有個按鈕 -->
    <div>
        <input type="submit" value="我要投票">
    </div>
</form>

<!-- 表單包到這裡 -->


    </fieldset>



<!-- 實務上來說因為有人可以不選直接按我要投票
所以看你要不要給他個預設值 或是做個檢查 ,丟個沒有投票的錯誤訊息給他-->