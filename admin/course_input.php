<!--
*  功能：管理员向数据库添加所属部门的新课程（不包括课程描述和大纲）
*  输入：链入外部样式表<link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>
*        $dept：登录管理员的所属部门，如信息学院
-->
<!-- <link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/> -->
<?php
    //$dept = "信息学院";
?>

<?php
include_once '../lib/mysql.php';
/* 连接数据库 */
$mysqli = connect();
if ($mysqli->connect_errno) {
    echo "不能连接到数据库<br/>";
    exit();
}
/* 初始化变量,这些变量将作为表单控件元素的值，或者是错误信息和提示信息 */
$cn = $cname = $credit = $tn = "";
$cnErr = $cnameErr = $creditErr = "";
$title = "请输入...";
/* 处理表单数据 */
if($_SERVER["REQUEST_METHOD"]==="POST" && array_key_exists("submit", $_POST)) {
    $flag = true;
    if(array_key_exists("cn", $_POST)) $cn = trim($_POST["cn"]);
    if (empty($cn)) {
        $cnErr = "课程号是必填项";
        $flag = false;
    } 
    if(array_key_exists("cname", $_POST)) $cname = trim($_POST["cname"]);
    if (empty($cname)) {
        $cnameErr = "课程名是必填项";
        $flag = false;
    }
    if(array_key_exists("credit", $_POST)) $credit = trim($_POST["credit"]);
    if (empty($credit)) {
        $creditErr = "学分是必填项";
        $flag = false;
    } else {
        $pattern = '/^\d$/';
        if(preg_match($pattern, $credit) != 1) {
            $creditErr = "学分值只能取1-9";
            $flag = false;
        }
    }
    $tn = trim($_POST["tn"]);
    if($flag) {
        $sql = "select * from course where cn = '$cn'";
        $result = executeSql($mysqli, $sql);
        if($result->num_rows === 1) {
            $cnErr = "课程号已存在";
            $flag = false;
        }
    }
    if($flag) {       // 数据有效，向数据库添加课程信息
        $sql = "insert into course(cn, cname, credit, tn) "
                . "values('$cn', '$cname', $credit, '$tn')";
        $result = executeSql($mysqli, $sql);            
        $title = "已成功添加课程，请继续...";
        $cn = $cname = $credit = $tn = "";  // 初始化表单控件值
    } else {
        $title = "数据有错，请修改...";
    }
}
?>
<?php
// 根据当前管理员所属部门，构建表单中“负责教师”选择列表中各选项的HTML代码
$sql = "SELECT tn, tname FROM teacher WHERE dept = '$dept'";
$result = executeSql($mysqli, $sql);
$options = "";
while($row = $result->fetch_array()) {
    $options .= "<option value='".$row['tn']."'";
    $options .= $tn===$row['tn']?" selected='selected'>" : ">";
    $options .= $row['tname']."</option>\r\n"; 
}
$mysqli->close();
?>
<!-- 呈现课程信息录入表单 -->
<div style="margin: 20px 0 30px 0">
    如果要查看课程信息，请单击<a href="course_p.php?v=2">课程列表</a>
</div>
<div class="title" style="margin-bottom: 20px"><?php echo $title ?></div>           
<form method="POST">
    <p>
        <label for="i1" class="label">课程号</label>
        <input type="text" id="i1" name="cn" maxlength="10" 
               style="width: 100px" value="<?php echo $cn ?>" />
        <span class="errMsg"><?php echo $cnErr ?></span>            
    </p>
    <p>
        <label for="i2" class="label">课程名</label>
        <input type="text" id="i2" name="cname" maxlength="20" 
               style="width: 300px" value="<?php echo $cname ?>" />
        <span class="errMsg"><?php echo $cnameErr ?></span>            
    </p>
    <p>
        <label for="i3" class="label">学分</label>
        <input type="text" id="i3" name="credit" maxlength="1" 
               style="width: 30px" value="<?php echo $credit ?>" />
        <span class="errMsg"><?php echo $creditErr ?></span>            
    </p>
    <p>
        <label for="i4" class="label">负责教师</label>
        <select id="i4" name="tn"><?php echo $options; ?></select>
    </p>
    <p style="padding-top: 10px">
        <input type="submit" class="big" name="submit" value="确 认"/>
    </p>
</form>
