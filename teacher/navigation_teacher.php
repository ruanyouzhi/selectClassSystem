<!-- <link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/> -->
<?php
    // $name = "吴蕊"; $choice = 1;
?>
	
<div class='nav'>
    <a class='right' href='../index.php'>退出</a>
    <span class='right'><?php echo $name; ?>老师，你好！</span>

    <a class='left <?php echo $choice===1 ? "current":"" ?>' href='course_teacher_p.php'>课程列表</a>
    <a class='left <?php echo $choice===2 ? "current":"" ?>' href='course_edit_p.php'>编辑课程信息</a>
    <a class='left <?php echo $choice===3 ? "current":"" ?>' href='score_input_p.php'>录入成绩</a>
    <div style="clear: both"></div>
</div>
