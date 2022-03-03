<fieldset>
    <!-- 題組二考題第11項目建置最新文章區 -->
    <legend>目前位置：首頁 > 最新文章區</legend>
    <!-- table>tr*2>td*3 -->
    <table>
        <tr>
            <td width="30%">標題</td>
            <td width="50%">內容</td>
            <td></td>
        </tr>
        <?php
        // 先算出總共有幾篇文章
        $total = $News->math("count", "*");
        // 接下來告訴他五筆換一頁
        $div = 5;
        //算總頁數
        $pages = ceil($total / $div);
        // 拿到總頁數後要知道現在在哪一頁
        //哪一頁我們是用網址頁來做,寫3元運算
        //如果有$_GET['p']這個東西的話,我就用這頁數,不然就從第一頁開始
        $now = $_GET['p'] ?? 1;
        // 知道現在的頁數後就要知道我們要從哪一筆資料開始撈
        // 比如說五筆資料就是0 5 10 15 這樣撈
        // 比如說3筆資料就是0 3 6 9 這樣撈
        $start = ($now - 1) * $div;
        // 拿到東西後就可以去撈我所有的資料
        //我要撈出被設定sh是1的
        //因為我要做分頁,所以我要限制limit,文章是從start開始抓多少筆資料出來
        $rows = $News->all(['sh' => 1], " limit $start,$div");
        // 抓到資料後把它顯示出來
        foreach ($rows as $key => $row) {
        ?>
            <tr>
                <!-- 第一個要顯示title -->
                <td class="switch"><?= $row['title']; ?></td>
                <!-- 第二個要顯示文章內容 
                用mb_substr去抓它一點點的文章內容
                從0開始抓大概20個字-->
                <td class="switch">
                    <div class="short"><?= mb_substr($row['text'], 0, 20); ?>...</div>
                    <!-- 要用顯示隱藏功能 
                td 加class switch
                div加上不同的class方便識別 -->
                    <div class="full" style="display: none;"><?= nl2br($row['text']); ?></div>

                </td>
                <td>
                    <!-- 做按讚功能,先判斷它有沒有登入 -->
                    <?php
                    // 如果你登入的session有在
                    if(isset($_SESSION['login'])){
                        // 先檢查你有沒有按做讚,條件是news這個欄位是我這篇文章的id,user是登入的使用者
                        $chk = $Log->math('count', '*', ['news' => $row['id'], 'user' => $_SESSION['login']]);
                        // 如果chk>0的話表示你有按過讚
                        if($chk>0){
                           echo "<a class='g' data-news='{$row['id']}' data-type='1'>收回讚</a>";
                        }else{
                            echo "<a class='g' data-news='{$row['id']}' data-type='2'>讚</a>";

                        }
                    }

                    ?> 
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
    <div>
        <?php
        // 前符號
        if(($now-1)>0){
            $prev=$now-1;
            echo "<a href='index.php?do=news&p=$prev'>";
            echo " < ";
            echo "</a>";  
        }
        for ($i = 1; $i <= $pages; $i++) {
            // 放當前頁
            //如果$now==$i的話,我的字大小24p,不然的話16px
            $font = ($now == $i) ? '24px' : '16px';
            // echo我們的內容,先顯示我們的當前頁
            //我們的當前頁在index.php?do=news這個地方 和 我們p=$i
            echo "<a href='index.php?do=news&p=$i' style='font-size:$font'>";
            // 中間顯示我的頁碼$i
            echo $i;
            echo "</a>";
        }
        // 後符號,不能超過我的總頁數
        if(($now+1)<=$pages){
            $next=$now+1;
            echo "<a href='index.php?do=news&p=$next'>";
            echo " > ";
            echo "</a>";  
        }
        ?>
    </div>
</fieldset>
<script>
    $(".switch").on("click", function() {
        $(this).parent().find(".short,.full").toggle()
    })
    // 寫完這個後去建立一個div放分頁


    //當class=g的東西被按下的時候我要做...
    $(".g").on("click",function(){
        // 按下後我會拿到type
        //type在帶到switch case去跟去你按的動作看是要按讚還是收回讚
        let type=$(this).data('type')  
        let news=$(this).data('news')

        // 我要告訴後台(我要改變後台的狀態)
        // 誰被按讚,是誰按讚它,還要告訴它類別(是要按讚還是收回讚)
        // 請把type跟news這兩個數據送到後台去,完成之後執行switch case這個動作
        $.post("api/good.php",{type,news},()=>{
            // 拿到資料後要根據type對我的畫面上做一些事情
        //location.reload()
            switch(type){
                case 1:
                    $(this).text("讚");
                    $(this).data('type',2)
                break;
                case 2:
                    $(this).text("收回讚");
                    $(this).data('type',1)
                break;
            }
        })
    })
</script>