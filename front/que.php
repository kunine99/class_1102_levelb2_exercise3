  <!-- 題組二考題第13項目建置問卷調查 -->
  <fieldset>
    <legend>問卷調查</legend>
    <!-- table>tr*2>td*5 -->
    <table class="tab">
        <tr>
            <td width="10%">編號</td>
            <td width="50%">問卷題目</td>
            <td width="15%">投票總數</td>
            <td width="10%">結果</td>
            <td>狀態</td>
        </tr>
        <?php
        // 因為他後台沒有管理功能,只有要設定顯示還是隱藏
        //所以我們就全部all撈出來之後foreach
        //題目是parent為1的才要顯示
        //但全部all的話會連選項一起撈出來
        //所以要告訴他parent為0表示他是題目的名稱,然後這東西我們不要
        $ques=$Que->all(['parent'=>0]);
        foreach($ques as $key => $que){
        ?>
        <tr>
            <td><?=$key+1;?></td>
            <!-- 顯示$que的文字內容 -->
            <td><?=$que['text'];?></td>
            <!-- 顯示$que的投票總數 -->
            <td><?=$que['count'];?></td>
            <!-- 他是一個連結a標籤 -->
            <td>
                <!-- 結果要到結果頁,記得做一個result.php -->
            <a href="?do=result&id=<?=$que['id']?>">結果</a>
            </td>
            <td>
                <!-- 這邊要先看你有沒有登入,有登入會顯示 
            沒登入會叫你請先登入-->
            <?php
            if(isset($_SESSION['login'])){
                // 投票要到投票頁,記得做一個vote.php
                //如果你要參與投票的話,請到當前頁?do=vote
                //但因為他還要知道他是參與哪一提,所以我還要再告訴他
                //我參加的是哪一題id的題目
                echo "<a href='?do=vote&id={$que['id']}'>";
                echo "參與投票";
                echo "</a>";
            }else{
                echo "請先登入";
            }
            ?>
            </td>
        </tr>
        <?php
        }
        ?>
    </table>

</fieldset>