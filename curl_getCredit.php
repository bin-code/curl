<?php
/**
 * Created by PhpStorm.
 * User: lwb
 * Date: 2015/3/10
 * Time: 1:48
 */
function getCredit($data_table)
{

//print_r($data_table[1][5]);
//echo "<hr>";
//print_r($data_table[1][7]);
//echo "<hr>";
    preg_match_all('/<div align="right">([\s\S]*?)<font[^>]*><b[^>]*>([\s\S]*?)<\/b>/', $data_table[1][5], $credit_table1);//必修学分
    preg_match_all('/<div align="left">([\s\S]*?)<\/div>/', $data_table[1][5], $fraction_table1);//分数
    ?>
    <table style="margin-left: 85%;">
        <?php
        for ($i = 0; $i < count($credit_table1[2]); $i++) {
            $fraction_name = $credit_table1[2][$i];
            $fraction_value = $fraction_table1[1][$i];
            ?>
            <tr>
                <td><?php echo $fraction_name ?></td>
                <td><?php echo $fraction_value ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
    <?php

    preg_match_all('/<div align="right">([\s\S]*?)<font[^>]*><b[^>]*>([\s\S]*?)<\/b>/', $data_table[1][7], $credit_table2);//必修学分
//    print_r($credit_table1[2]);
//    echo "<hr>";
//    print_r($credit_table2[2]);
//    echo "<hr>";
//    preg_match_all('/<div align="left">([\s\S]*?)<\/div>/', $data_table[1][5], $fraction_table1);//分数
//    print_r($fraction_table1[1]);
//    echo "<hr>";
    preg_match_all('/<div align="left">([\s\S]*?)<\/div>/', $data_table[1][7], $fraction_table2);//分数
    ?>
    <hr>
    <table style="margin-left: 85%;">
        <?php
        for ($i = 0; $i < count($credit_table2[2]); $i++) {
            $fraction_name = $credit_table2[2][$i];
            $fraction_value = $fraction_table2[1][$i];
            $fraction = substr_between($fraction_value, '>', '<');
            if ($fraction) {
                $fraction_value = trim($fraction);
            } else {
                $fraction_value = trim($fraction_value);
            }

            ?>
            <tr>
                <td><?php echo $fraction_name ?></td>
                <td><?php echo $fraction_value ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
//    print_r($fraction_table2[1]);
//    echo "<hr>";
//    $fraction = substr_between($fraction_table2[1][0],'>','<');
//    if($fraction){
//        echo $fraction;
//    }else{
//        echo $fraction_table2[1][0];
//    }
//preg_match_all('/>([\s\S]*?)</', $fraction_table2[1][2], $fraction);//分数
//print_r($fraction[1][0]);

}

//匹配字符串方法
function substr_between($string, $start, $end = null)
{
    if (($start_pos = strpos($string, $start)) !== false) {
        if ($end) {
            if (($end_pos = strpos($string, $end, $start_pos + strlen($start))) !== false) {
                return substr($string, $start_pos + strlen($start), $end_pos - ($start_pos + strlen($start)));
            }
        } else {
            return substr($string, $start_pos);
        }
    }
    return false;
}