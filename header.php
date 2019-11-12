<!-- 
*  功能：呈现学生-教师子系统的页面头
*  输入：无
-->
<?php
    date_default_timezone_set('PRC');	
    $time = time();
    function getWeek($time) {
        $week = array('星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六');
        return $week[date('w', $time)];
    }	
?>
<style type='text/css'>
    .sh { width: 90%; background-color: #eeeeee; margin: 0 auto}
    .sh img {float: left; margin: 2px 20px 2px 2px; border-style: none;}
    .sh span {float: left; font-size: 28px; font-weight: 700;margin-top: 20px}
    .sh .time {float: right; margin-right: 5px; color: teal; text-align: right; font-size: 13px}
</style>
<div class="sh">
    <div class="time">
        <p style="margin-top: 2px; margin-bottom: 0px;line-height: 23px"><?php echo date('Y年m月d日', $time)?></p>
        <p style="margin-top: 0px; margin-bottom: 0px;line-height: 23px"><?php echo getWeek($time)?></p>
        <p style="margin-top: 0px; margin-bottom: 2px;line-height: 23px"><?php echo (date('a')==='am'?'上午 ':'下午 ').date('h:i:s')?></p>            
    </div>
    <a href="index.php"><img src="/xk/image/logo.png" /></a>
    <span style="margin-left: 10px; font-family: 楷体">欢迎使用</span>
    <span style="margin-left: 5px">教学选课系统！</span>
    <div style="clear: both"></div>    
</div>