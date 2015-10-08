<?php
require("config.php");


//add item in shopping cart
if(isset($_GET["type"]) && $_GET["type"]=='delete')
{
	$dvd_code 	= filter_var($_GET["dvd_code"], FILTER_SANITIZE_STRING); //product code
	$return_url 	= base64_decode($_GET["return_url"]); //return url
	
	//MySqli query - get details of item from db using dvd code
	$results = $db->query("SELECT hmy,title,price FROM dvdinfo WHERE hMy='$dvd_code' LIMIT 1");
	$obj = $results->fetch_object();
	
	if ($results) { 
		
		$db->query("Delete from dvdinventory where hDVDInfo='$dvd_code'");
		$db->query("Delete from dvdinfo where hMy='$dvd_code'");		
	}
	
	//redirect back to original page
	header('Location:'.$return_url);
}

//remove item from shopping cart
if(isset($_GET["removep"]) && isset($_GET["return_url"]) && isset($_SESSION["products"]))
{
	$dvd_code 	= $_GET["removep"]; //get the dvd code to remove
	$return_url 	= base64_decode($_GET["return_url"]); //get return url

	
	foreach ($_SESSION["products"] as $cart_itm) //loop through session array var
	{
		if($cart_itm["code"]!=$dvd_code){ //item does,t exist in the list
			$product[] = array('name'=>$cart_itm["name"], 'code'=>$cart_itm["code"],'price'=>$cart_itm["price"]);
		}
		
		//create a new product list for cart
		$_SESSION["products"] = $product;
	}
	
	//redirect back to original page
	header('Location:'.$return_url);
}
?>