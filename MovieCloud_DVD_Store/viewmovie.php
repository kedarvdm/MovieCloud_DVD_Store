<?php

	require("config.php");

	if(isset($_GET["dvd_code"]))
	{
		$dvd_code=$_GET["dvd_code"];
	
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
		WHERE d.hmy=".$dvd_code;
		
		$results = $db->query($query);
		$obj = $results->fetch_object();
	}
	$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
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
                        <h1><a href="browsedvds.php">MovieCloud <span class="red">.</span></a></h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="register-container container">
		
				<div class="row">
					<div class="register span12">
						<div class="bsnavbar">
							<nav class="navbar navbar-default" role="navigation">
							  <div class="container-fluid">
								<!-- Brand and toggle get grouped for better mobile display -->
								<div class="navbar-header">
								  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								  </button>
								  <a class="navbar-brand" href="browsedvds.php"><span class="red">MovieCloud</span></a>
								</div>

								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class="collapse navbar-collapse" id="navbar-collapse-1">
									<ul class="nav navbar-nav">
										<li><a href="BrowseDVDs.php">Home<span class="sr-only">(current)</span></a></li>
										<li class="dropdown">
										  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Categories <span class="caret"></span></a>
										  <ul class="dropdown-menu" role="menu">
											<li><a href="browsedvds.php">All</a></li>
											<?php
											$query = " 
											SELECT 
												hMy, categoryname
											FROM category ";
											
											$resultSet = $db->query($query, MYSQLI_STORE_RESULT);
											while ($row = $resultSet->fetch_assoc())
											{
												echo '<li><a href="browsedvds.php?categoryId='.$row['hMy'].'">'.$row['categoryname'].'</a></li>';
											}
											?>
										  </ul>
										</li>
										<li><a href="myorders.php">My Orders</a></li>
									</ul>
									<a href="loggedout.php" class="btn btn-danger pull-right" rel="tooltip" role="button">Logout</a>
								</div><!-- /.navbar-collapse -->
							  </div><!-- /.container-fluid -->
							</nav>
						  </div>
					</div>
				</div>
				
            <div class="row">
                <div class="register span10">
                    <div class="thumbnail">
						<?php
							echo '<img src="images/DVD/'.$obj->imagepath.'" alt="'.$obj->title.'">';
							echo '<div class="caption">';
							echo '<h3>'.$obj->title.'<a href="browsedvds.php" class="btn btn-danger pull-right" rel="tooltip" role="button">Continue Shopping</a></h3>';
							echo '<p>Cast:'.$obj->cast.'</p>';
							echo '<p>Intro:'.$obj->intro.'</p>';
							echo '<p>Release Date:'.$obj->releasedate.'</p>';
							echo '<p>Price:'.$currency.$obj->price.'</p>';
							echo '<p><a href="cart_update.php?type=add&dvd_code='.$obj->hMy.'" class="btn btn-danger" rel="tooltip" role="button"><span class="glyphicon glyphicon-shopping-cart"></span></a></p>';
							echo '';
							echo '</div>';
						?>
					</div>
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

