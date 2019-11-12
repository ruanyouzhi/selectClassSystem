<!--
*  功能：分页呈现所有教师的信息列表
*  输入：链入外部样式表<link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/>
-->
<!-- <link rel="stylesheet" type="text/css" href="/xk/css/xk.css"/> -->
<?php
include_once '../lib/mysql.php';
include_once '../lib/pager.php';
// 连接数据库
$mysqli = connect();
if ($mysqli->connect_errno) {
    echo "不能连接到数据库<br/>";
    return;
}
/* 通过查询数据库获取总行数，设置页面大小，并计算总页数 */
$query = "SELECT COUNT(*) FROM teacher";
$result = executeSql($mysqli,$query);
$rows = $result->fetch_array()[0];
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
$query = "SELECT * FROM teacher ORDER BY dept, tn LIMIT $first, $pageSize";
$result = executeSql($mysqli,$query);
?>
<!-- 呈现当前页教师数据 -->
<style type="text/css">
    table .c1 {width: 80px; padding-left: 10px}    
    table .c2 {width: 80px}
    table .c3 {width: 180px}
    table .c4 {width: 100px}
</style>
<table>
    <thead>
        <tr>
        <td class="c1">职工号</td><td class="c2">姓名</td>
        <td class="c3">所属部门</td><td class="c4">是否管理员</td>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_array()) { ?>
            <tr>
            <td class="c1"><?php echo $row['tn'] ?></td>
            <td class="c2"><?php echo $row['tname'] ?></td>
            <td class="c3"><?php echo $row['dept'] ?></td>
            <td class="c4"><?php echo $row['admin']==='是'?'√':'' ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr style="height: 10px"><td colspan="4"></td></tr>
    </tfoot>
</table>
<div class="pager"><?php echo $links ?><div style="clear: both"></div></div>
<?php $mysqli->close() ?>
