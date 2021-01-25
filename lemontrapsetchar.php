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
</LoadCharacter>
XML;

$xml = new SimpleXMLElement($xmlstr);
//echo $xml->asXML();

$user =  $_GET['user'];
$key = $_GET['key'];
$sex = $_GET['sex'];
$combined = $_GET['combined'];

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
$combinedarray = array();

$previousindex=-1;
for ($i = 0; $i < strlen($combined); $i++)
{

   if($combined[$i]==",")
   {
   	 if($i==1)
   	 {
   	 	$currentsubstring = substr($combined, $previousindex+1, 1);
   	 }
   	 else
   	 {
   	 	$currentsubstring = substr($combined, $previousindex+1, $i-($previousindex+1));  	 
   	 }
   	 array_push($combinedarray, intval($currentsubstring));
   	 $previousindex = $i;
   }
} 


if($characterCount>=1)
{
	$format = "UPDATE `Design` SET `tint`=%d, `nose`=%d, `mouth`=%d, `eyes`=%d, `eyebrows`=%d, `face`=%d, `menhair`=%d, `womenhair`=%d, `haircolor`=%d, `pants`=%d, `pantsbottom`=%d, `pantscolor`=%d, `shoes`=%d, `shoescolor`=%d, `shirts`=%d, `shirtssides`=%d, `shirtscolor`=%d WHERE (`user`='%s' AND `key`='%s')";
	$query = sprintf($format,$combinedarray[0],$combinedarray[1],$combinedarray[2],$combinedarray[3],$combinedarray[4],$combinedarray[5],$combinedarray[6],$combinedarray[7],$combinedarray[8],$combinedarray[9],$combinedarray[10],$combinedarray[11],$combinedarray[12],$combinedarray[13],$combinedarray[14],$combinedarray[15],$combinedarray[16],$user,$key);

}
else
{
	$format = "INSERT INTO `Design` (`user`,`key`,`sex`,`tint`,`nose`,`mouth`,`eyes`,`eyebrows`,`face`,`menhair`,`womenhair`,`haircolor`,`pants`,`pantsbottom`,`pantscolor`,`shoes`,`shoescolor`,`shirts`,`shirtssides`,`shirtscolor`) VALUES ('%s','%s','%s',%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d)";
	$query = sprintf($format,$user,$key,$sex,$combinedarray[0],$combinedarray[1],$combinedarray[2],$combinedarray[3],$combinedarray[4],$combinedarray[5],$combinedarray[6],$combinedarray[7],$combinedarray[8],$combinedarray[9],$combinedarray[10],$combinedarray[11],$combinedarray[12],$combinedarray[13],$combinedarray[14],$combinedarray[15],$combinedarray[16]);
}
if(!$results = $dbhandle->query($query))
{
	$xml->error ='Failed to Query the database';
	//echo $xml->asXML();
	echo htmlentities($xml->asXML());
	exit();
}
else
{
	$xml->error ='';
	$xml->sucess ='true';
	echo htmlentities($xml->asXML());
	exit();
}

?>