<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title登录</title>
        <link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>
    </head>
    <body>
        <?php include("header.php"); ?>
        
        <?php
            $isLogon = false;
            $choice = 1;
            include("navigation.php");
        ?>
        
        <div style="width: 90%; min-height: 200px; margin: 5px auto 5px auto; border: solid 0px;">        
            <?php include("login.php"); ?>
        </div>

        <?php include("footer.php"); ?>              
    </body>
</html>
