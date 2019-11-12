<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">        
        <title>录入成绩</title>
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
                $tn = $_SESSION["user"];
                $name = $_SESSION["name"];
                $choice = 3;
            }
            include("navigation_teacher.php");
        ?>
        
        <div style="width: 90%; min-height: 160px; margin: 5px auto 5px auto; border: solid 0px;">        
            <?php include("score_input.php"); ?>
        </div>

        <?php include("../footer.php"); ?>      
    </body>
</html>