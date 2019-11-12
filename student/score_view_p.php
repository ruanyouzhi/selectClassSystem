<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">        
        <title>查看成绩</title>
        <link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>
    </head>
    <body>
        <?php include("../header.php"); ?>

        <?php
            session_start();
            $lb = @$_SESSION['lb'];
            if(empty($lb) || $lb !== '同学') {
                header("Location: /xk/index.php");
                exit();
            } else {
                $name = $_SESSION["name"];
                $choice = 3;
                $sn = $_SESSION["user"];
            }
            //$sn = "201209031001";
            //$name = "胡文海";
            //$choice = 3;
            include("navigation_student.php");
        ?>

        <div style="width: 90%; min-height: 150px; margin: 5px auto 5px auto; border: solid 0px;">        
            <?php include("score_view.php") ?>
        </div>

        <?php include("../footer.php"); ?>      
    </body>
</html>