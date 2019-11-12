<!--
*  功能：呈现登录表单、 处理登录。登录成功时，将重定向至“浏览教师信息”页面
*  输入：链入外部样式表<link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>
-->
<?php
include_once '../lib/mysql.php';
session_start();            // 开始会话
// 定义变量并设置为空值
$userErr = $pwErr = "";
$user = $pw = "";
/* 处理登入 */
if($_SERVER["REQUEST_METHOD"] == "POST" && array_key_exists("submit", $_POST)) {
    $flag = true;
    if(array_key_exists("user", $_POST)) $user = trim($_POST["user"]);
    if (empty($user)) {
        $userErr = "用户名是必填项";
        $flag = false;
    } 
    if(array_key_exists("pw", $_POST)) $pw = trim($_POST["pw"]);
    if (empty($pw)) {
        $pwErr = "密码是必填项";
        $flag = false;
    }
    if($flag) {
        $mysqli = connect();
        if ($mysqli->connect_errno) {
            echo "不能连接到数据库<br/>";
            echo $mysqli->connect_error;
            exit();
        }
        $sql = "select * from teacher where tn = '$user' and admin = '是'";
        $result = executeSql($mysqli, $sql);
        if($result->num_rows === 1) {
            $row = $result->fetch_array();
            $pass = $row["tpassword"];
            if($pw === $pass) {
                $_SESSION["user"] = $user;
                $_SESSION["name"] = $row["tname"];
                $_SESSION['dept'] = $row['dept'];
                $_SESSION["lb"] = '管理员';
                $mysqli->close();
                header("Location: teacher_p.php");
                exit();
            }
            $pwErr = '密码错误';
        } else {
            $userErr = '用户名错误，或不是管理员';
        }
        $mysqli->close();                  
    }
}
?>
<!-- 呈现表单 -->
<form class="style1" method="POST">
<div class="outer">
    <div class="title">管理员登录</div>  
    <div class="inter">
        <p>
        <label for="i1" class="label">用户名</label>
        <input type="text" id="i1" name="user" maxlength="4" 
               style="width: 60px" value="<?php echo $user ?>" />
        <span class="errMsg"><?php echo $userErr ?></span>            
        </p>
        <p>
        <label for="i2" class="label">密　码</label>
        <input type="password" id="i2" name="pw" maxlength="12" 
               style="width: 130px" value="<?php echo $pw ?>" />
        <span class="errMsg"><?php echo $pwErr ?></span>            
        </p>
        <p style="text-align: center; padding-top: 10px">
        <input type="submit" class="big" name="submit" value="确　认"/>
        </p>
    </div>
</div>            
</form>
