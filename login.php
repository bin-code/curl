<?php
header("Content-Type: text/html; charset=utf-8");
require "truefalse.php";
    if(!empty($_POST)){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $result = getLogin($username,$password);
        if (preg_match("/(你输入的密码错误，你输入的密码是)(.*)]/", $result, $matches)) {
//	print_r($matches);
            echo "<div align=\"center\">$matches[0]</div>";
            echo "<div align=\"center\"><a href=\"javascript:top.location.href='login.php';\">点击进入登陆页面</a></div>";
        } else {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['hiddenfild'] = getHidden();
//            echo $_SESSION['username'];
//            echo "登录成功";
            echo "<script>alert('登录成功！');window.location.href='index.php';</script>";
        }
    }
?>

<form name="form1" method="post">
			<div><font size="2" color="#006666">学号：</font><input name="username" type="text" size="15" value="12401241"></div>
			<div><font size="2" color="#006666">密码：</font><input name="password" type="password" size="15"></div>
			<div>
			<input type="submit" value=" 登  录 ">
			<input type="reset" value=" 重  写 ">
			</div>
</form>
