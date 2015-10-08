<?php
	if(!empty($_POST)){
    ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);
	require("config.php");
	
	$submitted_username = ''; 
         
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
        $row=$stmt->fetch();
        $stmt->close();
		
		
        $login_ok = false; 
        $check_password = $_POST['password'];
         
        if($check_password === $pwd){
            $login_ok = true;
        } 
         
 
        if($login_ok){ 
            unset($row['password']); 
			$_SESSION['user'] = $name;
			$_SESSION['userid'] = $id;	
			if($_POST['username']=='admin')
			{
				header("Location: adminhome.php"); 
			}
			else
			{
				header("Location: BrowseDVDs.php"); 
			}
            die("Redirecting to: registration.php"); 
        } 
        else{
			$submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); 		
            header("Location: loginfailed.php"); 
            die("Redirecting to: loginfailed.php"); 
        } 
    }
	
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>MovieCloud</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSS -->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body>

        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="logo span4">
                        <h1>MovieCloud <span class="red">.</span></h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="register-container container">
            <div class="row">
                <div class="register span6">
                    <form action="" method="post">
                        <h2><span class="red"><strong>MovieCloud</strong></span></h2>
                        <label for="username">User Name</label>
                        <input type="text" id="username" name="username" placeholder="User Name">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Password">
                        <button type="submit">Login</button>
						<label>Not Registered? <a href="registration.php" class="">Register here</a></label>
                    </form>
					
                </div>
				
            </div>
        </div>

        <!-- Javascript -->
        <script src="assets/js/jquery-1.8.2.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>

    </body>

</html>

