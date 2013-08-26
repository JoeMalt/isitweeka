<?php
error_reporting(E_ALL);

/*
 * Returns an array of data including w/a/b, weekend with next week, and override messages
 * Returns FALSE on error
 */
function getData($year, $month, $day)
{
	$return = array();
	//Connect to the database
	include "settings.php";

	$db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
	if(!$db)
	{
		return false;
	}
	
	
	//Query #1
	$result = $db->query("SELECT * FROM `isitweeka` WHERE year = $year AND month = $month AND day = $day");
	$row = $result->fetch_assoc();
	$return['abw'] = $row['isitweeka'];
	
	//Query #2
	if ($return['abw'] == "w")
	{
		//Get the date in two days time
		//Store it in $return['abw2'] as wa, wb etc.
		//Going via Unix time - ugly but functional
		$time = mktime(12, 0, 0, $month, $day, $year);

		//Fast forward two days
		//f_ means "future" - refers to 2 days ahead
		$f_time = $time + 172800;
		//Now get the ymd values for this timestamp
	    $f_year = date("Y",$f_time);
	    $f_month = date("n",$f_time);
	    $f_day = date("j",$f_time);
	    
	    //Now run the query
		$result = $db->query("SELECT * FROM isitweeka WHERE year = $f_year AND month = $f_month AND day = $f_day");
		$row = $result->fetch_assoc();
		$abw = $row['isitweeka'];
		switch($abw)
		{
			case "a":
			$return['abw2'] = "wa";
			break;
			case "b":
			$return['abw2'] = "wb";
			break;
			case "h":
			$return['abw2'] = "wh";
			break;
		}
	}
	else
	{
		$return['abw2'] = $return['abw'];
	}
	
	
	//Query #3: additional messages (may be bulletins or overrides)
	$result = $db->query("SELECT * FROM isitweeka_messages WHERE year = $year AND month = $month AND day = $day");
	if(!$result)
	{
	    return false;
	}

	
	$return['bulletin'] = false;
	$return['override_message'] = false;
	
	//Loop through the data and apply the correct messages to $return
	if($result->num_rows > 0)
	{
		while(true)
		{
			$row = $result->fetch_assoc();
			if ($row == null)
			{
				break;
			}
			if ($row['type'] == "override")
			{
				$return['override_message'] = $row['message'];
			}
			elseif ($row['type'] == "bulletin_red")
			{
				$return['bulletin']['type'] = "bulletin_red";
				$return['bulletin']['message'] = $row['message'];
			}
			else
			{
				$return['bulletin']['type'] = "bulletin_blue";
				$return['bulletin']['message'] = $row['message'];
			}
		}
				
	}
		
	
	return $return;
}

function codeToDisplayText($code)
{
	switch($code)
	{
		case "a":
		$text = "It's Week A";
		break;
		case "b":
		$text = "It's Week B";
		break;
		case "wa":
		$text = "It's the weekend, and next week will be Week A";
		break;
		case "wb":
		$text = "It's the weekend, and next week will be Week B";
		break;
		case "wh":
		$text = "It's the weekend, and next week will be the holidays!";
		break;
		case "h":
		$text = "It's the holidays!";
		break;
		default:
		$text = "Error";
	}
	return $text;
}
