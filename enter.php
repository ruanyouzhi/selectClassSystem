<?php
    session_start();
    if($_SESSION["lb"]==="老师") {
        header("Location: teacher/course_teacher_p.php");
    } else{
        header("Location: student/score_view_p.php");        
    }
    exit();

?>