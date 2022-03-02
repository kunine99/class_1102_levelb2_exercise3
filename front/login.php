<fieldset>
    <legend>會員登入</legend>
    <table>
        <tr>
            <td style="width: 40%;">帳號</td>
            <td><input type="text" name="acc" id="acc"></td>
        </tr>
        <tr>
            <td>密碼</td>
            <td><input type="text" name="pw" id="pw"></td>
        </tr>
        <tr>
            <td>
                <button onclick="login()">登入</button>
                <button onclick="reset()">清除</button>
            </td>
            <td>
                <a href="index.php?do=forget">忘記密碼</a>
                <a href="index.php?do=reg">尚未註冊</a>
            </td>
        </tr>
    </table>
</fieldset>
<script>
    function reset() {
        $("#acc,#pw").val("");
    }

    function login() {

        // 我要判斷帳號密碼正不正確我就要先把帳號密碼抓出來
        // 我的帳號acc等於: $("#acc")的val
        let user = {
            acc: $("#acc").val(),
            pw: $("#pw").val()
        }
        // 打完等於我現在有個物件是使用者的帳號密碼資料user


        // 接著要來判斷帳號存不存在
        // 帳號就仿照之前寫過的chk帳號,記得把form改成user
        $.post("api/chk_acc.php", {acc: user.acc}, (chk) => {
            // 去看chk.acc就會發現,我們先用post的方式拿到帳號的資料 
            // 然後用count的方式去檢查帳號存不存在
            // 如果帳號存在我們就回傳1,不存在我們就回傳0

            // 但這裡跟註冊不一樣的是,註冊是在看我們有沒有
            // 有的話傳1,沒有的話傳0(=帳號沒有重複,可以註冊)
            // 這邊登入的話是你要有這個帳號我們才要檢查密碼
            // 所以這邊要判斷的是如果chk==0表示這個帳號不存在我的資料庫
            if (parseInt(chk == 0)) {
                alert("查無帳號");
            } else {
                //接下來如果chk的結果不是0而是1的話表示有帳號
                //那我們就要來檢查密碼
                //這時候我就可以把整個user送2到後台去
                //一樣我會有一個新的chk
                // (注意雖然上面也有chk,但上面跟這裡的chk不會互相衝突,這是回呼函式的特性
                //回呼函式只會在自己的post區域有效,跟外面的東西是沒有關係的
                $.post("api/chk_pw.php",user,(chk)=>{
                    //像上面一樣,我們先讓錯誤訊息出現
                    if(parseInt(chk)==0){
                        alert("密碼錯誤")
                    }else{
                        //這邊要分成一般使用者和管理者
                        if(user.acc=='admin'){
                                location.href='back.php';
                                //寫到這邊可以去寫chk_pw了
                        }else{
                            location.href='index.php'
                        }
                    }




                })
            }




        })
    }
</script>