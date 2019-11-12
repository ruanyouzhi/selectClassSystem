<link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>
<?php
    $tn = "1019";
?>
<?php
include_once '../lib/mysql.php';
$mysqli = connect();
if ($mysqli->connect_errno) {
    echo "<p>不能连接到数据库！</p>";
    return;
}
@ session_start();
if(!array_key_exists("courses", $_SESSION)) {
    $query = "SELECT lid, cname, status FROM course, opencourse WHERE opencourse.cn=course.cn AND opencourse.tn='$tn' AND (status='2' OR status='3')";
    $result = executeSql($mysqli, $query);
    if($result->num_rows===0) {
        echo "<p>无课程需要输入成绩！</p>";
        $mysqli->close();
        return;        
    }
    $courses = array();
    while($row = $result->fetch_array()) {
        $c = array($row['lid'], $row['cname'], $row['status']);
            $courses[$row['lid']] = $c;    
    }
    $_SESSION["courses"] = $courses;
}
$courses = $_SESSION["courses"] ;    
if(!array_key_exists("lid", $_SESSION)) {
    reset($courses);
    $_SESSION["lid"] = key($courses);
}
$lid = $_SESSION["lid"];
if(!array_key_exists("status", $_SESSION)) $_SESSION["status"] = $courses[$lid][2];
$status = $_SESSION["status"];
?>
<?php
$flag1 = false;
if ($_SERVER["REQUEST_METHOD"] == "POST" && array_key_exists("submit1", $_POST)) {
    $_SESSION["lid"] = $_POST["lid"];
    $lid = $_SESSION["lid"];
    $_SESSION["status"] = $courses[$lid][2];
    $status = $_SESSION["status"];
    $query = "SELECT student.sn, sname, score FROM student, elective where student.sn=elective.sn and lid='".$lid."'";
    $result = executeSql($mysqli,$query);

    $scores = array();		
    while($row = $result->fetch_array()) {
        $s = array($row['sn'], $row['sname'], $row['score']);
        array_push($scores, $s);    
    }
    $_SESSION['scores'] = $scores;
    $flag1 = true;        
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && (array_key_exists("submit2", $_POST) || array_key_exists("submit3", $_POST))) {
    $scores = $_SESSION['scores'];
    for($i=0; $i<count($scores); $i++) {
        $t_sn =$scores[$i][0];
        $scores[$i][2] = $_POST[$t_sn];
            
        $sql = "UPDATE elective SET score = ".$scores[$i][2]." WHERE sn = '".$scores[$i][0]."' AND lid = '".$lid."'"; 
        executeSql($mysqli,$sql);
    }
    $flag1 = true;
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && array_key_exists("submit3", $_POST)) {
    $sql = "UPDATE opencourse SET status = '3' WHERE lid = ".$lid.""; 
    executeSql($mysqli,$sql);
    $courses[$lid][2] = 3;    
    $_SESSION['status'] = '3';
    $status = 3;
}   
$mysqli->close();
?>

<form method="POST">
<div style="margin: 20px 0px 15px 0px">
    <span>请选择课程:</span>
    <select name="lid">
        <?php
        foreach($courses AS $key=>$value) {
        ?>    
            <option value="<?php echo $key ?>" <?php echo $lid==$key ? "selected='selected'" : ''?>><?php echo $value[1] ?></option>
        <?php
        }
        ?>
    </select>
    <input type="submit" name="submit1" value="确　认" style="margin-left: 20px"/>
</div>
</form>

<?php
if($flag1) {
?>
<form name="form2" class="form2" action="" method="POST">
<table>
    <thead>
    <tr>
        <th style="width: 150px; text-align: left; padding-left: 10px">学号</th><th style="width: 150px; text-align: left">姓名</th><th style="width: 80px; text-align: left">成绩</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for($i=0; $i<count($scores); $i++) {
    ?>
        <tr>
            <td style="padding-left: 10px"><?php echo $scores[$i][0] ?>
            </td><td><?php echo $scores[$i][1] ?></td>
            <?php
            if($status==2) {
            ?>
            <td><input type="text" name="<?php echo $scores[$i][0] ?>" value="<?php echo $scores[$i][2] ?>" style="width: 60px; text-align: right"></td>
            <?php
            } else {
            ?>
            <td><?php printf("%6.2f",$scores[$i][2]) ?></td>            
            <?php
            }
            ?>
        </tr>
    <?php
    }
    ?>
    </tbody>
    <tfoot>
        <tr style="height: 50px">
            <?php
            if($status==2) {
            ?>
                <td colspan="2" style="text-align: left"><input type="submit" name="submit3" value="提交成绩"/></td>
                <td style="text-align: left"><input type="submit" name="submit2" value="保存成绩"/></td>
            <?php
            } else {
            ?>
                <td colspan="3" style="text-align: right"><p>成绩已经提交, 不能修改!</p></td>                
            <?php
            } 
            ?>
        </tr>
    </tfoot>        
</table>
</form>
<?php
}
?>