<?php
/*
 * 功能：获得翻页导航栏的HTML代码
 * 参数：
 *    $startPage：最小页码
 *    $endPage：最大页码
 *    $pageCount：总页数
 *    $currentPage：当前页码
 *    $url：页码超链接要访问的页面的URL（可以包含请求参数）
 */
function getSubmits($startPage, $endPage, $pageCount, $currentPage, $url) {
    if(strpos($url, "?")) $pre = "&amp;"; else $pre = "?";        
    $submits = "";
    if($currentPage>1) {
        $dpage = $currentPage-1;
        $submits .= "<input name='pager' type='submit' form='f1' formaction='$url{$pre}p=$dpage' value='上一页' />";
    } 
    if($startPage>1) {
        $submits .= "<input name='pager' type='submit' form='f1' formaction='$url{$pre}p=1' value='1' />";
    }
    if($startPage>2) {
        $submits .= "<span>…</span>";
    }
    for($i= $startPage; $i<=$endPage; $i++) {
        if($i==$currentPage) {
            $submits .= "<span class='current'>$i</span>";            
        } else {
            $submits .= "<input name='pager' type='submit' form='f1' formaction='$url{$pre}p=$i' value='$i' />";            
        }
    }
    if($endPage<$pageCount-1) {
        $submits .= "<span>…</span>";
    }
    if($endPage<$pageCount) {
        $submits .= "<input name='pager' type='submit' form='f1' formaction='$url{$pre}p=$pageCount' value='$pageCount' />";
    }
    if($currentPage<$pageCount) {
        $dpage = $currentPage+1;
        $submits .= "<input name='pager' type='submit' form='f1' formaction='$url{$pre}p=$dpage' value='下一页' />";
    }
    return $submits;
}
?>