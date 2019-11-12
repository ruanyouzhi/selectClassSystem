<link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>
<style type="text/css">
    .area {display: inline-block; width: 500px; letter-spacing: 1.2px; line-height: 1.5; white-space: pre-wrap}
</style>
<?php
    include_once('../lib/mysql.php');
    $mysqli = connect();
    if ($mysqli->connect_errno) {
        echo "<p>不能连接到数据库！</p>";
        return;
    }
    $p = $_GET['p'];
    if($_SERVER["REQUEST_METHOD"]==="GET" && array_key_exists("cn", $_GET)) {
        $cn = $_GET['cn'];
        $query = "SELECT * FROM course WHERE cn='$cn'";
        $result = executeSql($mysqli, $query);
        if($result->num_rows===0) {
            echo "<p>不存在查询的课程！</p>";
            $mysqli->close();
            return;        
        }
        $row = $result->fetch_array();
        $mysqli->close();
?>
<?php
    $outline = $row['outline'];
    if(is_null($outline)) {
        $outlinestr = "无";
    } else {
        $outline = $row['cn'].".".$outline;
        $outlinestr = "<a href='down_outline.php?outline=$outline'>".$outline."</a> (单击下载)";
    }
    $description = $row['description'];
    if(is_null($description)) {
        $descriptionstr = "无";
    } else {
        $descriptionstr = "<span class='area'>$description</span>";
    }
?>
<form>
    <p style="font-size: 16px; margin-bottom: 10px">课程信息：</p>    
    <p><span class="label">课程号</span><?php echo $row['cn']; ?></p>
    <p><span class="label">课程名称</span><?php echo $row['cname']; ?></p>
    <p><span class="label">学分</span><?php echo $row['credit']; ?></p>    
    <p><span class="label" style="vertical-align: top">课程描述</span><?php echo $descriptionstr; ?></p>
    <p><span class="label">课程大纲</span><?php echo $outlinestr; ?></p>
</form>
<p style="margin-top: 30px">单击<a href="course_p.php?p=<?php echo $p; ?>">返回课程列表</a>
<?php
    } else {
        $mysqli->close();
        echo "<p>请求方式不正确！</p>";        
        return;
    }
?>
