<?php
$include_addtocount ? : die("This file is include only");

$current = file_get_contents("visits.txt");

if($_SERVER['REMOTE_ADDR'] != "94.173.128.254") //Hard-code my IP address
{
    $current = $current + 1;
}
file_put_contents("visits.txt", $current);

?>
