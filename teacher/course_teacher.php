<link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>
<?php
    $tn = "1019";
?>
<?php
    include_once '../lib/mysql.php';
    $mysqli = connect();
    if ($mysqli->connect_errno) {
        echo "不能连接到数据库<br/>";
        exit();
    }
    $query = "SELECT * FROM course where tn='$tn'";
    $result = executeSql($mysqli,$query);
    if($result->num_rows===0) {
        echo "无课程信息！";
        exit();
    }
?>

<style type="text/css">
    .c1 {width: 150px; text-align: left; padding-left: 10px}    
    .c2 {width: 300px; text-align: left}
    .c3 {width: 80px; text-align: left}    
</style>

<table>
    <thead>
        <tr><th class="c1">课程号</th><th class="c2">课程名</th><th class="c3">学分</th></tr>
    </thead>
    <tbody>
    <?php
    $count = 0;
    while($row = $result->fetch_array()) {
        $count++;
    ?>
    <tr>
        <td class="c1"><?php echo $row['cn'] ?></td>
        <td class="c2"><?php echo $row['cname'] ?></td>
        <td class="c3"><?php echo $row['credit'] ?></td>
    </tr>
    <?php
    }
    ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" style="text-align: left; padding-left: 10px">
                共有<?php echo $count ?>门课程
            </th>
        </tr>
    </tfoot>
</table>
<?php $mysqli->close() ?>