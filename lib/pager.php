<?php
/*
 * 功能：获得最小页码和最大页码
 * 参数：$pageCount: 总页数
 *       $currentPage：当前页
 *       $showPages： 连续的页码超链接数
 * 返回：pages[0]为最小页码，pages[1]为最大页码
 */
function getBounds($pageCount, $currentPage, $showPages) {
    $startPage = $currentPage-(int)(($showPages-1)/2);           // 初步的最小页码
    $endPage = $currentPage+(int)($showPages/2);                 // 初步的最大页码
    $s = 0;							 // 最小页码的偏差
    if($startPage<1) {
        $s = -$startPage+1;
        $startPage = 1;
    }
    $e = 0;                                                      // 最大页码的偏差
    if($endPage>$pageCount) {
        $e = $endPage-$pageCount;
        $endPage = $pageCount;
    }
    $startPage = max($startPage-$e, 1);           // 用最大页码的偏差去调用最小页码
    $endPage = min($endPage+$s, $pageCount);      // 用最小页码的偏差去调用最大页码
    $pages = array();
    array_push($pages, $startPage);
    array_push($pages, $endPage);
    return $pages;
}
/*
 * 功能：获得翻页导航栏的HTML代码
 * 参数：
 *    $startPage：最小页码
 *    $endPage：最大页码
 *    $pageCount：总页数
 *    $currentPage：当前页码
 *    $url：页码超链接要访问的页面的URL（可以包含请求参数）
 */
function getLinks($startPage, $endPage, $pageCount, $currentPage, $url) {
    if(strpos($url, "?")) $pre = "&amp;"; else $pre = "?";        
    $links = "";
    if($currentPage>1) {
        $dpage = $currentPage-1;
        $links .= "<a href='$url{$pre}p=$dpage'>上一页</a>";
    } 
    if($startPage>1) {
        $links .= "<a href='$url{$pre}p=1'>1</a>";
    }
    if($startPage>2) {
        $links .= "<span>…</span>";
    }
    for($i= $startPage; $i<=$endPage; $i++) {
        if($i==$currentPage) {
            $links .= "<span class='current'>$i</span>";            
        } else {
            $links .= "<a href='$url{$pre}p=$i'>$i</a>";            
        }
    }
    if($endPage<$pageCount-1) {
        $links .= "<span>…</span>";
    }
    if($endPage<$pageCount) {
        $links .= "<a href='$url{$pre}p=$pageCount'>$pageCount</a>";
    }
    if($currentPage<$pageCount) {
        $dpage = $currentPage+1;
        $links .= "<a href='$url{$pre}p=$dpage'>下一页</a>";
    }
    return $links;
}
?>