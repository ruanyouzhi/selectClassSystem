<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">        
        <link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>               
    </head>
    <body>
        <?php include("header.php"); ?>

        <?php
            session_start();
            if(array_key_exists("user", $_SESSION)) {
                $isLogon = true;
                $name = $_SESSION["name"];
                $lb = $_SESSION["lb"];
            } else {
                $isLogon = false;
                $choice = 0;
            }        
            include("navigation.php");
        ?>
        
        <div style="width: 90%; min-height: 200px; margin: 5px auto 5px auto; border: solid 0px;">        
            <p style="margin: 20px 0 20px 20px; font-size: 20px">欢迎使用教学选课系统！</p>
            <p style="margin: 20px 0 20px 20px; font-size: 14px">系统用户分两类：一是学生，二是教师。</p>
            <p style="margin: 20px 0 20px 20px; font-size: 14px">学生用户的功能包括：浏览课程信息、选课、查看成绩。</p>            
            <p style="margin: 20px 0 20px 20px; font-size: 14px">教师用户的功能包括：课程列表、编辑课程信息、录入成绩。</p>
        </div>

        <?php include("footer.php"); ?>      
    </body>
</html>