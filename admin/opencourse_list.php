<!--
*  功能：呈现登录管理员所属部门的开课信息列表，并包含删除开课信息和更改开课状态的功能
*  输入：链入外部样式表<link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>
*        $dept：登录管理员的所属部门，如"信息学院"
*  其他：代码需要在会话状态下运行
-->
<?php
include_once '../lib/mysql.php';
@ session_start();
/* 连接数据库 */
$mysqli = connect();
if ($mysqli->connect_errno) {
    echo "不能连接到数据库<br/>";
    exit();
}
/* 处理各个POST请求 */
if ($_SERVER["REQUEST_METHOD"]==="POST") {
    if(array_key_exists("submit1", $_POST)) {       // 处理提交的学期
        $term = $_POST['term']; $_SESSION['term'] = $term;
        $_SESSION['ocs'] = getOpenCourseData($mysqli, $dept, $term);
    } elseif(array_key_exists("lid", $_POST)) {     // 处理“删除”请求
        $lid = $_POST['lid'];
        $mysqli->begin_transaction();
        $sql = "DELETE FROM elective WHERE lid='$lid'";
        executeSql($mysqli, $sql);
        $sql = "DELETE FROM opencourse WHERE lid='$lid'";
        executeSql($mysqli, $sql);
        $mysqli->commit();
        $term = $_SESSION['term'];
        $_SESSION['ocs'] = getOpenCourseData($mysqli, $dept, $term);          
    } elseif(array_key_exists("cs", $_POST)) {      // 处理状态更改请求
        $term = $_SESSION['term'];
        $sql = "UPDATE opencourse SET status='2' WHERE term='$term' AND status='1' AND "
                . "tn IN (SELECT tn FROM teacher WHERE dept='$dept')";
        executeSql($mysqli, $sql);
        $_SESSION['ocs'] = getOpenCourseData($mysqli, $dept, $term);         
    }
}
/* 处理GET请求：当从其他页面或视图回到该视图时 */
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(array_key_exists("term", $_SESSION)) {
        $term = $_SESSION['term'];
        $_SESSION['ocs'] = getOpenCourseData($mysqli, $dept, $term);
    }
}
$mysqli->close();
// 根据当前年份，构建表单中“学期”选择列表中各选项的HTML代码
$year = getdate()['year'];
$value1 = ($year-1)."-".$year."-2"; $label1 = ($year-1)."-".$year."学年 第2学期";
$value2 = $year."-".($year+1)."-1"; $label2 = $year."-".($year+1)."学年 第1学期";
$value3 = $year."-".($year+1)."-2"; $label3 = $year."-".($year+1)."学年 第2学期";
@$term = $_SESSION['term'];
if(empty($term)) $term = $value2; 
$termoptions = "<option value='$value1'"
       .($term === $value1 ? " selected='selected'>" : ">")."$label1</option>\r\n";
$termoptions .= "<option value='$value2'"
       .($term === $value2 ? " selected='selected'>" : ">")."$label2</option>\r\n";
$termoptions .= "<option value='$value3'"
       .($term === $value3 ? " selected='selected'>" : ">")."$label3</option>\r\n";    
?>
<!-- 呈现所属部门在指定学期的开课信息列表 -->
<div style="margin: 20px 0 30px 0">
    如果需要添加开课信息，请单击<a href="opencourse_p.php?v=1">添加开课信息</a>
</div>
<form method="POST">
    <p>
    <label for="i1">选择学期：</label>
    <select id="i1" name="term"><?php echo $termoptions; ?></select>
    <input type="submit" name="submit1" value="确 认" />
    </p>        
</form>
<?php
if(array_key_exists('ocs', $_SESSION)) {    // 呈现开课信息列表
?>
<style type="text/css">
    table .c1 {width: 300px; padding-left: 10px}
    table .c2 {width: 100px}
    table .c3 {width: 60px}
    table .c4 {width: 80px}
    table .c5 {width: 60px}
</style>
<form action="" method="POST" style="margin-top: 0px">
    <table>
    <thead>
        <tr>
        <td class="c1">课程</td><td class="c2">任课教师</td>
        <td class="c3">状态</td><td class="c4">选课人数</td><td class="c5"></td>
        </tr>
    </thead>
    <tbody>
        <?php
        $cnt1 = $cnt2 = $cnt3 = 0;
        for($i=0; $i<count($_SESSION['ocs']); $i++) {  // 处理各开课信息
            $sstatus = ""; $del = "";
            $status = $_SESSION['ocs'][$i][3];
            if($status==='1') { $sstatus = '选课'; $cnt1++; }
            elseif($status==='2') { $sstatus = '教学'; $cnt2++; }
            else{ $sstatus = '结课'; $cnt3++; }
            // 为状态为1或2的开课信息，在其右端设置一个删除按钮
            if($status==='1' || $status==='2') {
                $url = $_SERVER['SCRIPT_NAME']."?v=2";
                $lid = $_SESSION['ocs'][$i][0];
                $del = "<form action='$url' method='POST' style='margin: 0'>"
                        . "<input type='hidden' name='lid' value='$lid' />"
                        . "<input type='submit' class='text' value='删除' /></form>";
            }
            ?>
            <tr>
                <td class="c1"><?php echo $_SESSION['ocs'][$i][1] ?></td>
                <td class="c2"><?php echo $_SESSION['ocs'][$i][2] ?></td>
                <td class="c3"><?php echo $sstatus ?></td>
                <td class="c4"><?php echo $_SESSION['ocs'][$i][4] ?></td>
                <td class="c5"><?php echo $del ?></td>                    
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr style="height: 10px"><td colspan="4"></td></tr>
    </tfoot>        
    </table>
</form>
<div>
[选课]状态：<?php echo $cnt1 ?>门课，[教学]状态：<?php echo $cnt2 ?>门课，
[结课]状态：<?php echo $cnt3 ?>门课。
</div>
<?php
if($cnt1>0) {       // 当有“选课”状态的开课信息时处理
    $url = $_SERVER['SCRIPT_NAME']."?v=2";
    $cs = "<form action='$url' method='POST' style='display: inline-block'> "
        . "<input type='hidden' name='cs' value='y'/>"
        . "<input type='submit' class='text' value='[选课]=>[教学]' /></form>";
    echo "<span>";
    echo "如果需要将其中处于[选课]状态的课程转成[教学]状态，";
    echo "请单击</span>".$cs;
}
}       // 开课信息列表呈现结束
?>