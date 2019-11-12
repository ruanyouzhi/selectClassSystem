<!--
*  功能：管理员向数据库添加所属部门的开课信息
*  输入：链入外部样式表<link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>
*        $dept：登录管理员的所属部门，如信息学院
-->
<?php
include_once '../lib/mysql.php';
/* 连接数据库 */
$mysqli = connect();
if ($mysqli->connect_errno) {
    echo "不能连接到数据库<br/>";
    exit();
}
$n = 3; // 设置一次最多可输入烦人开课数量
$title = "请输入...";           // 初始化提示信息
/* 处理表单数据，向数据库添加开课信息 */
if($_SERVER["REQUEST_METHOD"]==="POST" && array_key_exists("submit", $_POST)) {
    $count = 0;
    $term = $_POST["term"];
    for($i=0; $i<$n; $i++) {
        $cn = $_POST["cn$i"];
        $tn = $_POST["tn$i"];
        if($cn!=="" && $tn!=="") {      // 课程和教师都已指定
            $sql = "INSERT INTO opencourse(term, cn, tn) VALUES('$term', '$cn', '$tn')";
            if(executeSql($mysqli, $sql)) $count++;
        }
    }
    $title = "已添加{$count}条开课信息，请继续...";
}
/* 根据当前年份，构建表单中“学期”选择列表中各选项的HTML代码 */
$year = getdate()['year'];
$value1 = ($year-1)."-".$year."-2"; $label1 = ($year-1)."-".$year."学年 第2学期";
$value2 = $year."-".($year+1)."-1"; $label2 = $year."-".($year+1)."学年 第1学期";
$value3 = $year."-".($year+1)."-2"; $label3 = $year."-".($year+1)."学年 第2学期";
if(empty($term)) $term = $value2; 
$termoptions = "<option value='$value1'"
       .($term === $value1 ? " selected='selected'>" : ">")."$label1</option>\r\n";
$termoptions .= "<option value='$value2'"
       .($term === $value2 ? " selected='selected'>" : ">")."$label2</option>\r\n";
$termoptions .= "<option value='$value3'"
       .($term === $value3 ? " selected='selected'>" : ">")."$label3</option>\r\n";    
/* 根据当前管理员所属部门，构建表单中“课程”选择列表中各选项的HTML代码 */
$sql = "SELECT cn, cname FROM course c, teacher t "
     . "WHERE c.tn=t.tn and t.dept = '$dept' ORDER BY cn";    
$result = executeSql($mysqli, $sql);
$cnoptions = "<option value=''>请选择...</option>";
while($row = $result->fetch_array()) {
    $cnoptions .= "<option value='".$row['cn']."'>".$row['cname']."</option>\r\n"; 
}    
/* 根据当前管理员所属部门，构建表单中“任课教师”选择列表中各选项的HTML代码 */
$sql = "SELECT tn, tname FROM teacher WHERE dept = '$dept' ORDER BY tn";
$result = executeSql($mysqli, $sql);
$tnoptions = "<option value=''>请选择...</option>\r\n";
while($row = $result->fetch_array()) {
    $tnoptions .= "<option value='".$row['tn']."'>".$row['tname']."</option>\r\n"; 
}
$mysqli->close();
?>
<!-- 呈现开课信息录入表单 -->
<style type="text/css">
    table .c1 {width: 300px; text-align: left; padding-left: 10px}    
    table .c2 {width: 80px; text-align: left}
</style>
<div style="margin: 20px 0 30px 0">
    如果要查看开课信息、更改开课状态或删除开课信息，
    请单击<a href="opencourse_p.php?v=2">开课列表</a>
</div>
<form method="POST">
    <div class="title"><?php echo $title ?></div>
    <p>
    <label for="i1">选择学期：</label>
    <select id="i1" name="term"><?php echo $termoptions; ?></select>            
    </p>
    <table>
    <thead>
        <tr><td class="c1">课程</td><td class="c2">任课教师</td></tr>
    </thead>
    <tbody>
        <?php for($i=0; $i<$n; $i++) { ?>
        <tr>
        <td><select name='<?php echo "cn$i" ?>'><?php echo $cnoptions ?></select></td>
        <td><select name='<?php echo "tn$i" ?>'><?php echo $tnoptions ?></select></td>
        </tr>
        <?php } ?>
    </tbody>
    </table>
    <p style="margin-top: 20px">
        <input type="submit" class="big" name="submit" value="确 认"/>
    </p>
</form>
