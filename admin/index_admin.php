<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>首页</title>
        <link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>
    </head>
    <body>
        <?php include("header_admin.php"); ?>

        <div style="width: 90%; min-height: 150px; margin: 0 auto; padding: 5px;">        
            <?php
            // echo "管理员登录表单";
             include("login_admin.php");
            ?>
        </div>

        <?php include("footer_admin.php"); ?>      
    </body>
</html>
