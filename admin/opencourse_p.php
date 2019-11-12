<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>维护开课信息</title>
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
            $user = @$_SESSION['user'];
            $name = @$_SESSION['name'];
            $dept = @$_SESSION['dept'];
        ?>
        <?php include("header_admin.php"); ?>
        <?php
            $choice = 3;
            include("navigation_admin.php");
        ?>
        <div style="width: 90%; min-height: 150px; margin: 0 auto; padding: 5px;">
            <?php
                $v = @$_GET['v'];
                if(empty($v)) $v = "1";
                if($v === "1") {
                    include("opencourse_input.php");
                } else {
                    include("opencourse_list.php");
                }
            ?>
        </div>
        <?php include("footer_admin.php"); ?>
    </body>
</html>
