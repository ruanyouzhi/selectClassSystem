<!-- <link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/> -->
<?php
//    $isLogon = false; 
//    $choice = 1; $lb = "同学"; $name = "胡文海";
?>

<div class='nav'>
    <?php if($isLogon) { ?>
        <a class='right' href='logoff.php'>退出登录</a>
        <a class='right' href='enter.php'>进入系统</a>        
        <span class='right'><?php echo $name,$lb ?>，你好！</span>
    <?php } else { ?>
        <a class='right <?php echo $choice===2 ? "current" : ""?>' href='registration_p.php'>注册</a>
        <a class='right <?php echo $choice===1 ? "current" : ""?>' href='login_p.php'>登录</a>
    <?php } ?>
    <div style='clear: both'></div>
</div>
