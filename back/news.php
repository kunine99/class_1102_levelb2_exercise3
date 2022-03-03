<!-- 
考題第16建置最新文章後台管理 
要列表,顯示,刪除,分頁功能
可以複製news.php fieldset全部複製來
// 1.在前台是選顯示地在秀出來,但在後台我全都要看,所以把sh拿掉
// 2.td留標題+標號跟checkbox
// 3.分頁是置中+ct
// 4.+確定修改input:submit
// 5.table+剛剛的submit全部選起來,ctrl+shift+p ,emmmet使用縮寫換行
// 6.form[action='api/news_admin.php' method='post']
// 7.分頁把index改成back
// 8.顯示那邊要+判斷式,加完後記得放在checkbox那邊
// 9.去寫news_admin 的api
// 10.塞一個隱藏欄位
// 11.改3頁
-->
<fieldset>
    <legend>最新文章管理</legend>
    <!-- table>tr*2>td*3 -->
    <form action="api/news_admin.php" method="post">
        <table>
            <tr>
                <td width="10%">標號</td>
                <td width="75%">標題</td>
                <td width="10%">顯示</td>
                <td width="10%">刪除</td>
            </tr>
            <?php
            // 先算出總共有幾篇文章
            $total = $News->math("count", "*");
            // 接下來告訴他五筆換一頁
            $div = 3;
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
            // 在前台是選顯示地在秀出來,但在後台我全都要看要管理,所以把sh拿掉
            $rows = $News->all(" limit $start,$div");
            // 抓到資料後把它顯示出來
            foreach ($rows as $key => $row) {
                // 如果$row的'sh'==1的話給我一個字串叫做checked不然的話給我空字串
                //我把字串給了這個變數,然後把這個變數家在後面讓她可以做判斷
                $chk=($row['sh']==1)?"checked":"";
            ?>
                <tr>
                    <!-- 第一個要顯示標號
                    從start這個變數開始算,可是上面的start是撈資料的筆數,
                    所以從0開始算,這邊是要顯示用得所以要從1開始算,所以要+1
                    還要把$key的變化值加上去-->
                    <td><?= $start+1+$key; ?></td>
                    <!-- 第二個要顯示標題 -->
                    <td><?= $row['title']; ?></td>
                    <td>
                       <!-- 這邊是checkbox 因為多筆所以name用陣列
                        然後value要顯示的是這筆資料-->
                       <input type="checkbox" name="sh[]" value="<?= $row['id']; ?>" <?=$chk;?>>
                    </td>
                    <td>
                       <!-- 這邊是checkbox 因為多筆所以name用陣列
                        然後value要顯示的是這筆資料-->
                       <input type="checkbox" name="del[]" value="<?= $row['id']; ?>">
                       <input type="hidden" name="id[]" value="<?= $row['id']; ?>">
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
        <div class="ct">
            <?php
            // 前符號
            if(($now-1)>0){
                $prev=$now-1;
                echo "<a href='back.php?do=news&p=$prev'>";
                echo " < ";
                echo "</a>";
            }
            for ($i = 1; $i <= $pages; $i++) {
                // 放當前頁
                //如果$now==$i的話,我的字大小24p,不然的話16px
                $font = ($now == $i) ? '24px' : '16px';
                // echo我們的內容,先顯示我們的當前頁
                //我們的當前頁在back.php?do=news這個地方 和 我們p=$i
                echo "<a href='back.php?do=news&p=$i' style='font-size:$font'>";
                // 中間顯示我的頁碼$i
                echo $i;
                echo "</a>";
            }
            // 後符號,不能超過我的總頁數
            if(($now+1)<=$pages){
                $next=$now+1;
                echo "<a href='back.php?do=news&p=$next'>";
                echo " > ";
                echo "</a>";
            }
            ?>
        </div>
        <div class="ct"><input type="submit" value="確定修改"></div>
    </form>
</fieldset>