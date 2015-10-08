<?php
require("config.php");

$categoryId=0;
if(isset($_GET["categoryId"]))
{
	$categoryId=$_GET["categoryId"];
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
								<a href="loggedout.php" class="btn btn-danger pull-right" rel="tooltip" role="button">Logout</a>
								<input type="text" id="search" class="searchbar span5" placeholder="Search">
								<Button id="showcart" class="btn btn-danger pull-right">Show Cart <span class="glyphicon glyphicon-shopping-cart"></Button>
							</div><!-- /.navbar-collapse -->
						  </div><!-- /.container-fluid -->
						</nav>
					  </div>
				</div>
			</div>


       
					<div class="row">
						<div id="result" class="hidesearch jumbotron"></div>
							<?php
							$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
							?>
						<div id="cart" class="jumbotron">
							<h2>Your Shopping Cart <Button id="closecart" class="btn btn-danger offset1 pull-right"><span class="glyphicon glyphicon-off"></Button> <a href="cart_update.php?emptycart=1&return_url='<?php echo $current_url ?>'" class="btn btn-danger pull-right" rel="tooltip" role="button">Empty Cart!</a></h2>
							<?php
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
								echo '<p><strong>Total : '.$currency.$total.'</strong> </p>';
								echo '<div>';
								echo '<p><a href="view_cart.php" class="btn btn-danger" rel="tooltip" role="button">Check-out!</a></p>';
								echo '</div>';
							}else{
								echo 'Your Cart is empty';
							}
							?>
							
						</div>
					</div>
					<div class="row">
						<?php
							
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
								Inner join dvdinventory di on d.hmy=di.hDvdInfo
								inner join category c on c.hMy=d.hCategory 
								WHERE di.availability>0";
							
							if($categoryId>0)
							{	
								$query=$query.' and d.hCategory='.$categoryId;
							}
							
							$resultSet = $db->query($query, MYSQLI_STORE_RESULT);
							while ($row = $resultSet->fetch_assoc())
							{	
								echo '<div class="col-sm-3 maximize">';
								echo '<div class="thumbnail thumbnailhover">';
								echo '<img class="img-responsive" src="images/DVD/'.$row['imagepath'].'" alt="Generic placeholder thumbnail">';
								echo '<div class="caption">';
								echo '<h3>'.$row['title'].'</h3>';
								echo '<p>Price:'.$currency.$row['price'].'</p>';
								echo '</div>';
								echo '<div class="dvdhover">';
								echo '<div class="inner">';
								echo '<p><a href="viewmovie.php?dvd_code='.$row['hMy'].'" class="btn btn-danger" rel="tooltip" role="button"><span class="glyphicon glyphicon-eye-open"></span></a></p>';
								echo '<p><a href="cart_update.php?type=add&dvd_code='.$row['hMy'].'&return_url='.$current_url.'" class="btn btn-danger" rel="tooltip" role="button"><span class="glyphicon glyphicon-shopping-cart"></span></a></p>';
								echo '</div>';
								echo '</div>';
								echo '</div>';
								echo '</div>';
							}	
						?>
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
		 
			$('.thumbnailhover').hover(
				function(){
					$(this).find('.dvdhover').slideDown(250); //.fadeIn(250)
				},
				function(){
					$(this).find('.dvdhover').slideUp(250); //.fadeOut(205)
				}
			);
			
			$("#cart").hide();
			
			$('#showcart').click(function() {
				$("#cart").show();
			});
			$('#closecart').click(function(){
				$("#cart").hide();
			});
			
		
			$(function () {
			$("#search").keyup(function () {
				var that = this,
				value = $(this).val();

				
					$.ajax({
						type: "POST",
						url: "search.php",
						data: {
							'title' : value
						},
						dataType: "text",
						success: function(msg){
							if(msg)
							{
								$( "#result" ).toggleClass( "viewsearch" );
								$("#result").html(msg);
							}
							else
							{
								$( "#result" ).toggleClass( "hidesearch" );
							}
						}
					});
				
			});
		});
			
		});		
		</script>
	</body>
</html>

