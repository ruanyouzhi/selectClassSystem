<?php
    if($_SERVER["REQUEST_METHOD"]==="GET" && array_key_exists("outline", $_GET)) {
        $outline = $_GET['outline'];
        $f_name = "../files/".$outline;
        $f_name = iconv("utf-8", "GBK", $f_name);   // 转换文件名的字符编码
        header("Content-Length:".filesize($f_name));
        header("Content-Disposition: attachment; filename=$outline");    // 下载文件
        readfile($f_name);
    } else {
        echo "<p>请求方式不正确！</p>";        
        return;
    }
?>