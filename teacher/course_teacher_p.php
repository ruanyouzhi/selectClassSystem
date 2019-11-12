<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>课程列表</title>
        <link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>
    </head>
    <body>
        <?php include("../header.php"); ?>

        <?php
            session_start();
            $lb = @$_SESSION['lb'];
            if(empty($lb) || $lb !== '老师') {
                header("Location: /xk/index.php");
                exit();
            } else {
                $name = $_SESSION["name"];
                $choice = 1;
                $tn = $_SESSION["user"];
            }
            //$tn = "1019";
            //$name = "吴蕊";
            //$choice = 1;
            include("navigation_teacher.php");
        ?>
        
        <div style="width: 90%; min-height: 160px; margin: 5px auto 5px auto; border: solid 0px; padding-top: 15px">        
            <?php include("course_teacher.php"); ?>
        </div>

        <?php include("../footer.php"); ?>      
    </body>
</html>