<div id="title" style="display: inline;">
   <?=date("m 月 y 號 ");?>| 
   今日瀏覽:  <?=$View->find(['date'=>date("Y-m-d")])['total'] ;?>| 
   累積瀏覽: <?=$View->math('sum','total');?></div>
   <a href="index.php" style="float: right;">回首頁</a>
<div id="title2">
    <a href="index.php" title="健康促進網-回首頁">
        <img src="./icon/02B01.jpg" alt="">
    </a>
</div>