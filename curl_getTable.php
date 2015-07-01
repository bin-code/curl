<?php
/**
 * Created by PhpStorm.
 * User: lwb
 * Date: 2015/3/10
 * Time: 1:48
 */
function getTable($table)
{
    preg_match_all('/<th[^>]*>(.*)<\/th>/', $table, $tabhead);//表头
//print_r($tabhead[1]);
//echo "<hr>";
    preg_match_all('/<tr class[^>]*>([\s\S]*?)<\/tr>/', $table, $tabbody);//主体
//print_r($tabbody[1]);
//echo "<hr>";
    preg_match_all('/<td[^>]*>(.*)<\/td>/', $tabbody[1][0], $tabtd);
//print_r($tabtd[1]);
//    $tmp=0;
    ?>

    <table width="100%" border="1">
        <thead>
        <tr>
            <?php
            for ($i = 0; $i < count($tabhead[1]); $i++) {
                $class_name = trim($tabhead[1][$i]);
                if($class_name == "先修课程"){
                    $tmp=$i;
                }
                ?>
                <th><?php echo $class_name ?></th>
            <?php
            }
            ?>
        </tr>
        <thead>
        <tbody>
        <?php
        for ($m = 0; $m < count($tabbody[1]); $m++) {
            preg_match_all('/<td[^>]*>(.*)<\/td>/', $tabbody[1][$m], $tabtd);
            ?>
            <tr>
                <!--            <td>--><?php //echo $m+1 ?><!--</td>-->
                <?php

                for ($i = 0; $i < count($tabtd[1]); $i++) {
//        $menu_id = $i+1;
                    $class_value = trim($tabtd[1][$i]);
                    if ($i == $tmp) {
                        $class_value = "略";
                    }
                    ?>
                    <td><?php echo $class_value ?></td>
                <?php
                }
                ?>
            </tr>

        <?php
        }
        ?>
        </tbody>
    </table>
<?php
}