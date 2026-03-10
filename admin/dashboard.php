<?php
//including the database connection file
include_once("connection.php");


// MySQL aggregate function
$minPrice = mysqli_query($mysqli, "SELECT COUNT(id) FROM products");
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  </head>
  <body>
    <div style+="display:flex;">
        <div>
        </div>
        <div style="display:block;float:right">
            <!-- <a style="" href="sale.php">Sales Page</a> |  -->
            <a href="add.html">Add Product</a> | 
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <a href="../index.php"><h4 style="text-align:left; margin-top:0px">UIU RecycleBin</h4></a>

    <div style="min-height:400px">
        <h1 style="text-align:center; margin-top:200px">Welcome Admin</h1>
        <p style="text-align:center;">Running Sales
        <?php
			while($minRes = mysqli_fetch_array($minPrice)) {
				echo $minRes[0];
			}
		?>
        </p>
        <p style="text-align:center;"><a href="sale.php">Sales Page</a></p>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>