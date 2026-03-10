<?php session_start(); ?>
<html>
<head>
	<title>Login</title>
	<style>
		.flex-container {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 300px;
			background-color: DodgerBlue;
			flex-direction: column;
		}
	</style>
</head>

<body>
<?php
		if (isset($_SESSION['valid'])) {
			header('location: dashboard.php');
			die();
		}
	?>
<a href="index.php">Home</a> <br />
<?php
include("connection.php");

if(isset($_POST['submit'])) {
	$user = $_POST['username'];
	$pass = $_POST['password'];

	if($user == "" || $pass == "") {
		echo "Either username or password field is empty.";
		echo "<br/>";
		echo "<a href='login.php'>Go back</a>";
	}
	if($user != "admin") {
		echo "Wrong username. Try with a admin user.";
		echo "<br/>";
		echo "<a href='login.php'>Go back</a>";
	} else {
		$result = mysqli_query($mysqli, "SELECT * FROM login WHERE username='$user' AND password='$pass'")
					or die("Could not execute the select query."); // Select or Read
		
		$row = mysqli_fetch_assoc($result);
		
		if(is_array($row) && !empty($row)) {
			$validuser = $row['username'];
			$_SESSION['valid'] = $validuser;
			$_SESSION['name'] = $row['name'];
			$_SESSION['id'] = $row['id'];
		} else {
			echo "Invalid username or password.";
			echo "<br/>";
			echo "<a href='login.php'>Go back</a>";
		}

		if(isset($_SESSION['valid'])) {
			header('Location: dashboard.php');			
		}
	}
} else {
?>
	<div class="flex-container">
		<h1>Admin Login</h1>
		<form name="form1" method="post" action="">
			<table width="75%" border="0">
				<tr> 
					<td width="10%">Username</td>
					<td><input type="text" name="username"></td>
				</tr>
				<tr> 
					<td>Password</td>
					<td><input type="password" name="password"></td>
				</tr>
				<tr> 
					<td>&nbsp;</td>
					<td><input type="submit" name="submit" value="Submit"></td>
				</tr>
			</table>
		</form>
	</div>
<?php
}
?>
</body>
</html>
