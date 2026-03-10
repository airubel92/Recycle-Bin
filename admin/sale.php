<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php
//including the database connection file
include_once("connection.php");

// MySQL Join
$result = mysqli_query($mysqli, "SELECT products.login_id, products.name, products.qty, products.price, products.id, login.username FROM products INNER JOIN login ON products.login_id=login.id ORDER BY products.id DESC");

// MySQL aggregate function
$minPrice = mysqli_query($mysqli, "SELECT MIN(price) FROM products AS SmallestPrice");
$total_product = mysqli_query($mysqli, "SELECT SUM(qty) FROM products");
$total_price = mysqli_query($mysqli, "SELECT SUM(price) FROM products");
?>

<html>
<head>
	<title>Homepage</title>
</head>

<body>
	<a href="index.php">Home</a> | <a href="add.html">Add Product</a> | <a href="logout.php">Logout</a>
	<br/><br/>
	
	<table width='80%' border=0>
		<tr bgcolor='#CCCCCC'>
			<td>Name</td>
			<td>Quantity</td>
			<td>Price (BDT)</td>
			<td>User ID</td>
			<td>Username</td>
			<td>Update</td>
		</tr>
		<?php
		while($res = mysqli_fetch_array($result)) {		
			echo "<tr>";
			echo "<td>".$res['name']."</td>";
			echo "<td>".$res['qty']."</td>";
			echo "<td>".$res['price']."</td>";
			echo "<td>".$res['login_id']."</td>";
			echo "<td>".$res['username']."</td>";
			echo '<td><a href="edit.php?id='.$res["id"].'">Edit</a> | <a href="delete.php?id='.$res["id"].'" onClick="return confirm(\'Are you sure you want to delete?\')">Delete</a></td>';		
		}
		?>
	</table>
	<br>
	<div>
		Total Price:
		<?php
			while($t_price = mysqli_fetch_array($total_price)) {
				echo $t_price[0];
			}
		?>
	</div>	
	<div>
		Min price is:
		<?php
			while($minRes = mysqli_fetch_array($minPrice)) {
				echo $minRes[0];
			}
		?>
	</div>	
	<div>
		Total Product is:
		<?php
			while($res_tot = mysqli_fetch_array($total_product)) {
				echo $res_tot[0];
			}
		?>
	</div>
</body>
</html>
