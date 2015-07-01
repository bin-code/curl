
<?php
/**
 * Created by PhpStorm.
 * User: lwb
 * Date: 2015/3/9
 * Des: 抓取登录是否成功
 * Time: 11:01
 */
function getHidden(){
	$curlobj = curl_init();			// 初始化
	//抓取隐藏域
	curl_setopt($curlobj, CURLOPT_URL, "http://class.sise.com.cn:7001/sise/");		// 设置访问网页的URL
	curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);			// 执行之后不直接打印出来
	$output=curl_exec($curlobj);	// 执行
	$contents = mb_convert_encoding($output, "UTF-8", "gb2312");
	curl_close($curlobj);			// 关闭cURL
//echo $contents;
	preg_match_all('/<input type="hidden" name=([\s\S]*?)>/', $contents, $tabkey);//对应的链接信息
	$hiddens = explode("\"",$tabkey[1][0]);
	$hidden_name = $hiddens[1];
	$hidden_value = $hiddens[3];
	$hidden_all = $hidden_name."=".$hidden_value;
	return $hidden_all;
}

function getLogin($username,$password)
{
	$hiddenfild = getHidden();
	//抓取登录成功信息
	$data = "$hiddenfild&username=$username&password=$password";
	$cookie_file = tempnam('./temp', 'cookie');
	$curlobj = curl_init();            // 初始化
	curl_setopt($curlobj, CURLOPT_URL, "http://class.sise.com.cn:7001/sise/login_check.jsp");        // 设置访问网页的URL
	curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);            // 执行之后不直接打印出来

// Cookie相关设置，这部分设置需要在所有会话开始之前设置
	date_default_timezone_set('PRC'); // 使用Cookie时，必须先设置时区
	curl_setopt($curlobj, CURLOPT_COOKIESESSION, TRUE);
	curl_setopt($curlobj, CURLOPT_COOKIEFILE, $cookie_file);
	curl_setopt($curlobj, CURLOPT_COOKIEJAR, $cookie_file);
	curl_setopt($curlobj, CURLOPT_COOKIE, session_name() . '=' . session_id());
	curl_setopt($curlobj, CURLOPT_HEADER, 0);
	curl_setopt($curlobj, CURLOPT_FOLLOWLOCATION, 1); // 这样能够让cURL支持页面链接跳转

	curl_setopt($curlobj, CURLOPT_POST, 1);
	curl_setopt($curlobj, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curlobj, CURLOPT_HTTPHEADER, array("application/x-www-form-urlencoded; charset=GBK",
		"Content-length: " . strlen($data)
	));
	$login_result = curl_exec($curlobj);    // 执行
	$login_contents = mb_convert_encoding($login_result, "UTF-8", "gb2312");
	curl_close($curlobj);			// 关闭cURL
	return $login_contents;
//if (preg_match('/<div[.*]>([\s\S]*?)<\/div>/', $login_contents, $matches)) {
//<div align="center"><a href="javascript:top.location.href='sessionSetNull.jsp';">点击进入登陆页面</a></div>

}

?>