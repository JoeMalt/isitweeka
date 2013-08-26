<?php

date_default_timezone_set("Europe/London");

require 'data.php';
$year = date("Y");
$month = date("n");
$day = date("j");

$data = getData($year, $month, $day);




if ($data == false) //getData() returns false on a variety of errors
{
	$message = "An error has occurred.";
}
else //Check for override messages, if none are present, then generate the right text
{
	if ($data['override_message'] != false)
	{
		$message = $data['override_message'];
	}
	else
	{
		$message = codeToDisplayText($data['abw2']);
	}
}

//Bulletin messages are handled in inline PHP inside the <span>

//Generate the string for display in the top-left of the hero-unit. Credit for this line to Matthew Else
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
<link rel='stylesheet' href='css/bootstrap.css' />
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

<div class='hero-unit' style='margin-top: 8%'>
	<p style='float: left'><?php echo $datestring; ?></p><p style='float: right'>
		<?php
			//Code to display the bulletin if applicable
			if ($data['bulletin'] != false)
			{
				if ($data['bulletin']['type'] == 'bulletin_blue')
				{
					echo <<<EOT
					<span class='label label-info' style='font-size: 1.0em'>{$data['bulletin']['message']}</span>
EOT;
				}
				elseif ($data['bulletin']['type'] == 'bulletin_red')
				{
					echo <<<EOT
					<span class='label label-important' style='font-size: 1.0em'>{$data['bulletin']['message']}</span>
EOT;
				}
			}
		?>
	</p>
	<br /><br />
	<h1 style='text-align: center'><?php echo $message; ?></h1><br />
</div>

</div></body>
</html>
