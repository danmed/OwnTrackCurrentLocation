<?PHP
/* MYSQL Configuration */
$DBServer	= 	'192.168.2.75';
$DBName    	 = 	'maps';
$DBUser		= 	'kodi';
$DBPassword     = 	'kodi';
$db_handle = mysqli_connect($DBServer, $DBUser, $DBPassword);
$db_found = mysqli_select_db($db_handle, $DBName);

/* Get location of users */
/* Dan - TID = DM */
if ($db_found) 
{
$dm_sql = "select * from dan_locations order by dt desc";
$dm_result = mysqli_query($db_handle, $dm_sql);

$lm_sql = "select * from laura_locations order by dt desc";
$lm_result = mysqli_query($db_handle, $lm_sql);
}
?>
