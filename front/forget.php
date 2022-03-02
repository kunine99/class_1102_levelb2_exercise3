<fieldset>
    <legend>忘記密碼</legend>
    <div>請輸入信箱以查詢密碼</div>
    <div><input type="text" name="email" id="email"></div>
    <div id="result"></div>
    <div><button onclick="find()">尋找</button></div>
</fieldset>
<script>
    function find() {
        // 我上面email的值要傳到後台去
        //email就等於我現在畫面上有個id是eamil的欄位
        //把它傳過去之後我會去執行,然後回得到一個回應，這個回應就是我的結果
        $.post("api/find_pw.php",{email:$("#email").val()},(result)=>{
            $("#result").text(result)
        })
        //不管傳過來結果是如何都給我放在網頁上
        //我準備了一個result的地方給你放 (這時這時候去上面的空白div放一個id=result)
    }
</script>