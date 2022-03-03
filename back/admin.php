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







    <!-- 這邊開始複製自reg.php -->
    <!-- 首先legend改成h1 ,然後刪除fieldset
    然後注意註冊完成後不要跳頁,所以要改成重整
    -->
    <h1>新增會員</h1>
    <div style="color:red">*請設定您要註冊的帳號及密碼(最長12個字元)</div>
    <!-- tr*5>td*2 -->
    <table>
        <tr>
            <td>Step1:登入帳號</td>
            <td><input type="text" name="acc" id="acc"></td>
        </tr>
        <tr>
            <td>Step2:登入密碼</td>
            <td><input type="password" name="pw" id="pw"></td>
        </tr>
        <tr>
            <td>Step3:再次確認密碼</td>
            <td><input type="password" name="pw2" id="pw2"></td>
        </tr>
        <tr>
            <td>Step4:信箱(忘記密碼時使用)</td>
            <td><input type="text" name="email" id="email"></td>
        </tr>
        <tr>
            <td>
                <button onclick="reg()">註冊</button>
                <button onclick="reset()">清除</button>
            </td>
            <td></td>
        </tr>
    </table>
</fieldset>

<script>
    function reset() {
        //空白代表空值(清除)
        $("#acc,#pw,#pw2,#email").val("");
        // $("acc").val("");
        // $("pw").val("");
        // $("pw2").val("");
        // $("email").val("");
    }

    function reg() {
        // 用物件的方式模擬陣列的效果
        // 宣告這個form是一個物件的格式(兩個大誇號包住物件是物件的寫法)
        let form = {
            // 你有一個acc的欄位，你這個acc是來自畫面上的這個欄位的value
            // 物件裡面的值跟值用之間用,分開
            acc: $("#acc").val(),
            pw: $("#pw").val(),
            pw2: $("#pw2").val(),
            email: $("#email").val()
        }


        // if(Object.values(form).indexOf('')>=0){
        if (form.acc == '' || form.pw == '' || form.pw2 == '' || form.email == '') {
            alert("不可空白")
        } else {
            if (form.pw != form.pw2) {
                alert("密碼錯誤")
            } else {
                // 我要把表單的內容送出去到資料庫
                //post api在php裡面 送出去一堆給他，最後會有結束的動作
                // $.post("api/chk_acc.php", {},()=> { })

                // 我要確認帳號acc,然後他的資料來自於form裡面的acc
                $.post("api/chk_acc.php", {acc: form.acc}, (chk) => {
                    // 我預期他會回給我true or false代表(1存在或是0不存在)
                    if (parseInt(chk) == 1) {
                        alert('帳號重複')
                    } else {
                        // 因為資料庫沒有pw2這個欄位，所以在這邊把它刪除
                        delete form.pw2

                        // 我的form=是大誇號裡面的東西，所以直接把form丟進去
                        //()裡面可以放chk或是res去判斷這次的新增有沒有成功
                        $.post("api/reg.php", form, (res) => {
                            // console.log(res);
                            location.reload();
                        })
                    }
                })
            }
        }


    }
</script>
</fieldset>