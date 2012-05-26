<?php
if ($_SERVER['REMOTE_ADDR'] != "94.173.128.254" && $_GET['beta_ack'] != TRUE)
{
    header("Location: http://www.isitweeka.com/beta.php");
}
include 'get_status.php';
        
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
<head><title>KECHB: Is It Week A?</title><link rel='stylesheet' content-type='text/css' href='style.css' /></head>
<body>
<!--<div id='container'>-->
<div id='topbanner' class='bigtext'>KECHB: Is It Week A?</div>
<br />
<!-- Open the main div -->
<div id='main'>

<!-- The date in the top-left of the main div is in span id main_lead -->

<div id='main_lead'>
<?php
$day_name = date("l");
$month_name = date("F");
echo "$day_name, $month_name $day, $year";
?>
</div>


<br /><br />

<div id='main_center' class='bigtext'>
<?php

switch($status)
{
    case "a":
    echo "It's Week A";
    break;
    case "b":
    echo "It's Week B";
    break;
    case "wa":
    echo "It's the weekend, and the coming week will be Week A";
    break;
    case "wb":
    echo "It's the weekend, and the coming week will be Week B";
    break;
    case "h":
    echo "It's the holidays!";
    break;
    default:
    echo "Error";
    break;
}
?>
</div>

</div>
<br />
<?php
//require'lookup_form.php';
?>
<div id='footer'>This site is in no way affiliated with the original IsItWeekA.com, which is run by the Pupils' Voice and does not appear to be updated any longer. <a href='about.php'>About</a></div>
<!--</div>-->
</body>
</html>

