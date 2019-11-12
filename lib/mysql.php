<?php
/*
 * 功能：创建与数据库elective_manage，返回连接对象，
 *       调用者应访问连接对象的相关属性判别是否连接成功
 * 输入：无
 */
function connect() {
    @$mysqli = new mysqli('localhost', 'root', '', 'elective_manage');
    return $mysqli;
}
/*
 * 功能：执行SQL语句，返回执行结果。如果执行失败，返回false；
 *       如果成功执行INSERT等数据更新语句，返回true;
 *       如果成功执行SELECT等查询语句，返回一个MySQLi_RESULT对象
 * 输入：$mysql：与数据库的连接对象
 *       $sql：要执行的SQL语句
 */
function executeSql($mysqli, $sql) {
    $mysqli->set_charset('UTF8');    
    $result = $mysqli->query($sql);
    return $result;
}
/*
 *  功能：获取指定部门和指定学期的开课信息 
 *  参数：$mysqli: 对数据库elective_manage的连接对象
 *        $dept：登录管理员所属部门
 *        $term：学期
 */
function getOpenCourseData($mysqli, $dept, $term) {
    $query = "SELECT oc.lid, cname, tname, status, "
            ."(SELECT COUNT(*) FROM elective WHERE lid = oc.lid) num "
            ."FROM opencourse oc, course c, teacher t WHERE oc.cn = c.cn "
            . "AND oc.tn = t.tn AND dept = '$dept' AND term = '$term'";
    $result = executeSql($mysqli, $query);
    $ocs = array();		
    while($row = $result->fetch_array()) {
        $oc=array($row['lid'],$row['cname'],$row['tname'],$row['status'],$row['num']);
        array_push($ocs, $oc);    
    }
    return $ocs;        
} 
?>