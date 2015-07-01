<?php

/**
 * Created by PhpStorm.
 * User: lwb
 * Date: 2015/3/4
 * Time: 1:20
 */
header("Content-Type: text/html; charset=utf-8");
require "curl_menu.php";
// require 'conn.php';
session_start();
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$hiddenfild = $_SESSION['hiddenfild'];
$url = $_POST['url'];
if(!empty($url)){
    $_SESSION['url'] = $url;
}
$schoolyear = $_GET['schoolyear'];
$semester = $_GET['semester'];
if (!empty($schoolyear)) {
    $url = $_SESSION['url'].'?schoolyear=' . $schoolyear . '&semester=' . $semester;
}
$contents = getMenu($hiddenfild, $username, $password, $url);
//echo $contents;

preg_match_all('/<table([\s\S]*?)width="95[^>]*>([\s\S]*?)<\/table>/', $contents, $table);//用正则表达式将课表的表格取出
//print_r($table);
preg_match_all('/<select([\s\S]*?)[^>]*>([\s\S]*?)<\/select>/', $table[2][0], $class_date);//学期时间;

//preg_match_all('/<span([\s\S]*?)<\/span>/',$table[2][1],$title_data);//标题
//print_r($title_data[0][0]);
//
//preg_match_all('/<font([\s\S]*?)<\/font>/',$table[2][2],$title_tip);//提示
//print_r($title_tip[0][0]);

preg_match_all('/<tr height="25">([\s\S]*?)<\/tr>/', $table[2][3], $info_data);//信息
//print_r($info_data);

?>
<form>
    <table>
        <tr>
            <td>
                <?php
                print_r($class_date[0][0]);
                print_r($class_date[0][1]);
                ?>
                <input type="submit" value=" 确  定 ">
            </td>
        </tr>
        <?php
        print_r($table[2][1]);
        print_r($table[2][2]);
        print_r($info_data[0][0]);
        //print_r($table[0][4]);
        ?>
    </table>
    <hr>
    <?php
    preg_match_all('/<td([\s\S]*?)>([\s\S]*?)<\/td>/', $table[2][4], $class_data);//课程表
    //print_r($class_data[2]);
    $now = date("w");
    //echo $now;
    ?>
    <h3>今天课程</h3>
    <table border="1">
        <?php
        $count_row = count($class_data[2]) / 8;
        for ($i = 0; $i < $count_row; $i++) {
            echo "<tr><td>";
            print_r($class_data[2][$i * 8]);
            echo "</td><td>";
            print_r($class_data[2][$i * 8 + $now]);
            echo "</td></tr>";
        }

        ?>
    </table>
    <hr>
    <table border="1">
        <?php
        for ($i = 0; $i < count($class_data[2]); $i++) {
            if ($i % 8 == 0)
                echo "<tr>";
            echo "<td>";
            print_r($class_data[2][$i]);
            echo "</td>";
            if ($i % 8 == 7)
                echo "</tr>";
        }
        ?>
    </table>

</form>