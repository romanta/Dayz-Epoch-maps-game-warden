<?php
/*
data-doc.php designed to replace original data.php
Use this as your data.php if you are using my improved vehicle spawns function with the `Landmark` column.
*/
// works with schema 0.27
error_reporting(0);

header('Content-Type: text/plain');
// added to maybe fix cache blowing up to insane size
header('Cache-Control: no-cache, must-revalidate'); // HTTP/1.1
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/ServerCon.php';
$db = new DatabaseConnection();

echo '<stuff>' . "\n";


$res = mysql_query("SELECT
  s.PlayerUID,
	s.Model,
	s.Worldspace,
	s.Inventory,
	s.Humanity,
	p.PlayerName,
	s.Datestamp,
	concat(s.KillsH, ' (', s.KillsH, ')') survivor_kills,
	concat(s.KillsB, ' (', s.KillsB, ')') bandit_kills
FROM
	character_data s
INNER JOIN
	player_data p on p.PlayerUID = s.PlayerUID
WHERE
	s.UpdateTime > DATE_SUB(now(), INTERVAL 5 MINUTE)
AND
	s.Alive = 1
") or die(mysql_error());

while($row = mysql_fetch_assoc($res))
{
	
	$explo_worldspace = $row['Worldspace'];
				
				$explo_worldspace = str_replace('[','',$explo_worldspace);
				$explo_worldspace = str_replace(']','',$explo_worldspace);
				$space = explode(',',$explo_worldspace);
				
	//$res2 = mysql_query("SELECT PlayerName from player_data WHERE PlayerUID = '".$row['PlayerUID']."'");
	//$row2 = mysql_fetch_assoc($res2);	
							
				
	$row['x'] = $space[1];
	$row['y'] = -($space[2]-15365);
	
	$row['age'] = strtotime($row['Datestamp']) - time();
	//$row['name'] = htmlspecialchars($row2['Playername']);
	
	echo "\t" . '<player>' . "\n";
	foreach($row as $k => $v)
	{
		
		switch($k) {
			case "Model": $k = "model"; break;
			case "Alive": $k = "state"; $v = ($v == 1) ? 0 : 1; break;
			case "Worldspace": $k = "worldspace"; break; 
			case "PlayerName": $k = "name"; break;
			case "Humanity": $k = "humanity"; break;
			case "Inventory": $k = "inventory"; break;
			case "Datestamp": $k = "last_updated"; $v = strtotime($v); break;
			case "PlayerUID": $k = "id"; break;
			default: break;
		}
		echo "\t\t" . '<' . $k . '><![CDATA[' . $v . ']]></' . $k . '>' . "\n";
	}
	echo "\t" . '</player>' . "\n";
}
$res = mysql_query("SELECT
	ObjectID,
	ObjectUID,
	Worldspace,
	Classname,
	Inventory,
	Datestamp
FROM
	object_data
WHERE
	Landmark='0' AND Classname != 'dummy' AND Classname != 'TentStorage' AND Classname != 'Hedgehog_DZ' AND Classname != 'Wire_cat1' AND Classname != 'Sandbag1_DZ' AND Classname != 'TrapBear'
") or die(mysql_error());

while($row =mysql_fetch_assoc($res))
{
	$explo_worldspace = $row['Worldspace'];
				
				$explo_worldspace = str_replace('[','',$explo_worldspace);
				$explo_worldspace = str_replace(']','',$explo_worldspace);
				$space = explode(',',$explo_worldspace);
				
				
	$row['x'] = $space[1];
	$row['y'] = -($space[2]-15365);
	
	$row['age'] = strtotime($row['Datestamp']) - time();
	
	echo "\t" . '<vehicle>' . "\n";
	foreach($row as $k => $v)
	{
		switch($k) {
			case "Worldspace": $k = "worldspace"; break; 
			case "Classname": $k = "otype"; break;
			case "Inventory": $k = "inventory"; break;
			case "Datestamp": $k = "last_updated"; $v = round(strtotime($row['Datestamp']) - time()); break;
			case "ObjectID": $k = "id"; break;
			//case "ObjectUID": $k = "world_vehicle_id"; break;
                        case "ObjectUID": $k = false; break;
			default: break;
		}
                if ($k) {
                    echo "\t\t" . '<' . $k . '><![CDATA[' . $v . ']]></' . $k . '>' . "\n";
                }
	}   
	echo "\t" . '</vehicle>' . "\n";
}

$query = mysql_query("SELECT
	ObjectID,
	Worldspace,
	Classname,
	Inventory,
	Datestamp
FROM
	object_data
WHERE
	Landmark='0' AND Classname = 'TentStorage'
") or die(mysql_error());

while($row =mysql_fetch_assoc($query))
{
	$explo_worldspace = $row['Worldspace'];
				
				$explo_worldspace = str_replace('[','',$explo_worldspace);
				$explo_worldspace = str_replace(']','',$explo_worldspace);
				$space = explode(',',$explo_worldspace);
				
				
	$row['x'] = $space[1];
	$row['y'] = -($space[2]-15365);
	
	echo "\t" . '<deployable>' . "\n";
	foreach($row as $k => $v)
	{
		switch($k) {
			case "Worldspace": $k = "worldspace"; break; 
			case "Classname": $k = "otype"; break;
			case "Inventory": $k = "inventory"; break;
			case "Datestamp": $k = "last_updated"; $v = strtotime($v); break;
			case "ObjectID": $k = "id"; break;
			//case "ObjectUID": $k = "world_vehicle_id"; break;
                        case "ObjectUID": $k = false; break;
			default: break;
		}
                if ($k) {
                    echo "\t\t" . '<' . $k . '><![CDATA[' . $v . ']]></' . $k . '>' . "\n";
                }
	}
	echo "\t" . '</deployable>' . "\n";
}

echo '</stuff>' . "\n";

?>
