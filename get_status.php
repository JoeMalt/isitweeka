<?php

//Connect to the database
include 'settings.php';
$db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
$year = date("Y");
$month = date("n");
$day = date("j");

$result = $db->query("SELECT * FROM isitweeka WHERE year = $year AND month = $month AND day = $day");

$row = $result->fetch_assoc();
//Set $status to the status code
$status = $row[isitweeka];

//If it's the weekend, add on 48 hours and rerun the query to determine what week it will be next.
//All variables for this code are prefixed with f_ for clarity
if ($status == "w")
{
    //echo "In the weekend alteration block";
    $f_time = time();
    $f_time = $f_time + 200000;
    $f_year = date("Y",$f_time);
    $f_month = date("n",$f_time);
    $f_day = date("j",$f_time);
    $f_result = $db->query("SELECT * FROM isitweeka WHERE year = $f_year AND month = $f_month AND day = $f_day");
    $f_row = $f_result->fetch_assoc();
    $f_status = $f_row[isitweeka];
    if ($f_status == "a")
    {
        $status = "wa";
    }
    elseif ($f_status == "b")
    {
        $status = "wb";
    }
    elseif ($f_status == "h")
    {
        $status = "wh";
    }
    else
    {
        $status = "wx";
    }
}

        
?>
