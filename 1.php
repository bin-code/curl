<?php

/**
 * Created by PhpStorm.
 * User: lwb
 * Date: 2015/3/4
 * Time: 1:20
 */
require_once "curl_getTable.php";
require_once "curl_getCredit.php";
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
// echo $contents;

//个人信息
preg_match_all('/<table width="100%"[^>]*>([\s\S]*?)<\/table>/', $contents, $info_table);//用正则表达式将课表的表格取出
preg_match_all('/<span [^>]*>([\s\S]*?)<\/span>/', $info_table[1][0], $tabkey);//键
// print_r($tabkey[1]);
// echo "<hr>";
preg_match_all('/<td height="16" [^>]*>([\s\S]*?)<\/td>/', $info_table[1][0], $tabclass);
// print_r($tabclass[1][8]);
// echo "<hr>";
preg_match_all('/<div align="left">([\s\S]*?)<\/div>/', $info_table[1][0], $tabval);//值
// print_r($tabval[1]);
?>
    <table border="1">
        <th colspan="2">个人信息</th>
        <?php
        for ($i = 0; $i < 9; $i++) {
            $info_name = trim($tabkey[1][$i]);
            if ($i == 6) {
                $tmp_value = $tabclass[1][8];
            } else if ($i > 6) {
                $tmp_value = $tabval[1][$i - 1];
            } else {
                $tmp_value = $tabval[1][$i];
            }
            $info_value = trim($tmp_value);

            ?>
            <tr>
                <td align=center><?php echo $info_name ?></td>
                <td align=center><?php echo $info_value ?></td>
            </tr>
        <?php
        }
        //成绩信息
        preg_match_all('/<table width="90%" class="table" [^>]*>([\s\S]*?)<\/table>/', $contents, $grade_table);//用正则表达式将课表的表格取出
        // print_r($table);
        ?>
    </table>
    <hr>
    <div style="width:100%;" align="center">
        <h4>必修课程</h4>
        <h5>备注：《课程名称》是红颜色的表示不及格 《修读学年学期》是空白的表示没选过这门课</h5>
    </div>
<?php
getTable($grade_table[0][0]);
?>
    <hr>
    <div style="width:100%;" align="center">
        <h4>已选修课程</h4>
    </div>
<?php
getTable($grade_table[0][1]);
//数据信息
preg_match_all('/<table width="90%" border="0" [^>]*>([\s\S]*?)<\/table>/', $contents, $data_table);//用正则表达式将课表的表格取出
getCredit($data_table);
?>