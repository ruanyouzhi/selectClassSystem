<!-- <link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/> -->
<?php
    // $sn = "201209031001";
    // $name = "胡文海";
?>

<?php
    include_once('../lib/mysql.php');
    $mysqli = connect();
    if ($mysqli->connect_errno) {
        echo "不能连接到数据库<br/>";
        exit();
    }
    $query = "SELECT term, cname, credit, score FROM elective, opencourse, course where opencourse.cn = course.cn and elective.lid=opencourse.lid and elective.sn='$sn' AND opencourse.status='3' ORDER BY term, opencourse.cn";
    $result = executeSql($mysqli,$query);
    if($result->num_rows===0) {
        echo "<p style='margin: 10px'>无结课课程!</p>";
        return;
    }
    $num = 0;		
    while($row = $result->fetch_array()) {
        if($row['score']<60) $num++;
    }
?>
<table>
    <tr><th style="width: 110px; text-align: left; padding-left: 5px; color: #458994">学号</th><td><?php echo $sn ?></td></tr>
    <tr><th style="text-align: left; padding-left: 5px; color: #458994">姓名</th><td><?php echo $name ?></td></tr>
    <tr><th style="text-align: left; padding-left: 5px; color: #458994">不及格门数</th><td><?php echo $num ?></td></tr>
</table>

<table>
    <thead>
    <tr>
        <th style="width: 150px; text-align: left; padding-left: 10px">学期</th><th style="width: 300px; text-align: left">课程名</th><th style="width: 60px; text-align: left">学分</th><th style="width: 60px; text-align: left">成绩</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $result->data_seek(0);
    $sum = 0; $count = 0;
    while($row = $result->fetch_array()) {
        $sum = $sum + $row['score'];
        $count++;
    ?>
        <tr>
            <td style="padding-left: 10px"><?php echo $row['term'] ?></td><td><?php echo $row['cname'] ?></td><td><?php echo $row['credit'] ?></td><td<?php echo $row['score']<60?" style='color: red'":""?>><?php echo $row['score'] ?></td>
        </tr>
    <?php 
    }
    ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" style="text-align: left; padding-left: 10px">平均分</th><th style="text-align: left"><?php printf("%.2f", $sum/$count) ?></th>
        </tr>
    </tfoot>
</table>
