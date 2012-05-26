<?php

//Connect to the database
define("DB_SERVER","db414520808.db.1and1.com");
define("DB_USERNAME","dbo414520808");
define("DB_PASSWORD","MinstrelsCare88");
define("DB_NAME","db414520808");
$db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
if (!$db) {
    die("MySQL Connection Error");
}

$result = $db->query("SELECT * FROM isitweeka_events ORDER BY year, month, day");
?>
<div id='events_feed'>
<table>
<?php
while ($row = $result->fetch_assoc())
{
    echo "<tr>";
    echo "<td>";
    echo $row[year];
    echo "</td>";
    echo "<td>";
    echo $row[month];
    echo "</td>";
    echo "<td>";
    echo $row[day];
    echo "</td>";
    echo "<td>";
    echo $row[text];
    echo "</td>";
    echo "</tr>";
}
?>
</table>
</div>

