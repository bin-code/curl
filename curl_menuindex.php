<?php
header("Content-Type: text/html; charset=utf-8");
require "curl_menu.php";
// require 'conn.php';
session_start();
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$hiddenfild = $_SESSION['hiddenfild'];
$url = '/sise/module/student_states/student_select_class/main.jsp';
$contents = getMenu($hiddenfild,$username,$password,$url);
if (!empty($contents)) {
preg_match_all('/(window.)(.*)\"/', $contents, $table);//主页22个连接
preg_match_all('/<strong>([\s\S]*?)<\/strong>/', $contents, $tabkey);//对应的链接信息
} else {
	echo "抓取失败";
}
?>
<table  width="100%"  border="1">
<?php
for($i=0; $i<23; $i++){
	if ($i==21) {
		continue;
	}
	$menu_id = $i+1;
	$menu_name = $tabkey[1][$i];
	$menu_url = explode('\'',$table[2][$i]);
	$url = strstr($menu_url[1], '/SISE');
	if (!$url) {
		$url = $menu_url[1];
	}
	?>
<tr>
<td align=center><?php echo $menu_id ?></td>
<td align=center><?php echo $menu_name ?></td>
<td align=center><a href="http://class.sise.com.cn:7001<?php echo $url?>"><?php echo $url ?></a></td>
<!--<td align=center><a href="--><?php //echo $menu_id.'.php?url='.$url ?><!--">抓取</a></td>-->
<td align=center>
	<form method="post" action="<?php echo $menu_id.'.php' ?>">
		<input type="hidden" name="url" value="<?php echo $url?>">
		<input type="submit" value="抓取">
	</form> </td>
</tr>
<?php
// $sql="INSERT INTO menu VALUES ('$menu_id','$menu_name','$url')";
// if (!mysql_query($sql, $con)) {
//             echo '录入失败！';
//         }
//         echo '录入成功！';
 }
//  mysql_close($con);
?>
</table>