<link rel='stylesheet' type='text/css' href='/xk/css/xk.css'/>
<?php
    // 定义变量并设置为空值
    $userErr = $passwordErr = $lbErr = "";
    $user = $password = "";
    $lb = "同学";

    if($_SERVER["REQUEST_METHOD"] == "POST" && array_key_exists("log", $_POST)) {
        $flag = true;
        if(array_key_exists("user", $_POST)) $user = trim($_POST["user"]);
        if (empty($user)) {
            $userErr = "用户名是必填的";
            $flag = false;
        } 
        if(array_key_exists("password", $_POST)) $password = trim($_POST["password"]);
        if (empty($password)) {
            $passwordErr = "密码是必填的";
            $flag = false;
        }
        if(array_key_exists("lb", $_POST)) $lb = trim($_POST["lb"]);
        if (empty($password)) {
            $lbErr = "密码是必填的";
            $flag = false;
        }         
    
        if($flag) {
            include_once('lib/mysql.php');
            $mysqli = connect();
            if ($mysqli->connect_errno) {
                echo "不能连接到数据库<br/>";
                return;
            }
            if($lb==="老师") {
                $sql = "select * from teacher where tn = '$user'";
            } else {
                $sql = "select * from student where sn = '$user'";                
            }
            $result = executeSql($mysqli, $sql);
            if($result->num_rows===1) {
                $row = $result->fetch_array();
                if($lb==="老师") {
                    $pass = $row["tpassword"];
                } else {
                    $pass = $row["spassword"];                    
                }
                if($password===$pass) {
                    session_start();
                    $_SESSION["user"] = $user;
                    $_SESSION["lb"] = $lb;
                    if($lb==="老师") {
                        $_SESSION["name"] = $row["tname"];
                    } else {
                        $_SESSION["name"] = $row["sname"];                    
                    }                    
                    $mysqli->close();
                    header("Location: index.php");
                    exit();
                }
                $passwordErr = '密码错误';
            } else {
                $userErr = '用户名错误';
            }
            $mysqli->close();                  
        }
    }
?>
<form class='style1' method='POST'>
<div class='outer'>
    <div class="title">请登录</div>
    <div class="inter">
        <p>
        <label for="i1" class="label">用户名</label>
        <input type="text" id="i1" name="user" maxlength="12" 
               style="width: 130px" value="<?php echo $user; ?>" />
        <span class="errMsg"><?php echo $userErr; ?></span>            
        </p>
        <p>
        <label for="i2" class="label">密　码</label>
        <input type="password" id="i2" name="password" maxlength="12" 
               style="width: 130px" value="<?php echo $password; ?>" />
        <span class="errMsg"><?php echo $passwordErr; ?></span>            
        </p> 
        <p>
        <input type="radio" name="lb" value="同学" checked="checked" />学生
        <input type="radio" name="lb" value="老师" style="margin-left: 30px"/>教师      
        </p>
        <p style="text-align: center; padding-top: 10px">
        <input type="submit" class="big" name="log" value="确　认"/>
        </p>                
    </div>
</div>
</form>
