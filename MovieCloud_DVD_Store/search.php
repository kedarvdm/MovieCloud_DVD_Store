<?php
	require("config.php");
	$title=$_POST["title"];
 
	$query = " 
		SELECT 
			d.hMy, 
			d.title, 
			d.cast, 
			d.intro,
			d.releasedate,
			d.imagepath,
			d.price
		FROM dvdinfo d 
		WHERE d.title like '$title%' ";
		
		$rs = $db->query($query, MYSQLI_STORE_RESULT);
 
 if($rs){
		while($row = $rs->fetch_assoc()){
		echo '<p><a href=viewmovie.php?dvd_code='.$row['hMy'].'>'.$row['title'].'</a></p>';
		}   
	}
?>