<?php
/*
 *  功能：根据应用状态动态呈现导航栏
 *  输入：链入外部样式表<link rel='stylesheet' type='text/css' href='/xk/css/xk.css'/>
 *        $name：登录管理员的姓名
 *        $choice：当前页面对应的菜单项序号，取1、2或3
 */
function navigation_admin($name, $choice=1) {    
    echo "<div class='nav'>";
    echo "<a class='right' href='exit.php'>退出</a>";
    echo "<span class='right'>".$name."，您好"."</span>";
    echo "<a class='left ".($choice===1 ? "current" : "")."' href='teacher_p.php'>浏览教师信息</a>";
    echo "<a class='left ".($choice===2 ? "current" : "")."' href='course_p.php'>添加课程</a>";
    echo "<a class='left ".($choice===3 ? "current" : "")."' href='opencourse_p.php'>维护开课信息</a>";    
    echo "<div style='clear: both'></div>";
    echo "</div>";
}
?>

<link rel='stylesheet' type='text/css' href='/xk/css/xk.css'/>
<?php
$user = "刘绍军";
navigation_admin($user, 2); 
?>