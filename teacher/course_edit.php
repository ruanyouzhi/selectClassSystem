<link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>
<?php
    $tn = "1019";
?>

<?php
    include_once('../lib/mysql.php');
    $mysqli = connect();
    if ($mysqli->connect_errno) {
        echo "<p>不能连接到数据库！</p>";
        return;
    }

    @ session_start();
    if($_SERVER["REQUEST_METHOD"]==="GET") {    
        if(!array_key_exists("course", $_SESSION)) {
            $query = "SELECT cn, cname FROM course WHERE tn='$tn'";
            $result = executeSql($mysqli, $query);
            if($result->num_rows===0) {
                echo "<p>无课程需要编辑！</p>";
                $mysqli->close();
                return;        
            }
            $course = array();
            while($row = $result->fetch_array()) {
                $c = array($row['cn'], $row['cname']);
                array_push($course, $c);    
            }
            $_SESSION["course"] = $course;
        }
        $course = $_SESSION["course"] ;    
        $_SESSION["cn"] = $course[0][0];
?>

<form method="POST">
    <span>请选择课程:</span>
    <select name="cn">
    <?php
        for($i=0; $i<count($course); $i++) {
    ?>    
        <option value="<?php echo $course[$i][0] ?>" 
        <?php echo $_SESSION["cn"]===$course[$i][0] ? 'selected="selected"' : ''?>>
        <?php echo $course[$i][1] ?>
        </option>
    <?php
        }
    ?>
    </select>
    <input type="submit" name="submit1" value="确认" style='margin-left: 10px; padding-top: 3px; padding-bottom: 4px'/>
</form>
<?php
        $mysqli->close();
        return;
    }
?>

<?php
    if($_SERVER["REQUEST_METHOD"]==="POST" AND array_key_exists("submit1", $_POST)) {
        $cn = $_POST["cn"];
        $query = "SELECT * FROM course where cn='$cn'";
        $result = executeSql($mysqli,$query);
        if($result->num_rows<=0) {
            $mysqli->close();
            echo "<p>无课程信息！</p>";
            $url = $_SERVER['SCRIPT_NAME'];
            echo "<p>单击<a href='$url'>继续编辑其他课程</a></p>";
            return;
        }
        $_SESSION["cn"] = $cn;
        $row = $result->fetch_array();
        $_SESSION["outline"] = $row["outline"];      
?>
<form method="POST" enctype="multipart/form-data">
    <p style="font-size: 16px; margin-bottom: 10px">请编辑课程信息（课程描述与大纲）：</p>    
    <p><span class="label">课程号</span><?php echo $row['cn']; ?></p>
    <p><span class="label">课程名称</span><?php echo $row['cname']; ?></p>
    <p><span class="label" style="vertical-align: top">课程描述</span><textarea name="ds" cols="80" rows="10" style="line-height: 22px"><?php echo $row['description'] ?></textarea></p>
    <p><span class="label">课程大纲</span><input id="myfile" type="file" name="upfile" style="width: 360px; "/></p>
    <p><input type="submit" id="submit" name="submit2" value="提交" class="big"/></p>
</form> 
<?php
        $mysqli->close();
        return;
    }
?>

<?php
    if($_SERVER["REQUEST_METHOD"]=="POST" AND array_key_exists("submit2", $_POST)) {
        $cn = $_SESSION["cn"];
        
        $ds = addslashes($_POST['ds']);
//        $ds = $_POST['ds'];echo $ds,"<br />";        
        $query = "UPDATE course SET description = '$ds' WHERE cn='$cn'";
        $result = executeSql($mysqli,$query);
        if($mysqli->affected_rows<=0) {
            echo "<p>课程描述更新失败，或课程描述没有改变！</p>";
        } else {
            echo "<p>课程描述更新成功！</p>";            
        }
        if($_FILES['upfile']['error']!==0) {
            echo "<p>没有指定课程大纲，或课程大纲上传出错！</p>";
        } else {
            $f_name = $_FILES['upfile']['name'];
            $f_name1 = iconv('utf-8', 'GBK', $f_name);            
            $tmp_name = $_FILES['upfile']['tmp_name'];
            $ext = extname($f_name1);
            $f_name2 = $cn.".".$ext;
            $old_ext = $_SESSION["outline"];
            if(!empty($old_ext)) {
                $f_name3 = "../files/".$cn.".".$old_ext;
                unlink($f_name3);
            }
            move_uploaded_file($tmp_name, "../files/$f_name2");        
            $query = "UPDATE course SET outline = '$ext' WHERE cn='$cn'";
            $result = executeSql($mysqli,$query);
            echo "<p>课程大纲更新成功！</p>";
        }
        $mysqli->close();
        $url = $_SERVER['SCRIPT_NAME'];
        echo "<p>单击<a href='$url'>继续编辑其他课程</a></p>";
        return;
    }
    function extname($filename) {
        if(($n=strrpos($filename, "."))===false) return "";
        return substr($filename, $n+1);
    }    
?>