<?php
	require("config.php");
	
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
                        <h1><a href="adminhome.php">MovieCloud <span class="red">.</span></a></h1>
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
							  <a class="navbar-brand" href="adminhome.php"><span class="red">MovieCloud</span></a>
							</div>

							<!-- Collect the nav links, forms, and other content for toggling -->
							<div class="collapse navbar-collapse" id="navbar-collapse-1">
								<ul class="nav navbar-nav">
									<li><a href="adminhome.php">Home<span class="sr-only">(current)</span></a></li>
									<li><a href="adddvd.php">Add Movie</a></li>
									<li><a href="viewcustomerorders.php">View Orders</a></li>
								</ul>
								<a href="loggedout.php" class="btn btn-danger pull-right" rel="tooltip" role="button">Logout</a>
							</div><!-- /.navbar-collapse -->
						  </div><!-- /.container-fluid -->
						</nav>
					  </div>
				</div>
			</div>
            <div class="row">
                <div class="register span12">
                    <div class="jumbotron row">
						<?php
						$username=$_SESSION['user']; ?>
                        <h2>Welcome <span class="red"><strong><?php echo $username?></strong></span></h2>
						  <table class="table table-striped table-hover">
							<tr>
								<th>Order Id</th>
								<th>Order Total</th>
								<th>Movie Name</th>
								<th>Price</th>
								<th>Order Date</th>
								<th>Mark Shipped</th>
							</tr>
							<?php
								
								$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
								$userid=$_SESSION['userid'];
								
								$query = " 
								select o.hmy as orderid,d.title,oi.itemprice, o.ordertotal,o.datecreated,o.orderstatus from orders o 
								inner join orderitems oi on oi.horder=o.hmy
								inner join dvdinfo d on d.hmy=oi.hdvd";
								
								$currentoid=0;
								$prevoid=0;
								
								$resultSet = $db->query($query, MYSQLI_STORE_RESULT);
								while ($row = $resultSet->fetch_assoc())
								{
									$currentoid=$row['orderid'];
									echo '<tr>';
									if($currentoid==$prevoid)
									{
										echo '<td></td>';
										echo '<td></td>';
									}
									else
									{
										$prevoid=$currentoid;
										echo '<td>'.$row['orderid'].'</td>';
										echo '<td>'.$currency.$row['ordertotal'].'</td>';
									}
									echo '<td>'.$row['title'].'</td>';
									echo '<td>'.$currency.$row['itemprice'].'</td>';
									echo '<td>'.date('m/d/Y', strtotime($row['datecreated'])).'</td>';
									if($row['orderstatus']!="Shipped")
									{
										echo '<td><a href="updateorder.php?orderid='.$row['orderid'].'&return_url='.$current_url.'" class="btn btn-danger" rel="tooltip" role="button"><span class="glyphicon glyphicon-ok"></span></a></td>';
									}
									else
									{
										echo '<td><Button class="btn btn-danger" disabled><span class="glyphicon glyphicon-flag"></span></Button></td>';
									}
									echo '</tr>';
								}
							?>
						  </table>
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
		$(document).ready(function(){
			
		});		
		</script>
    </body>

</html>

