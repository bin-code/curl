<?php

/**
 * Created by PhpStorm.
 * User: lwb
 * Date: 2015/3/4
 * Time: 1:20
 */
//选择学期连接http://class.sise.com.cn:7001/SISEWeb/pub/studentstatus/attendance/studentAttendanceViewAction.do?method=doYearTermSelect&studentID=179737&studentCode=1240124178&yearSemester=20141&doSubmit=查看
$url = $_POST['url'];

//初始化
$curl = curl_init();
//设置url
curl_setopt($curl, CURLOPT_URL, "http://class.sise.com.cn:7001" . $url);
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

//关闭URL请求
curl_close($curl);

//编码转换
$contents = mb_convert_encoding($data, "UTF-8", "gb2312");
echo $contents;
