<?php 
    require("config.php");
	if (isset($_POST['user'])) {
		
		$query = " 
            SELECT 
                count(*) as num                
            FROM useraccount 
            WHERE 
                username = ?
        ";
		
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $_POST['user']);
        $stmt->execute();
        $stmt->bind_result($num);
        $stmt->fetch();
        $stmt->close();
		
		$username = $_POST['user'];
		
		if($num>0)
		{
			echo "Yes";
		}
		else
		{
			echo "No";
		}
	}
?>