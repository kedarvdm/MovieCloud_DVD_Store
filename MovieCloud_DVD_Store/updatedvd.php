<?php
	require("config.php");
	if(!empty($_POST)){
	//Get all the variables
	$dvd_code=$_POST['dvd_code'];
	$moviename=$_POST['moviename'];
	$castinfo=$_POST['castinfo'];
	$intro=$_POST['intro'];
	$category=$_POST['category'];
	$file=$_FILES['file']['name'];
	$releasedate=$_POST['releasedate'];
	$price=$_POST['price'];
	$availability=$_POST['availability'];
	
	$results = $db->query("SELECT hmy FROM dvdinfo WHERE hMy='$dvd_code' LIMIT 1");
	$obj = $results->fetch_object();

	if($results)
	{
		$query = "UPDATE dvdinfo set title=?, cast=?, intro=?, hCategory=?, releasedate=?,price=?, datecreated=curdate()";
		if($file)
		{
			$query=$query.",imagepath=?";
		}
		$query=$query." where hmy=$dvd_code"; 
		$stmt = $db->prepare($query);
		
		if($file)
		{
			$stmt->bind_param('sssdsds',$moviename,$castinfo,$intro,$category,$releasedate,$price,$file);
		}
		else
		{
			$stmt->bind_param('sssdsd',$moviename,$castinfo,$intro,$category,$releasedate,$price);
		}
		print($query);
		$stmt->execute();

		if($db->affected_rows >= 0)
		{
			if($file)
			{
				move_uploaded_file($_FILES['file']['tmp_name'],"images/DVD/".$_FILES['file']['name']);
			}
			$query = "UPDATE dvdinventory set availability=?,dateupdated=curdate() where hDVDInfo=$dvd_code";
			$stmt = $db->prepare($query);
			$stmt->bind_param('d',$availability);
			$stmt->execute();
			if($db->affected_rows >= 0)
			{
				$stmt->close();
				header('Location: adminhome.php');
			}
			else
			{
				$stmt->close();
				die('Inside Update failed');
			}
		}
		else
		{
			$stmt->close();
			die('Inside Update failed');
		}
	}
	else
	{
		die('DVD not found');
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
                        <h1><a href="adminhome.php">MovieCloud <span class="red">.</span></a></h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="register-container container">
            <div class="row">
                <div class="register span12">
					<?php
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
									d.price,
									c.hmy categoryid,
									c.categoryname,
									di.availability
								FROM dvdinfo d 
								Inner join dvdinventory di on d.hmy=di.hDvdInfo
								Inner join category c on c.hMy=d.hCategory
								Where d.hmy=$dvd_code LIMIT 1";
								
								$results = $db->query($query);
								$obj = $results->fetch_object();
						}
					?>
                    <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post" enctype="multipart/form-data">
                        <h2><span class="red"><strong>MovieCloud</strong></span></h2>
						<h2><span class="red"><strong>Movie Information</strong></span></h2>
						<input type="hidden" name="dvd_code" value="<?php echo $dvd_code ?>"/>
						<div class="form-group span5">
							<label for="moviename">Movie Title:</label>
							<input type="text" name="moviename" value="<?php if ($results) { echo $obj->title; } ?>" placeholder="Movie Title" readonly autofocus>
						</div>
						<div class="form-group span5">
							<label for="castinfo">Cast Info:</label>
							<textarea class="form-control" rows="3" name="castinfo" id="castinfo" placeholder="Cast Information" required ><?php if ($results) { echo $obj->cast; } ?></textarea>
						</div>
						<div class="form-group span5">
							<label for="intro">Intro:</label>
							<textarea class="form-control" rows="4" name="intro" id="intro"  placeholder="Intro" required ><?php if ($results) { echo $obj->intro; } ?></textarea>
						</div>
						<div class=" form-group span5">
							<label for="category">Category:</label>
							<select class="form-control" id="category" name="category">
							<?php
							$query = " 
							SELECT 
								hMy, categoryname as catname
							FROM category ";
							
							$resultSet = $db->query($query, MYSQLI_STORE_RESULT);
							while ($row = $resultSet->fetch_assoc())
							{
								if($row["hMy"]==$obj->categoryid)
								{
									echo '<option value="'.$row["hMy"].'" required selected">'.$row["catname"].'</option>';
								}
								else
								{
									echo '<option value="'.$row["hMy"].'" required">'.$row["catname"].'</option>';
								}
							}
							?>
							</select>
						</div>
						<div class="form-group span5">
							<label for="file">Image:</label>
							<input type="file" id="file" name="file">
						</div>
						<div class="form-group span5">
							<label for="releasedate">Release Date:</label>
							<input class="form-control" type="text" name="releasedate" id="dpicker" value="<?php if ($results) { echo $obj->releasedate; } ?>" placeholder="Release Date" required >
							<span class="glyphicon glyphicon-calendar"></span>
						</div>
						<div class="form-group span5">
							<label for="price">Price:</label>
							<input type="text" name="price" id="price" value="<?php if ($results) { echo $obj->price; } ?>" placeholder="Price" required>
						</div>
						<div class="form-group span5">
							<label for="availability">Availability:</label>
							<input type="text" name="availability" id="availability" value="<?php if ($results) { echo $obj->availability; } ?>" placeholder="Availability" required>
						</div>
						<button type="submit">Update DVD</button>
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
			format: "dd/mm/yyyy"
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

