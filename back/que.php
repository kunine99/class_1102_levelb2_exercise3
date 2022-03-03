<!-- 
考題第17建置問卷後台管理 
-->
<fieldset>
    <legend>新增問卷</legend>
    <form action="api/que.php" method="post">
        <div style="display: flex;">
            <div class="clo">問卷名稱</div>
            <div>
                <input type="text" name="subject">
            </div>
        </div>
        <!-- 第2列直接用複製的 砍掉問卷div-->
        <!-- 為了定位這個div,所以給他個id(opt) -->
        <div class="clo" id="opt">
            <div>
            <!-- <span>選項</span>     -->
            <!-- 因為他會是多筆,所以加上陣列 -->
            <!-- 我要拿來做增加內容的東西 -->
            <input type="text" name="options[]">
            <input type="button" onclick="more()" value="更多">
            </div>
        </div>
        <div>
            <input type="submit" value="新增">|
            <input type="reset" value="清空">
        </div>
    </form>
</fieldset>
<script>
    function more(){
        let opt=`<div>
    <input type="text" name="options[]">
</div>`
        // 當我點擊opt時,就會增加let opt
        $("#opt").prepend(opt);
    }
    // 寫完後去增加opt.php
</script>