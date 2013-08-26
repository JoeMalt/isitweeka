<?php
include '../data.php';

$year = date("Y");
$month = date("n");
$day = date("j");

$data = getData($year, $month, $day);

echo $data['abw2'];
?>
