<?php
	if(!empty($_POST)){
    ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);
	require("config.php");
	
	//Get all the variables
	$moviename=$_POST['moviename'];
	$castinfo=$_POST['castinfo'];
	$intro=$_POST['intro'];
	$category=$_POST['category'];
	$file=$_FILES['file']['name'];
	$releasedate=$_POST['releasedate'];
	$price=$_POST['price'];
	$availability=$_POST['availability'];
	


	
	$query = "Insert into dvdinfo (title, cast, intro, hCategory, releasedate,imagepath,price, datecreated) values(?,?,?,?,?,?,?,curdate())"; 
	$stmt = $db->prepare($query);
	$stmt->bind_param('sssdssd',$moviename,$castinfo,$intro,$category,$releasedate,$file,$price);
	$stmt->execute();
	$newId = $stmt->insert_id;
	if($newId>0)
	{	
		$query = "INSERT into dvdinventory (hDvdInfo,availability,dateupdated) values(?,?,curdate())";
		$stmt = $db->prepare($query);
		$stmt->bind_param('dd',$newId,$availability);
		$stmt->execute();
		$newId = $db->insert_id;
	}
	$stmt->close();
	
	move_uploaded_file($_FILES['file']['tmp_name'],"images/DVD/".$_FILES['file']['name']);
	
	if($newId>0)
	{
		header("Location: adminhome.php"); 
		die("Redirecting to: adminhome.php"); 
	}
	else
	{
		print("Registration Failed."); 
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
                        <h1><a href="">MovieCloud <span class="red">.</span></a></h1>
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
                    <form action="" method="post" enctype="multipart/form-data">
                        <h2><span class="red"><strong>MovieCloud</strong></span></h2>
						<h2><span class="red"><strong>Movie Information</strong></span></h2>
						<div class="form-group span5">
							<label for="moviename">Movie Title:</label>
							<input type="text" name="moviename" placeholder="Movie Title" required autofocus>
						</div>
						<div class="form-group span5">
							<label for="castinfo">Cast Info:</label>
							<textarea class="form-control" rows="3" name="castinfo" id="castinfo" placeholder="Cast Information" required ></textarea>
						</div>
						<div class="form-group span5">
							<label for="intro">Intro:</label>
							<textarea class="form-control" rows="4" name="intro" id="intro" placeholder="Intro" required ></textarea>
						</div>
						<div class=" form-group span5">
							<label for="category">Category:</label>
							<select class="form-control" id="category" name="category">
							<?php
							require("config.php");
							$_SESSION['category']='Action';
							$category=$_SESSION['category'];
							
							$query = " 
							SELECT 
								hMy, categoryname
							FROM category ";
							
							$resultSet = $db->query($query, MYSQLI_STORE_RESULT);
							while ($row = $resultSet->fetch_assoc())
							{
								echo '<option value="'.$row["hMy"].' required">'.$row["categoryname"].'</option>';
							}
							?>
							</select>
						</div>
						<div class="form-group span5">
							<label for="file">Image:</label>
							<input type="file" id="file" name="file" required>
						</div>
						<div class="form-group span5">
							<label for="releasedate">Release Date:</label>
							<input class="form-control" type="text" name="releasedate" id="dpicker" placeholder="Release Date" required >
							<span class="glyphicon glyphicon-calendar"></span>
						</div>
						<div class="form-group span5">
							<label for="price">Price:</label>
							<input type="text" name="price" id="price" placeholder="Price" required>
						</div>
						<div class="form-group span5">
							<label for="availability">Availability:</label>
							<input type="text" name="availability" id="availability" placeholder="Availability" required>
						</div>
						<button type="submit">Add DVD</button>
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
		$(document).ready(function(){
			$('#dpicker').datepicker({
			format: "mm/dd/yyyy"
			});
			
			$('#availability').blur(function(){
				if($('#availability').val()!='')
				{
					var inputval=$(this).val();
					var regex=/^\d+$/;
					if(!regex.test(inputval))
					{
						if($('.chkavail').length==0)
						{
							$('.register').find("label[for='availability']").append("<span style='display:none' class='red chkavail'> - Please enter a integer only.</span>");
							$('.register').find("label[for='availability'] span").fadeIn('medium');
						}
					}
					else
					{
						
						$('.chkavail').remove();
					}
				}
				else
				{
					if($('.chkavail').length!=0)
					{
						$('.chkavail').remove();
					}
				}
			});
			
			$('#price').blur(function(){
				if($('#price').val()!='')
				{
					if(!$.isNumeric($('#price').val()))
					{
						if($('.chkprice').length==0)
						{
							$('.register').find("label[for='price']").append("<span style='display:none' class='red chkprice'> - Please enter a valid price.</span>");
							$('.register').find("label[for='price'] span").fadeIn('medium');
						}
					}
					else
					{
						
						$('.chkprice').remove();
					}
				}
				else
				{
					if($('.chkprice').length!=0)
					{
						$('.chkprice').remove();
					}
				}
			});
			
		});		
		</script>
    </body>

</html>

