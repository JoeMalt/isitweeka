<?php
error_reporting(E_ALL);

/*
 * Returns an array of data including w/a/b, weekend with next week, and override messages
 * Returns FALSE on error
 */
 
function getData($year, $month, $day)
{
	
	//Initial setup
	$return = array(); //This holds all the data that will be returned
	
	$mysql_date = $year . "-" . $month . "-" . $day;
	
	
	//Connect to the database
	include "settings.php";

	$db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
	if(!$db)
	{
		return false;
	}
	
	
	//Query #1
	$result = $db->query("SELECT * FROM `isitweeka` WHERE date = \"$mysql_date\"");
	$row = $result->fetch_assoc();
	$return['abw'] = $row['isitweeka'];
	
	//Query #2
	//If it's the weekend, check what the value is in 48 hours' time to see what's coming up
	//At the weekend, Monday is never more than 48 hrs away, so add 2 days with MySQL's internal date_add() function
	if ($return['abw'] == "w")
	{

	    //Now run the query
		$result = $db->query("SELECT * FROM isitweeka WHERE date = DATE_ADD(\"$mysql_date\", INTERVAL 2 DAY)");
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
	
	$result = $db->query("SELECT * FROM isitweeka_messages WHERE start_date <= \"$mysql_date\" AND end_date >= \"$mysql_date\"");
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
