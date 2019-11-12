<!-- <link rel='stylesheet' type='text/css' href='/xk/css/xk.css'/> -->
<?php
    // 定义变量并设置为空值
    $snErr = $nameErr = $passwordErr = $password1Err = $birthdayErr = $emailErr = "";
    $sn = $name = $password = $password1 = $birthday = $email = "";
    $gender = "男";
    
    if ($_SERVER["REQUEST_METHOD"] === "POST" && array_key_exists("reg", $_POST)) {
        $flag = true;        
        if(array_key_exists("sn", $_POST)) $sn = trim($_POST["sn"]);
        if (empty($sn)) {
             $snErr = "用户名是必填的";
             $flag = false;
        } 
        if(array_key_exists("password", $_POST)) $password = trim($_POST["password"]);
        if (empty($password)) {
            $passwordErr = "密码是必填的";
            $flag = false;
        } 
        if(array_key_exists("password1", $_POST)) $password1 = trim($_POST["password1"]);
        if (empty($password1)) {
            $password1Err = "确认密码是必填的";
            $flag = false;			
        } else {
            if($password1!==$password) {
                $password1Err = "确认密码是错误的";
                $flag = false;				
            }			
        }
        if(array_key_exists("name", $_POST)) $name = trim($_POST["name"]);
        if (empty($name)) {
            $nameErr = "姓名是必填的";
            $flag = false;
        }		
        if(array_key_exists("gender", $_POST)) $gender= $_POST["gender"];
        if(array_key_exists("birthday", $_POST)) $birthday = trim($_POST["birthday"]);
        if (!empty($birthday)) {
            if(!preg_match('/^\d{4}[-](0?[1-9]|1[012])[-](0?[1-9]|[12][0-9]|3[01])$/', $birthday)) {
                $birthdayErr = "日期格式错误";
                $flag = false;
            }
        }
        if(array_key_exists("email", $_POST)) $email = trim($_POST["email"]);
        if (empty($email)) {
            $emailErr = "email地址是必填的";
            $flag = false;			
        } else {            
            if(!preg_match('/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+(\.[a-zA-Z0-9\-]+)+$/', $email)) {
                $emailErr = "email地址格式错误";
                $flag = false;
            }
        }

        if($flag) {
            include_once( 'lib/mysql.php');
            $mysqli = connect();
            if($mysqli->connect_errno) {
                echo "不能连接到数据库<br/>";
                exit();
            }
            $sql = "select * from student where sn = '$sn'";
            $result = executeSql($mysqli, $sql);
            if($result->num_rows===0) {
                $sql = "insert into student values('$sn', '$password', '$name', '$gender', '$birthday', '$email')";
                if(executeSql($mysqli, $sql)) {
                    $mysqli->close();
                    header("Location: index.php");
                    exit();
                } else {
                    echo "数据库操作失败";
                    $mysqli->close();
                    return;                    
                }		
            } else {
                $snErr = "用户名已经存在";
                $mysqli->close();                  
            }
        }
    }
?>

<form class="style1" method="POST">
<div class='outer'>
    <div class="title">请注册</div>
    <div class="inter">
        <p>
        <label for="i1" class="label">用户名<span style="color: orangered">*</span></label>
        <input type="text" id="i1" name="sn" maxlength="12" 
               style="width: 130px" value="<?php echo $sn; ?>" />
        <span class="errMsg"><?php echo $snErr; ?></span>            
        </p>
        <p>
        <label for="i21" class="label">密码<span style="color: orangered">*</span></label>
        <input type="password" id="i21" name="password" maxlength="12" 
               style="width: 130px" value="<?php echo $password; ?>" />
        <span class="errMsg"><?php echo $passwordErr; ?></span>            
        </p> 
        <p>
        <label for="i22" class="label">确认密码<span style="color: orangered">*</span></label>
        <input type="password" id="i22" name="password1" maxlength="12" 
               style="width: 130px" value="<?php echo $password1; ?>" />
        <span class="errMsg"><?php echo $password1Err; ?></span>            
        </p>
        <p>
        <label for="i3" class="label">姓名<span style="color: orangered">*</span></label>
        <input type="text" id="i3" name="name" maxlength="4" 
               style="width: 80px" value="<?php echo $name; ?>" />
        <span class="errMsg"><?php echo $nameErr; ?></span>            
        </p>
        <p>
        <label for="i4" class="label">性别</label>
        <input type="radio" name="gender" value="男" checked="checked" />男
        <input type="radio" name="gender" value="女" />女      
        </p>
        <p>
        <label for="i5" class="label">出生日期</label>
        <input type="text" name="birthday" maxlength="10" 
               style="width: 120px" value="<?php echo $birthday; ?>" />
        <span class="errMsg"><?php echo $birthdayErr; ?></span>
        </p>        
        <p>
        <label for="i6" class="label">Email<span style="color: orangered">*</span></label>
        <input type="text" id="i6" name="email" maxlength="28" 
               style="width: 300px" value="<?php echo $email; ?>" />
        <span class="errMsg"><?php echo $emailErr; ?></span>            
        </p>
        <p style="text-align: center; padding-top: 10px">
        <input type="submit" class="big" name="reg" value="立即注册"/>
        </p>        
    </div>
</div>
</form>