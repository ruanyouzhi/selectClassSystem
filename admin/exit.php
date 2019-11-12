<?php
session_start();           // 恢复会话
session_destroy();
header("Location: index_admin.php");
exit();
?>