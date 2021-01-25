<?php


$dbhandle = new mysqli("localhost", "user", "pass","Game");

$error_text = "";

if ($dbhandle->maxdb_connect_errno)
{
	die("failed");
}


$xmlstr =<<<XML
<?xml version='1.0' standalone='yes' ?>
<RegisterResults>
	<sucess>false</sucess>
	<error>type something</error>
</RegisterResults>
XML;

$xml = new SimpleXMLElement($xmlstr);
//echo $xml->asXML();



/* @var $user type */
$user =  $_GET['user'];
$pass = $_GET['pass'];
$mail = $_GET['mail'];
$key = $_GET['key'];
$money = 0;


$format ="SELECT COUNT(*)c FROM Acc WHERE mail='%s'";
$query = sprintf($format,$mail);
$mailCount =0;
//echo $query;
if(!$results = $dbhandle->query($query))
{
	$xml->error ='Failed to Query the database';
	//echo $xml->asXML();
	echo htmlentities($xml->asXML());
	exit();
}
while($row = mysqli_fetch_assoc($results))
{
	$mailCount = $row['c'];
}
if($mailCount >=1)
{
	$results->close();
	$dbhandle->close();
	$xml->error ='The mail provided is already being used';
	//echo $xml->asXML();
	echo htmlentities($xml->asXML());
	exit();
}

$results->free();

$format ="SELECT COUNT(*)c FROM Acc WHERE user='%s'";
$query = sprintf($format,$user);
$results = $dbhandle->query($query);
$userCount =0;
if(!$results = $dbhandle->query($query))
{
	$xml->error ='Failed to Query the database';
	//echo $xml->asXML();
	echo htmlentities($xml->asXML());
	exit();
}
while($row = mysqli_fetch_assoc($results))
{
	$userCount = $row['c'];
}
if($userCount >=1)
{
	$results->close();
	$dbhandle->close();
	$xml->error ='The user is already being used. Please choose a different one';
	//echo $xml->asXML();
	echo htmlentities($xml->asXML());
	exit();
}


$results->free();


$format = "INSERT INTO `Acc` (`pass`,`user`,`mail`,`key`,`money`) VALUES ('%s','%s','%s','%s',%d)";

$query = sprintf($format,$pass,$user,$mail,$key,$money);

if(!$results = $dbhandle->query($query))
{ 
	$xml->error ='Failed to Query the database';
	//echo $xml->asXML();
	echo htmlentities($xml->asXML());
	exit();
}
else
{
	$xml->sucess = 'true';
	$xml->error = '';
	echo htmlentities($xml->asXML());
}


//$results->free();

exit();
?>