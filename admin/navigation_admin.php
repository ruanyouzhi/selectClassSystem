<!--
*  功能：根据应用状态动态呈现导航栏
*  输入：链入外部样式表<link rel='stylesheet' type='text/css' href='/xk/css/xk.css'/>
*        $name：登录管理员的姓名
*        $choice：当前页面对应的菜单项序号，取1、2或3
-->
<!-- <link rel='stylesheet' type='text/css' href='/xk/css/xk.css'/> -->
<?php
// $name = "刘绍军";
// $choice = 1;
?>
<div class='nav'>
    <a class='right' href='exit.php'>退出</a>
    <span class='right'><?php echo $name."，您好" ?></span>
    <a class='left <?php echo $choice===1 ? "current" : ""?>' href='teacher_p.php'>浏览教师信息</a>
    <a class='left <?php echo $choice===2 ? "current" : ""?>' href='course_p.php'>添加课程</a>
    <a class='left <?php echo $choice===3 ? "current" : ""?>' href='opencourse_p.php'>维护开课信息</a>    
    <div style='clear: both'></div>
</div>
