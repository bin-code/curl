<?php

/**
 * Created by PhpStorm.
 * User: lwb
 * Date: 2015/3/4
 * Time: 1:20
 */
//选择学期连接http://class.sise.com.cn:7001/SISEWeb/pub/studentstatus/attendance/studentAttendanceViewAction.do?method=doYearTermSelect&studentID=179737&studentCode=1240124178&yearSemester=20141&doSubmit=查看
$url = $_POST['url'];
$studentID = $_POST['studentID'];
$studentCode = $_POST['studentCode'];
$yearSemester = $_POST['yearSemester'];
$doSubmit = $_POST['doSubmit'];
if (!empty($studentID)) {
    $url .= '&studentID=' . $studentID . '&studentCode=' . $studentCode . '&yearSemester=' . $yearSemester . '&doSubmit=' . $doSubmit;
}


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
//echo $contents;

//$form_head = str_replace('/action="([\s\S]*?)"/','',$form_table[0][0]);
preg_match_all('/<input type="hidden"([\s\S]*?)name="([\s\S]*?)"([\s\S]*?)value="([\s\S]*?)"([\s\S]*?)>/', $contents, $hidden_table);//隐藏值
preg_match_all('/<select([\s\S]*?)<input type="submit"([\s\S]*?)name="([\s\S]*?)"([\s\S]*?)value="([\s\S]*?)"/', $contents, $select_table);//下拉
preg_match_all('/action="([\s\S]*?)"/', $contents, $action_table);//提交地址
//print_r($action_table);

//print_r($option_table);
?>
    <form name="studentAttendanceViewActionForm" method="post">
        <input type="hidden" name="url" value="<?php print_r($action_table[1][0]); ?>">
        <?php
        print_r($hidden_table[0][0]);
        print_r($hidden_table[0][1]);
        print_r($select_table[0][0]);
        echo ">"
        ?>
    </form>
    <hr>
<?php
preg_match_all('/<td>(学[\s\S]*?)<\/td>/', $contents, $truant_table);//缺勤次数
print_r($truant_table[1][0]);
preg_match_all('/<thead>([\s\S]*?)<\/tbody>/', $contents, $class_table);//课程考勤
preg_match_all('/<table width="99%">([\s\S]*?)<\/table>/', $contents, $class2_table);//免听课程
preg_match_all('/<table border="0"([\s\S]*?)<\/table>/', $contents, $tip_table);//注意事项
?>
    <hr>
    <table border="1">
        <?php
        print_r($class_table[0][0]);
        ?>
    </table>
    <hr>
<?php
print_r($class2_table[0][1]);
?>
    <hr>
<?php
print_r($tip_table[0][0]);
?>