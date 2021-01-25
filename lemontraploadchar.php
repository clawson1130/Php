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
<LoadCharacter>
	<sucess>false</sucess>
	<error>type something</error>
	<tint></tint>
	<nose></nose>
	<mouth></mouth>
	<eyes></eyes>
	<eyebrows></eyebrows>
	<face></face>
	<menhair></menhair>
	<womenhair></womenhair>
	<haircolor></haircolor>
	<pants></pants>
	<pantsbottom></pantsbottom>
	<pantscolor></pantscolor>
	<shoes></shoes>
	<shoescolor></shoescolor>
	<shirts></shirts>
	<shirtssides></shirtssides>
	<shirtscolor></shirtscolor>
</LoadCharacter>
XML;

$xml = new SimpleXMLElement($xmlstr);
//echo $xml->asXML();

$user =  $_GET['user'];
$key = $_GET['key'];


$characterCount =0;
$format ="SELECT COUNT(*)c FROM `Design` WHERE (`user`='%s' AND `key`='%s')";
$query = sprintf($format,$user,$key);

if(!$results = $dbhandle->query($query))
{
	$xml->error ='Failed to Query the database';
	//echo $xml->asXML();
	echo htmlentities($xml->asXML());
	exit();
}

while($row = mysqli_fetch_assoc($results))
{
	$characterCount = $row['c'];
}

if($characterCount<1)
{
	$xml->error ='Could not find character in database';
	//echo $xml->asXML();
	echo htmlentities($xml->asXML());
	exit();
}

$format ="SELECT * FROM `Design` WHERE (`user`='%s' AND `key`='%s')";
$query = sprintf($format,$user,$key);


if(!$results = $dbhandle->query($query))
{
	$xml->error ='Failed to Query the database';
	//echo $xml->asXML();
	echo htmlentities($xml->asXML());
	exit();
}


while($row = mysqli_fetch_assoc($results))
{
	$xml->tint= $row['tint'];
	$xml->nose= $row['nose'];
	$xml->mouth= $row['mouth'];
	$xml->eyes= $row['eyes'];
	$xml->eyebrows= $row['eyebrows'];
	$xml->face= $row['face'];
	$xml->menhair= $row['menhair'];
	$xml->womenhair= $row['womenhair'];
	$xml->haircolor= $row['haircolor'];
	$xml->pants= $row['pants'];
	$xml->pantsbottom= $row['pantsbottom'];
	$xml->pantscolor= $row['pantscolor'];
	$xml->shoes= $row['shoes'];
	$xml->shoescolor= $row['shoescolor'];
	$xml->shirts= $row['shirts'];
	$xml->shirtssides= $row['shirtssides'];
	$xml->shirtscolor= $row['shirtscolor'];

	$xml->error ='';
	$xml->sucess='true';
	echo htmlentities($xml->asXML());
	exit();

}

?>