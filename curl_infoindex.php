<?php
/**
 * Created by PhpStorm.
 * User: lwb
 * Date: 2015/3/4
 * Time: 11:01
 */

require "curl_info.php";
require 'conn.php';
set_time_limit(0);
$t1 = microtime(true);
echo "<h1>开始时间:".date('Y-m-d H:i:s')."</h1>";
for($i=51; $i<=100; $i++){
    $datas += getStuInfo($i,$con);
    $count++;
}
$t2 = microtime(true);
echo "<h1>结束时间:".date('Y-m-d H:i:s')."</h1>";
echo '成功导入：'.$datas.'条，共'.$count.'条数据'.'<br>';
echo '耗时'.round($t2-$t1,3).'秒';
mysql_close($con);