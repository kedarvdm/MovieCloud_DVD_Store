<?php
	if(!empty($_POST)){
    ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);
	require("config.php");
	
	// Ensure that the user fills out fields
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
	{ die("Invalid E-Mail Address"); } 
	
	//Get all the variables
	$firstname=$_POST['firstname'];
	$lastname=$_POST['lastname'];
	$address1=$_POST['address1'];
	$address2=$_POST['address2'];
	$city=$_POST['city'];
	$state=$_POST['state'];
	$country=$_POST['country'];
	$zip=$_POST['zip'];
	$birthdate=$_POST['birthdate'];
	$email=$_POST['email'];
	$cellphone=$_POST['cellphone'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	

	$query = " 
		SELECT 
			count(*) as num
		FROM useraccount 
		WHERE 
			username = ? 
	"; 

	$stmt = $db->prepare($query);
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($num);
	$stmt->fetch();
	$stmt->close();
	if($num==0)
	{
		$query = "INSERT into customer (firstname,lastname,address1,address2,city,state,country,zipCode,birthdate,email,cellphone) values(?,?,?,?,?,?,?,?,?,?,?)"; 
		$stmt = $db->prepare($query);
		$stmt->bind_param('sssssssssss',$firstname,$lastname,$address1,$address2,$city,$state,$country,$zip,$birthdate,$email,$cellphone);
		$stmt->execute();
		$newId = $stmt->insert_id;
		if($newId>0)
		{	
			$query = "INSERT into useraccount (hCustomer,userName,password) values(?,?,?)";
			$stmt = $db->prepare($query);
			$stmt->bind_param('dss',$newId,$username,$password);
			$stmt->execute();
			$newId = $db->insert_id;
		}
		$stmt->close();
	}
	
	if($newId>0)
	{
		header("Location: registrationsuccess.php"); 
		die("Redirecting to: registrationsuccess.php"); 
	}
	else
	{
		print("Registration Failed."); 
		$submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); 
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
                        <h1><a href="index.php">MovieCloud <span class="red">.</span></a></h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="register-container container">
            <div class="row">
                <div class="register span10">
                    <form action="" method="post">
                        <h2>REGISTER TO <span class="red"><strong>MovieCloud</strong></span></h2>
						<div class="form-group span4">
                        <label for="firstname">First Name:</label>
						<input type="text" name="firstname" placeholder="First Name" required autofocus>
						</div>
						<div class="form-group span4">
						<label for="lastname">Last Name:</label>
						<input type="text" name="lastname" placeholder="Last Name" required>
						</div>
						<div class="form-group span4">
						<label for="address1">Address 1:</label>
						<input type="text" name="address1" placeholder="Address 1" required>
						</div>
						<div class="form-group span4">
						<label for="address2">Address 2:</label>
						<input type="text" name="address2" placeholder="Address 2">
						</div>
						<div class="form-group span4">
						<label for="city">City:</label>
						<input type="text" name="city" placeholder="City" required>
						</div>
						<div class="form-group span4">
						<label for="state">State:</label>
						<input type="text" name="state" placeholder="State" required>
						</div>
						<div class="form-group span4">
						<label for="country">Country:</label>
						<input type="text" name="country" placeholder="Country" required>
						</div>
						<div class="form-group span4">
						<label for="zip">Zip:</label>
						<input type="text" name="zip" placeholder="Zip" required>
						</div>
						<div class="form-group span5">
							<label for="birthdate">Birth Date:</label>
							<input class="form-control" type="text" name="birthdate" id="dpicker" placeholder="Birth Date" required>
							<span class="glyphicon glyphicon-calendar"></span>
						</div>
						
						<div class="form-group span5">
						<label for="email">Email:</label>
						<input type="email" name="email" placeholder="Email" required>
						</div>
						<div class="form-group span5">
						<label for="cellphone">Cellphone:</label>
						<input type="text" name="cellphone" placeholder="Cellphone" required>
						</div>
						<div class="form-group span5">
						<label for="newusername">Username</label>
                        <input type="text" id="newusername" name="username" placeholder="choose a username..." required>
						</div>
						<div class="form-group span5">
						<label for="newpassword">Password</label>
                        <input type="password" id="newpassword" name="password" placeholder="choose a password..." required>
						</div>
                        <button type="submit">REGISTER</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Javascript >-->
        <script src="assets/js/jquery-1.8.2.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
		<script src="assets/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                
                $('#dpicker').datepicker({
                    format: "dd/mm/yyyy"
                });  
            
            });
        </script>
    </body>

</html>

