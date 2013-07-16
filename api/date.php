<?php
 //This page performs a lookup for a given date, so we can't use get_status.php. It's feeding user input to the DB, so all input must be thouroughly sanitized.

//this takes an input integer and a maximum integer (days of month) and returns code xi if the input is larger

function checkDays($input, $max)
{
      if ($input > $max) //Is the input greater than the maximum amount of days allowed?
            {
                  echo "xi";
                  die();
            }
}


//Fetch the data from GET, and typecast it to an integer for security.
$day = (integer) $_GET['day'];
$month = (integer) $_GET['month'];
$year = (integer) $_GET['year'];

//Check all data is present and bail with code xi (error-input) if not
if (!$year || !$month || !$day)
{
    echo "xi";
    die();
}

//now let's just check that we actually do have a month like this, and that the day exists
switch($month){
    case 1:
    case 3:
    case 5:
    case 7:
    case 8:
    case 10:
    case 12:
          checkDays($day, 31);
          break;
    case 4:
    case 6:
    case 9:
    case 11:
          checkDays($day, 30);
          break;
    case 2: //February... It's not easy
          if (date('L'))
          {
               $feb = 29;
          }
          else
          {
               $feb = 28;
          }
          checkDays($day, $feb);
          break;
     default:
           die("month day error");
}

//Connect to the database
include '../settings.php';
$db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

$stmt = $db->prepare("SELECT isitweeka FROM isitweeka WHERE year = ? AND month = ? AND day = ?");
$stmt->bind_param("iii",$year,$month,$day);
$stmt->bind_result($status);
$stmt->execute();
$stmt->fetch();
echo $status;
?>
