<?php
header("Content-Type: text/html; charset=utf-8");
session_start();
if(!isset($_SESSION['username'])){
    echo "<script>alert('客官，请先登录^_^!');location='login.php';</script>";
}
if($_GET['action'] == "logout"){
    session_destroy();
    echo "<script>window.location.href='login.php';</script>";
}
?>

<h4><?php echo $_SESSION['username']?></h4>
<a href="curl_menuindex.php">抓取主页信息</a>
<!-- <a href="curl_infoindex.php">抓取考试页面信息</a> -->
<a href="index.php?action=logout">退出</a>
