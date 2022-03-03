<fieldset>
    <!-- 為了簡化作業,前後加form -->
    <form action="api/del_user.php" method="post">
    <legend>帳號管理</legend>
    <!-- table>tr*2>td*3 -->
    <table class="ct" style="width:75%;margin:auto;">
        <tr class="clo">
            <td>帳號</td>
            <td>密碼</td>
            <td style="width: 10%;">刪除</td>
        </tr>
        <!-- 這邊放php -->
        <?php
        // 全部撈出來
        $users=$User->all();
        foreach ($users as $key => $user) {
        ?>
        <tr>
            <!-- 一起打欄位 -->
            <td><?=$user['acc'];?></td>
            <!-- str_repeat 第2個參數接個數 -->
            <td><?=str_repeat("*",mb_strlen($user['pw']));?></td>
            <td><input type="checkbox" name="del[]" value="<?=$user['id'];?>"></td>
        </tr>
        <!-- 這邊放php -->

        <?php
}
        ?>
    </table>
    <!-- input:submit+input:reset -->
    <div class="ct">
    <input type="submit" value="確定刪除">
    <input type="reset" value="清空選取">
    </div>
    </form>
</fieldset>