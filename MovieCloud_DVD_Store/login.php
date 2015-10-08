<?php 
        ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);
	require("config.php");
	
	$submitted_username = ''; 
        if(!empty($_POST)){ 
        $query = " 
            SELECT 
                hMy, 
                username, 
                password                 
            FROM useraccount 
            WHERE 
                username = ?
        ";
	
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->bind_result($id,$name,$pwd);
        $stmt->fetch();
        $stmt->close();

        $login_ok = false; 
        $check_password = $_POST['password'];
         
        if($check_password === $pwd){
            $login_ok = true;
        } 
         
 
        if($login_ok){ 
            unset($pwd); 
            $_SESSION['user'] = $row;  
            header("Location: registration.php"); 
            die("Redirecting to: registration.php"); 
        } 
        else{ 
            print("Login Failed."); 
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); 
        } 
    } 
?> 