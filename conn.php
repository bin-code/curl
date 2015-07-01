<?php
/**
 * Created by PhpStorm.
 * User: lwb
 * Date: 2015/3/4
 * Time: 1:19
 */
$con = mysql_connect('localhost', 'root', 'linweibin');
if (!$con) {
    die('Could not connect: ' . mysql_error());
} else {
    mysql_query("SET NAMES utf8");
    mysql_select_db("curl_data", $con);
}
