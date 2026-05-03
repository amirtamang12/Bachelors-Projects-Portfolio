<!-- this code is for connecting database -->
<?php 
$hostname='db';
$username='student';
$password='student';
$dbname='cars';
$pdo = new PDO("mysql:dbname=cars;host=$hostname" ,$username, $password);

?>
<!DOCTYPE html>
<html>
	<head>
		<!-- for connecting to css file -->
		<link rel="stylesheet" href="../styles.css"/>
		<title>Claires's Cars - Admin</title>
	</head>
	<body>
	<header>
		<section>
			<aside>
				<!-- displaying opening times on different days -->
			<h3>Opening Hours:</h3>
				<p>Sun: Closed</p>
				<p>Mon-Fri: 09:00-17:30</p>
				<p>Sat: 09:00-17:00</p>
			</aside>
			<!-- for logo -->
			<img src="../images/logo.png"/>

		</section>
	</header>
		<!-- navigation bar starts from here -->
	<nav>
		<ul>
			<li><a href="/">Home</a></li>
			<li><a href="../cars.php">Showroom</a></li>
			<li><a href="../about.html">About Us</a></li>
			<li><a href="../contact.php">Contact us</a></li>
			<li><a href="career.php">Claire's Career</a></li>
		</ul>
	</nav>
<!-- for random banner display -->
	<img src="../images/randombanner.php"/>
	<main class="admin">
		
	<!-- for login to the admin -->
	<?php
	if (isset($_POST['submit'])) {
		$password = $_POST['password'];
		$email = $_POST['email'];
		$query = "SELECT * FROM admin WHERE admin_email = '$email' AND admin_password = '$password'";
		$result = mysqli_query($conn,$query);
		if(mysqli_num_rows($result) > 0){
			$data = mysqli_fetch_assoc($result);
			$_SESSION['name'] = $data['admin_name'];
			$_SESSION['loggedin'] = true;
		}
		else{
			echo "Username and password invalid";
		}

			
	
	}


	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	?>

	<section class="left">
		<ul>
			<li><a href="manufacturers.php">Manufacturers</a></li>
			<li><a href="cars.php">Cars</a></li>
			<li><a href="archivecar.php">Archive Cars</a></li>
			<li><a href="staff.php">Staffs</a></li>
			<li><a href="stories.php">Stories</a></li>
			<li><a href="logout.php">Logout</a></li>


		</ul>
	</section>

	<section class="right">
	<h2>
		You are now logged in <br>
		Hello <?php echo $_SESSION['name']?>
	</h2>
	</section>
	<?php
	}

	else {
		?>
		<h2>Log in</h2>

		<form action="index.php" method="post" style="padding: 40px">
			<label>Enter username</label>
			<input type="email" name="email" />

			<label>Enter Password</label>
			<input type="password" name="password" />

			<input type="submit" name="submit" value="Log In" />
		</form>
	<?php
	}
	?>


	</main>

	<footer>
		&copy; Claire's Cars 2018
	</footer>
</body>
</html>
