<?php
$include_addtocount = TRUE;
include 'addtocount.php';
require 'get_status.php';
switch($status)
{
    case "a":
    $message = "It's Week A";
    break;
    case "b":
    $message = "It's Week B";
    break;
    case "wa":
    $message = "It's the weekend, and next week will be Week A";
    break;
    case "wb":
    $message = "It's the weekend, and next week will be Week B";
    break;
    case "h":
    $message = "It's the holidays!";
}
$message = (isset($extra_message) ? $extra_message : $message);

$datestring = date("l, j F, Y");
?>

<!DOCTYPE html>
<html><head><title>KECHB: Is It Week A?</title>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-37092961-1']);
  _gaq.push(['_setDomainName', 'isitweeka.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/bootstrap.min.js"></script>
<link rel='stylesheet' href='css/bootstrap.min.css' />
</head>

<body><div class='container' <?php echo ((isset($_GET['comicsans']) && $_GET['comicsans'] == TRUE)  ? "style='font-family: Comic Sans, Comic Sans MS, Chalkboard, Chalkboard SE'" : "")?>>


    <div class="navbar">
    <div class="navbar-inner">
    <a class="brand" href="#">KECHB: IsItWeekA.com</a>
    <ul class="nav">
    <li <?php echo ((isset($_GET['comicsans']) && $_GET['comicsans'] == TRUE)  ? "" : "class='active'")?>><a href="index.php">Home</a></li>
    <li><a href="about.php">About</a></li>
    <li <?php echo ((isset($_GET['comicsans']) && $_GET['comicsans'] == TRUE)  ? "class='active'" : "")?>><a href="index.php?comicsans=1">Comic Sans mode</a></li>
    </ul>
    </div>
</div>

<div class='hero-unit' style='margin-top: 8%;'><p><?php echo $datestring ?></p><span style="text-align: center"><h1><?php echo $message; ?></h1></span></div>

</div></body>
</html>
