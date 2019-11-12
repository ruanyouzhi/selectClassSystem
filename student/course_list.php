<link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>
<?php
    include_once('../lib/mysql.php');
    include_once('../lib/pager.php');    
    $mysqli = connect();
    if ($mysqli->connect_errno) {
        echo "不能连接到数据库<br/>";
        return;
    }
    $query = "SELECT count(*) FROM course"; 
    $result = executeSql($mysqli,$query);
    $rows = $result->fetch_array()[0];
    if($rows===0) {
        echo "无课程信息！";
        return;
    }
?>
<?php
$pageSize = 3;                              // 设置页面大小
$pageCount = (int)ceil($rows/$pageSize);    // 总页数
/* 确定当前页码 */
@ $currentPage = $_GET['p'];
if(empty($currentPage)) $currentPage = 1;        
elseif($currentPage<1) $currentPage = 1;
elseif($currentPage>$pageCount) $currentPage = $pageCount;
/* 构建翻页导航栏的HTML代码、或者是相当的信息，并保存在变量$links中 */
$links = "";
if($rows === 0) {
    $links = "<span>无数据！</span>";
} elseif($pageCount === 1) {
    $links = "<span>共{$rows}条记录！</span>";
} else {
    $showPages = 1;                         // 设置翻页导航栏中连续页码超链接数
    list($startPage, $endPage) = getBounds($pageCount, $currentPage, $showPages);
    $url = $_SERVER['SCRIPT_NAME'];         // 当前被请求PHP文件路径和文件名
    $links = getLinks($startPage, $endPage, $pageCount, $currentPage, $url);        
}
/* 获取当前页的数据记录 */
$first = ($currentPage-1)*$pageSize;
$query = "SELECT cn, cname, credit, tname FROM course, teacher WHERE course.tn=teacher.tn ORDER BY cn LIMIT $first, $pageSize"; 
$result = executeSql($mysqli,$query);
?>
<style type="text/css">
    .c1 {width: 150px; text-align: left; padding-left: 10px}    
    .c2 {width: 300px; text-align: left}
    .c3 {width: 80px; text-align: left}
    .c4 {width: 60px; text-align: left}     
</style>

<table>
    <thead>
    <tr><th class="c1">课程号</th><th class="c2">课程名</th><th class="c3">学分</th><th class="c4">教师</th></tr>
    </thead>
    <tbody>
    <?php
    $count = 0;
    while($row = $result->fetch_array()) {
    ?>
    <tr>
        <td class="c1">
        <?php
            $cn = $row['cn'];
            echo "<a href='course_p.php?p=$currentPage&cn=$cn'>".$row['cn']."</a>";
        ?>
        </td>
        <td class="c2"><?php echo $row['cname'] ?></td>
        <td class="c3"><?php echo $row['credit'] ?></td>
        <td class="c4"><?php echo $row['tname'] ?></td>            
    </tr>
    <?php } ?>
    </tbody>
    <tfoot>
        <tr style="height: 10px"><td colspan="4"></td></tr>        
    </tfoot>
</table>
<div class="pager"><?php echo $links ?><div style="clear: both"></div></div>
<?php $mysqli->close() ?>