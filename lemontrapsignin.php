<?php 

$dbhandle = new mysqli("localhost", "user", "pass","Game");

$error_text = "";

if ($dbhandle->maxdb_connect_errno)
{
	$error_text ="Failed to connect to Database";
	die($error_text);
}


$xmlstr =<<<XML
<?xml version='1.0' standalone='yes' ?>
<SignInInformation>
	<sucess>false</sucess>
	<error>type something</error>
	<user></user>
	<key></key>
	<money></money>
</SignInInformation>
XML;

$xml = new SimpleXMLElement($xmlstr);
//echo $xml->asXML();

$user =  $_GET['user'];
$pass = $_GET['pass'];
$mail = $_GET['mail'];


$format ="SELECT * FROM `Acc` WHERE (mail='%s' AND pass='%s') OR (user='%s' AND pass='%s')";
$query = sprintf($format,$mail,$pass,$user,$pass);


if(!$results = $dbhandle->query($query))
{
	$xml->error ='Failed to Query the database';
	//echo $xml->asXML();
	echo htmlentities($xml->asXML());
	exit();
}
while($row = mysqli_fetch_assoc($results))
{
	$xml->sucess = 'true';
	$xml->user= $row['user'];
	$xml->key = $row['key'];
	$xml->money = $row['money'];
	echo htmlentities($xml->asXML());
	exit();
}
$xml->error = 'Did not find log in credentials in the database. Please try again?';
echo htmlentities($xml->asXML());
exit();

?>s