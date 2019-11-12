<!-- <link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/> -->
<?php
    //$sn='201209031001';
?>
<?php
    include_once('../lib/mysql.php');
    $mysqli = connect();
    if ($mysqli->connect_errno) {
        echo "不能连接到数据库<br/>";
        return;
    }
?>
<?php
    @session_start();

    if($_SERVER['REQUEST_METHOD']==="GET") {    
        $query = "SELECT lid, term, course.cname, teacher.tname, teacher.dept FROM opencourse, course, teacher WHERE opencourse.cn=course.cn AND opencourse.tn=teacher.tn AND status='1' ORDER BY term, opencourse.cn, opencourse.tn";
        $result = executeSql($mysqli,$query);

        $opencourse = array();
        while($row = $result->fetch_array(MYSQLI_NUM)) {
            $lid = $row[0];
            $sql = "SELECT COUNT(*) FROM elective WHERE lid='$lid' AND sn='$sn'";
            $res = executeSql($mysqli,$sql);
            $r = $res->fetch_array(MYSQLI_NUM);
            if($r[0]!=='0') {
                array_push($row, 1);
            } else {
                array_push($row, 0);            
            }
            $opencourse[$row[0]]=$row;
        }
    }
    if($_SERVER['REQUEST_METHOD']==="POST") {
        $opencourse1 = @$_SESSION['opencourse1'];
        $opencourse2 = @$_SESSION['opencourse2'];
        $opencourse3 = @$_SESSION['opencourse3'];
        reset($opencourse2);
        while(current($opencourse2)) {
            $key = key($opencourse2);
            $opencourse2[$key][5]=0;
            if(array_key_exists($key, $_POST)) {
                $opencourse2[$key][5] = 1;
            }
            next($opencourse2);
        }
        $opencourse = $opencourse1 + $opencourse2 + $opencourse3;
        if(array_key_exists("confirm", $_POST)) {
            $sql = "DELETE FROM elective WHERE sn='$sn' AND lid IN (SELECT lid FROM opencourse WHERE status='1')";
            executeSql($mysqli,$sql);
            
            reset($opencourse);
            while(current($opencourse)) {
                $lid = key($opencourse);
                if($opencourse[$lid][5]===1) {
                    $sql1 = "INSERT INTO elective(sn,lid) VALUES('$sn', $lid)";
                    executeSql($mysqli,$sql1);
                }
                next($opencourse);
            }
 
            echo "<p>你的选课结果已经保存</p>";
            $url = $_SERVER["SCRIPT_NAME"];
            echo "<p>如果需要重新选择或更新，请单击<a href='$url'>选课表</a></p>";
            return;
        }        
    }
?>
<?php
    $submits = "";
    
    $rows = count($opencourse);
    $pageSize = 2;
    $pageCount = (int)ceil($rows/$pageSize);
    @ $currentPage = $_GET['p'];
    if(empty($currentPage)) $currentPage = 1;        
    elseif($currentPage<1) $currentPage = 1;
    elseif($currentPage>$pageCount) $currentPage = $pageCount;

    $showPages = 4;
    include_once('../lib/pager.php');
    include_once('../lib/pager_1.php');    
    list($startPage, $endPage) = getBounds($pageCount, $currentPage, $showPages);
    $url = $_SERVER['SCRIPT_NAME'];
    $submits = getSubmits($startPage, $endPage, $pageCount, $currentPage, $url);

?>
<?php
    $first = ($currentPage-1)*$pageSize;
    $opencourse1=  array_slice($opencourse, 0, $first, true);
    $opencourse2 = array_slice($opencourse, $first, $pageSize, true);
    $opencourse3 = array_slice($opencourse, $first+$pageSize, $rows, true);
    $_SESSION['opencourse1'] = $opencourse1;
    $_SESSION['opencourse2'] = $opencourse2;
    $_SESSION['opencourse3'] = $opencourse3;
?>

<style type="text/css">
    table .c1 {width: 100px; text-align: left; padding-left: 10px}    
    table .c2 {width: 300px; text-align: left}
    table .c3 {width: 80px; text-align: left}
    table .c4 {width: 180px; text-align: left}
    table .c5 {width: 50px; text-align: left}       
</style>
<form id='f1' method="POST">
<table>
    <caption>
        <input name='confirm' type='submit' value='确认提交' style='display: inline-block; float: right; margin-bottom: 8px' />
    </caption>
    <thead>
        <tr>
            <th class="c1">学期</th>
            <th class="c2">课程名</th>
            <th class="c3">教师</th>
            <th class="c4">所属部门</th>
            <th class="c5">选择</th>             
        </tr>
    </thead>
    <tbody>
    <?php

        reset($opencourse2);
        foreach($opencourse2 as $key=>$value) {

     ?>
        <tr>
            <td class='c1'><?php echo $value[1] ?></td>
            <td class='c2'><?php echo $value[2] ?></td>
            <td class='c3'><?php echo $value[3] ?></td>
            <td class='c4'><?php echo $value[4] ?></td>
            <td class='c5'><input type='checkbox' name='<?php echo $key ?>' <?php echo($value[5]!=0?"checked='checked'":"") ?> /></td>            
        </tr>
    <?php } ?>
    </tbody>
    
    <tfoot>
        <tr style="height: 10px"><td colspan="5"></td></tr>        
    </tfoot>    
</table>

<div class="pager">
    <?php echo $submits ?>
    <div style="clear: both"></div>
</div>
</form> 
<?php $mysqli->close(); //session_destroy(); ?>
