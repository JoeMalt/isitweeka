<?php
 //This page performs a lookup for a given date, so we can't use get_status.php. It's feeding user input to the DB, so all input must be thouroughly sanitized.


//Fetch the data from GET, and typecast it to an integer for security.
$day = (integer) $_GET['day'];
$month = (integer) $_GET['month'];
$year = (integer) $_GET['year'];

//Check all data is present and bail with code xi (error-input) if not

if(!$day || !$month)
{
    echo "xi";
    die();
}
if(!$year)
{
  $year = date("Y ");
}

//Connect to the database
define("DB_SERVER","db414520808.db.1and1.com");
define("DB_USERNAME","dbo414520808");
define("DB_PASSWORD","MinstrelsCare88");
define("DB_NAME","db414520808");
$db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

$stmt = $db->prepare("SELECT isitweeka FROM isitweeka WHERE year = ? AND month = ? AND day = ?");
$stmt->bind_param("iii",$year,$month,$day);
$stmt->bind_result($status);
$stmt->execute();
$stmt->fetch();
echo $status;
?>
