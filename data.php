<?php
// works with schema 0.27
error_reporting(0);

header('Content-Type: text/plain');
// added to maybe fix cache blowing up to insane size
header('Cache-Control: no-cache, must-revalidate'); // HTTP/1.1
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past

require_once 'config.php';
$db = new DatabaseConnection();

echo '<stuff>' . "\n";


$res = mysql_query("SELECT
  s.PlayerUID,
	s.Model,
	s.Worldspace,
	s.Inventory,
	s.Humanity,
	p.PlayerName,
	s.lastactiv,
	concat(s.KillsH, ' (', s.KillsH, ')') survivor_kills,
	concat(s.KillsB, ' (', s.KillsB, ')') bandit_kills
FROM
	character_data s
INNER JOIN
	player_data p on p.PlayerUID = s.PlayerUID
WHERE
	s.lastactiv > DATE_SUB(now(), INTERVAL 1 MINUTE)
AND
	s.Alive = 1")
	or die(mysql_error());

while($row = mysql_fetch_assoc($res))
{
	
	$explo_worldspace = $row['Worldspace'];
				
				$explo_worldspace = str_replace('[','',$explo_worldspace);
				$explo_worldspace = str_replace(']','',$explo_worldspace);
				$space = explode(',',$explo_worldspace);
				
				
	$row['x'] = $space[1];
	$row['y'] = -($space[2]-15365);
	
	$row['age'] = strtotime($row['lastactiv']) - time();
	
	echo "\t" . '<player>' . "\n";
	foreach($row as $k => $v)
	{
		
		switch($k) {
			case "PlayerUID": $k = "id"; break;
			case "Model": $k = "model"; break;
			case "Alive": $k = "state"; $v = ($v == 1) ? 0 : 1; break;
			case "Worldspace": $k = "worldspace"; break; 
			case "Inventory": $k = "inventory"; break;
			case "PlayerName": $k = "name"; break;
			case "Humanity": $k = "humanity"; break;
			case "lastactiv": $k = "last_updated"; $v = strtotime($v); break;
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
	Classname != 'dummy' AND Classname != 'TentStorage' AND Classname != 'small_house_lvl_2' AND Classname != 'large_shed_lvl_1' AND Classname != 'small_garage'  AND Classname != 'wooden_shed_lvl_1'  AND Classname != 'Wire_cat1' AND Classname != 'big_house_lvl_3' AND Classname != 'big_garage' AND Classname != 'TrapBear'
") or die(mysql_error());

while($row = mysql_fetch_assoc($res))
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
			case "ObjectID": $k = "id"; break;
			case "Worldspace": $k = "worldspace"; break; 
			case "Classname": $k = "otype"; break;
			case "Inventory": $k = "inventory"; break;
			case "Datestamp": $k = "last_updated"; $v = round(strtotime($row['Datestamp']) - time()); break;
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
	Classname = 'TentStorage'
") or die(mysql_error());

while($row = mysql_fetch_assoc($query))
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

$query = mysql_query("SELECT
	ObjectID,
	Worldspace,
	Classname,
	Inventory,
	Datestamp
FROM
	object_data
WHERE
	Classname = 'Mi17_DZ'
") or die(mysql_error());

while($row = mysql_fetch_assoc($query))
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

$query = mysql_query("SELECT
	ObjectID,
	Worldspace,
	Classname,
	Inventory,
	Datestamp
FROM
	object_data
WHERE
	Classname = 'UH60M_EP1_DZ'
") or die(mysql_error());

while($row = mysql_fetch_assoc($query))
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

$query = mysql_query("SELECT
	ObjectID,
	Worldspace,
	Classname,
	Inventory,
	Datestamp
FROM
	object_data
WHERE
	Classname = 'CH_47F_EP1_DZ'
") or die(mysql_error());

while($row = mysql_fetch_assoc($query))
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

$query = mysql_query("SELECT
	ObjectID,
	Worldspace,
	Classname,
	Inventory,
	Datestamp
FROM
	object_data
WHERE
	Classname = 'MH60S'
") or die(mysql_error());

while($row = mysql_fetch_assoc($query))
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

$query = mysql_query("SELECT
	ObjectID,
	Worldspace,
	Classname,
	Inventory,
	Datestamp
FROM
	object_data
WHERE
	Classname = 'big_garage'
") or die(mysql_error());

while($row = mysql_fetch_assoc($query))
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
