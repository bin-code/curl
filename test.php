<?php
if (preg_match("/(错误)/", "系123123213统213错123213系统错误提示", $matches)) {
    print_r($matches);
} else {
    echo "$test_name: no redirection\n";
}