<!-- <link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/> -->
<?php
    // $name = "胡文海"; $choice = 1;
?>
<div class='nav'>
    <a class='right' href='../index.php'>退出</a>
    <span class='right'><?php echo $name; ?>同学，你好！</span>
    <a class='left <?php echo $choice===1 ? "current":"" ?>' href='course_p.php'>浏览课程信息</a>
    <a class='left <?php echo $choice===2 ? "current":"" ?>' href='elective_p.php'>选课</a>
    <a class='left <?php echo $choice===3 ? "current":"" ?>' href='score_view_p.php'>查看成绩</a>
    <div style="clear: both"></div>
</div>
