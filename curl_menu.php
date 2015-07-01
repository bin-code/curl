<?php
/**
 * 实例描述：登录并下载页面
 */

function getMenu($hiddenfild, $username, $password,$url)
{
//$data= "63e311923d9d39f94409246907b9db70=fb5faf13e4d244dd057f50a7fb0b4dec&username=$username&password=$password";//我外网
    // <input type="hidden" name="19a71e8d27c100d498c02e72a8093852" value="b8c972d9ee8c8a707d9f168c28047944">小面条外网
    $data = "$hiddenfild&username=$username&password=$password";//内网
    $curlobj = curl_init();            // 初始化
    curl_setopt($curlobj, CURLOPT_URL, "http://class.sise.com.cn:7001/sise/login_check.jsp");        // 设置访问网页的URL
    curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);            // 执行之后不直接打印出来

// Cookie相关设置，这部分设置需要在所有会话开始之前设置
    date_default_timezone_set('PRC'); // 使用Cookie时，必须先设置时区
    curl_setopt($curlobj, CURLOPT_COOKIESESSION, TRUE);
    curl_setopt($curlobj, CURLOPT_COOKIEFILE, "cookiefile");
    curl_setopt($curlobj, CURLOPT_COOKIEJAR, "cookiefile");
    curl_setopt($curlobj, CURLOPT_COOKIE, session_name() . '=' . session_id());
    curl_setopt($curlobj, CURLOPT_HEADER, 0);
    curl_setopt($curlobj, CURLOPT_FOLLOWLOCATION, 1); // 这样能够让cURL支持页面链接跳转

    curl_setopt($curlobj, CURLOPT_POST, 1);
    curl_setopt($curlobj, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curlobj, CURLOPT_HTTPHEADER, array("application/x-www-form-urlencoded; charset=GBK",
        "Content-length: " . strlen($data)
    ));
    curl_exec($curlobj);    // 执行
    curl_setopt($curlobj, CURLOPT_URL, "http://class.sise.com.cn:7001".$url);
    curl_setopt($curlobj, CURLOPT_POST, 0);
    curl_setopt($curlobj, CURLOPT_HTTPHEADER, array("text/html; charset=GBK"
    ));
    $output = curl_exec($curlobj);    // 执行

    $contents = mb_convert_encoding($output, "UTF-8", "gb2312");
    curl_close($curlobj);            // 关闭cURL
    return $contents;
    // echo $contents;
//  preg_match_all('/(window.location)(.*)\"/', $contents, $table);//主页22个连接
//   // print_r($table[2]);
// echo "<br>";
// preg_match_all('/<strong>([\s\S]*?)<\/strong>/', $contents, $tabkey);
// print_r($tabkey[1]);
//echo "<br>";
    // preg_match_all('/<div align="left">([\s\S]*?)<\/div>/', $table[1][0], $tabval);
//匹配字符串方法
// function substr_between($string, $start, $end=null) {
//     if(($start_pos = strpos($string, $start)) !== false) {
//         if($end) {
//             if(($end_pos = strpos($string, $end, $start_pos + strlen($start))) !== false) {
//                 return substr($string, $start_pos + strlen($start), $end_pos - ($start_pos + strlen($start)));
//             }
//         } else {
//             return substr($string, $start_pos);
//         }
//     }
//     return false;
// }	
}