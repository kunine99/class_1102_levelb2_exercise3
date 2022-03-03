<!-- 複製來自vote.php 
因為這邊只要看結果所以它不需要表單
1.所以拿掉form表單
2.p標籤改成div,裡面的input只留內容<?=$opt['text']?>
3.接2,幫他加div跟style,再加上編號$key數字
etc...
-->

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

    <?php
    // 因為選項不只一個,所以我要去找到all全部的
    //值是我的'parent'的$_GET['id']]資料
    // $options=$Que->all(['parent'=>$_GET['id']]);
    // $subject['id'] 和 $_GET['id'] 是一樣的東西,都是我主題的選項內容
    $options=$Que->all(['parent'=>$subject['id']]);

    // 因為我們會有編號用$key來做編號
    foreach($options as $key => $opt){
        // 為了算幾%的票,這邊先處理分母的問題
        // 本來想取$division但太長了改成$div就好
        // 我要拿我的主題來判斷,所以($subject['count']是否=0
        // 如果它=0那我的分母應該是1
        // 如果它不等於0,那我就是用它的count來做分母
        $div=($subject['count']==0)?1:$subject['count'];

        // 分子就是我現在foreach迴圈得到的$opt['count']
        //$opt['count']/$div我就會得到我的比例
        // 看要不要做4捨5入都可以
        // 沒做的話寫這樣就好了
        // $rate=$opt['count']/$div;
        // 要做的話就這樣寫round代表4捨5入的函式,因為我要取兩位數所以放2
        $rate=round($opt['count']/$div,2);

    ?>
    <!-- 覺得太擠可以加margin -->
    <div style="display: flex;margin: 5px 0;">
        <!-- $key從0開始算所以要+1 -->
        <div style="width: 40%;"><?=($key+1).".".$opt['text']?></div>
        <!-- 放長條圖用的div rate是比例,40代表我們留給這行的width-->
        <div style="height:25px;background:#ccc;width:<?=40*$rate;?>%"></div>
        <!-- 顯示幾票幾票的div *100讓它數字不要太小-->
        <div><?=$opt['count'];?>票(<?=$rate*100?>)%</div>
        <!-- <div><?=$opt['count'];?>票()%</div> -->

    </div>

    <?php
    }
    ?>
    <!-- 迴圈結束後告訴他我有個按鈕返回 -->
    <div class="ct">
        <!-- 其實這個返回功能可以不用做,因為題目沒有講要做 -->
        <button onclick="location.href='?do=que'">返回</button>
    </div>



    </fieldset>


<!-- 
關於投票的百分比%寫法
本來是這樣寫
<div>< ?=$opt['count'];?>票(< ?=round($opt['count']/$subject['count'],2)*100?>)%</div>
(意思是
 票數後面要顯示比例 = 我的票數$opt['count']要去算我總計的東西
 round是4捨5入  2代表除完的數字幫我抓兩位數,*100b讓它數字不要太小)
但這樣寫會有問題,因為分母不能為0
這時候有兩個做法
做法1.
既然你已經知道沒有投票的問卷會報錯誤訊息
那你就都先投票
這樣考試時就不會報錯
做法2.
既然我已經知道位有這個狀況(分母為0)發生
我就要先去做判斷
判斷分母不可為0
如果今天分母為0,我就要把分母這個東西改為1
因為分母可以為1, 任何數除以1都還是任何數
其實檢定不需要那麼麻煩,但實務上像是藥店傷或是報表上就需要判斷分母是不是0
所以就學學
-->