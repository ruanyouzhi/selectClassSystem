<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>浏览教师信息</title>
        <link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>
    </head>
    <body>
        <?php
            session_start();
            $lb = @$_SESSION['lb'];
            if(empty($lb) || $lb !== '管理员') {
                header("Location: index_admin.php");
                exit();                
            }
        ?>         
        <?php include("header_admin.php"); ?>
        
        <?php
            $name = @$_SESSION['name'];
//            $name = "刘绍军";
            $choice = 1;
            include("navigation_admin.php");
        ?> 
        
        <div style="width: 90%; min-height: 150px; margin: 0 auto; padding: 5px;">        
            <?php
                include("teacher_list.php");
            ?>
        </div>

        <?php include("footer_admin.php"); ?>      
    </body>
</html>
