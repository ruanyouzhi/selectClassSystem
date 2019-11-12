<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>选课</title>
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
            $sn = @$_SESSION['user'];
            $name = @$_SESSION['name'];
//            $name = "刘绍军";
            $choice = 2;
            include("navigation_student.php");
        ?> 
        
        <div style="width: 90%; min-height: 150px; margin: 0 auto; padding: 5px;">        
            <?php
                include("elective.php");
            ?>
        </div>

        <?php include("../footer.php"); ?>              
    </body>
</html>
