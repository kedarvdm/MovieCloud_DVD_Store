<?php
require("config.php");
if(isset($_GET["orderid"]))
{
	$orderid=$_GET['orderid'];
	$return_url = base64_decode($_GET["return_url"]); //return url
		if($orderid>0)
		{	
			$status="Shipped";
			$query = "UPDATE orders set orderstatus=? where hmy=?";
			$stmt = $db->prepare($query);
			$stmt->bind_param('sd',$status,$orderid);
			$stmt->execute();
			$stmt->close();
			header('Location:'.$return_url);
		}
}
?>
