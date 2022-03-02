// JavaScript Document
function lo(th,url)
{
	$.ajax(url,{cache:false,success: function(x){$(th).html(x)}})
}

function logout(){
  // 只要你啟用這個logout,我就會跟後台說有個程式叫logout.php
  // 不管妳現在登入的角色是誰,反正只要你按登出,
  //我就是把那個$_SESSION['login']刪掉,所以我不用帶任何參數給它
  //只要告訴後台去給我執行logout這件事情就好
	$.post("api/logout.php",()=>{
  //執行完之後(session移除了)
  //我們要告訴前台去做點什麼事情更新session的狀態,才發現你登出了
  //所以我們設定不管你在前台還是後台，都回到首頁去重載base檔
  location.href='index.php'
  //記得寫完後回到index去載入這個function
	})

}

function good(id,type,user)
{
	$.post("back.php?do=good&type="+type,{"id":id,"user":user},function()
	{
		if(type=="1")
		{
			$("#vie"+id).text($("#vie"+id).text()*1+1)
			$("#good"+id).text("收回讚").attr("onclick","good('"+id+"','2','"+user+"')")
		}
		else
		{
			$("#vie"+id).text($("#vie"+id).text()*1-1)
			$("#good"+id).text("讚").attr("onclick","good('"+id+"','1','"+user+"')")
		}
	})
}