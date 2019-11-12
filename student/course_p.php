<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>浏览课程信息</title>
        <link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>
    </head>
    <body>
        <?php
            session_start();
            $lb = @$_SESSION['lb'];
            if(empty($lb) || $lb !== '同学') {
                header("Location: /xk/index.php");
                exit();                
            }
        ?>         
        <?php include("../header.php"); ?>
        
        <?php
            $name = @$_SESSION['name'];
//            $name = "刘绍军";
            $choice = 1;
            include("navigation_student.php");
        ?> 
        
        <div style="width: 90%; min-height: 150px; margin: 0 auto; padding: 5px;">        
            <?php
            if(array_key_exists("cn", $_GET)) {
                include("course_detail.php");                
            } else {
                include("course_list.php");
            }
            ?>
        </div>

        <?php include("../footer.php"); ?>      
    </body>
</html>
