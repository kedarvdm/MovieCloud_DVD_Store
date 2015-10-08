<?php
require("config.php");

if(isset($_GET["checkout"]) && $_GET["checkout"]==1)
{
	$userid=$_SESSION['userid'];
	if(isset($_SESSION["products"]))
	{
		$total = 0;
		$query = "Insert into orders (hcustomer,datecreated) values(?,curdate())"; 
		$stmt = $db->prepare($query);
		$stmt->bind_param('d',$userid);
		$stmt->execute();
		$newId = $stmt->insert_id;
		$orderid=$newId;
		if($newId>0)
		{	
			$query = "INSERT into orderitems (horder,hdvd,itemprice) values(?,?,?)";
			$query1 = "UPDATE dvdinventory set availability=availability-1 where hdvdinfo=?";
			$stmt = $db->prepare($query);
			$stmt1 = $db->prepare($query1);
			
			
			foreach ($_SESSION["products"] as $cart_itm)
			{
				$stmt->bind_param('ddd',$newId,$cart_itm["code"],$cart_itm["price"]);
				$stmt->execute();
				$stmt1->bind_param('d',$cart_itm["code"]);
				$stmt1->execute();
				$subtotal = ($cart_itm["price"]);
				$total = ($total + $subtotal);
			}
		}
		if($orderid>0)
		{
			$query = "update orders set ordertotal=? where hmy=?";
			$stmt = $db->prepare($query);
			$stmt->bind_param('dd',$total,$orderid);
			$stmt->execute();
			$stmt->close();
			//Remove cart from session
			unset($_SESSION["products"]);
		}
		
	}	
	header("Location: browsedvds.php");	
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
                        <h1><a href="browsedvds.php">MovieCloud <span class="red">.</span></a></h1>
                    </div>
                </div>
            </div>
        </div>
		<div class="container register-container">
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
							</div><!-- /.navbar-collapse -->
						  </div><!-- /.container-fluid -->
						</nav>
					  </div>
				</div>
			</div>
            <div class="row">
				<div class="row">
					<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post" enctype="multipart/form-data">
						<div id="effect" class="jumbotron ui-widget-content ui-corner-all">
							<h2>Your Shopping Cart <a href="browsedvds.php" class="btn btn-danger pull-right" rel="tooltip" role="button">Continue Shopping</a></h2>
							<?php
							$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
							if(isset($_SESSION["products"]))
							{
								$total = 0;
								echo '<ul>';
								foreach ($_SESSION["products"] as $cart_itm)
								{
									echo '<li class="cart-itm">';
									echo '<h3>'.$cart_itm["name"].'<a href="cart_update.php?removep='.$cart_itm["code"].'&return_url='.$current_url.'" class="btn btn-danger pull-right" rel="tooltip" role="button"><span class="glyphicon glyphicon-remove"></span></a></h3>';
									echo '<div class="p-price">Price :'.$currency.$cart_itm["price"].'</div>';
									echo '</li>';
									$subtotal = ($cart_itm["price"]);
									$total = ($total + $subtotal);
								}
								echo '</ul>';
								echo '<span class="check-out-txt"><strong>Total : '.$currency.$total.'</strong> </span>';
								echo '<div>';
								echo '<a href="view_cart.php?checkout=1" class="btn btn-danger" rel="tooltip" role="button">Check-out!</a>';
								echo '<a href="cart_update.php?emptycart=1&return_url='.$current_url.'" class="offset1 btn btn-danger" rel="tooltip" role="button">Empty Cart!</a>';
								echo '</div>';
							}else{
								echo 'Your Cart is empty';
							}
							?>
						</form>
						</div>
					</div>
				</div>
</div>
</div>
		<!-- Javascript -->
        <script src="assets/js/jquery-1.8.2.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
		<script src="assets/js/bootstrap-datepicker.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		 
			$("[rel='tooltip']").tooltip();			
		});		
		</script>
</body>
</html>
