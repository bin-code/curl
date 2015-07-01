<?php

/**
 * Created by PhpStorm.
 * User: lwb
 * Date: 2015/3/4
 * Time: 1:20
 */
//class Curl_info
//{
$success = 0;
function getStuInfo($stuid)
{
//初始化
    $curl = curl_init();
//设置url
    curl_setopt($curl, CURLOPT_URL, "http://class.sise.com.cn:7001/SISEWeb/pub/exam/studentexamAction.do?method=doMain&studentid=" . $stuid);
//获取头信息
    curl_setopt($curl, CURLOPT_HEADER, 0);

//设置返回获取的输出为文本流
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//执行命令
    $data = curl_exec($curl);
//检查错误
    if ($data === FALSE) {
        echo "cURL Error:" . curl_error($curl);
    }

//获取信息
    $info = curl_getinfo($curl);
//        echo '获取' . $info['$curl'] . '耗时' . $info['total_time'] . '秒';
// print_r($info);

//关闭URL请求
    curl_close($curl);

//编码转换
    $contents = mb_convert_encoding($data, "UTF-8", "gb2312");
//echo $contents;
// print_r($contents);
    preg_match_all('/<table width="100%" [^>]*>([\s\S]*?)<\/table>/', $contents, $table);//用正则表达式将课表的表格取出

//print_r($table[1][0]);

    preg_match_all('/<span [^>]*>([\s\S]*?)<\/span>/', $table[1][0], $tabkey);
//print_r($tabkey[1]);
//echo "<br>";
    preg_match_all('/<div align="left">([\s\S]*?)<\/div>/', $table[1][0], $tabval);
//print_r($tabval[1]);

    $number = trim($tabval[1][0]);
    $name = trim($tabval[1][1]);
    $grade = trim($tabval[1][2]);
    $major = trim($tabval[1][3]);

        date_default_timezone_set('PRC');
    $nowtime = date('Y-m-d H:i:s');
    $check_sql = "SELECT stu_id FROM stu_info WHERE stu_id='$stuid'";
    $result = mysql_query($check_sql);
    if ($row = mysql_fetch_array($result)) {
        return 0;
    } else {
        if($number == 0) {
            return 0;
        }
        $sql = "INSERT INTO stu_info VALUES ('$stuid','$number','$name','$grade','$major','$nowtime')";
        if (!mysql_query($sql, $con)) {
            echo '录入失败！';
            return 0;
        }
        return 1;

    }
}