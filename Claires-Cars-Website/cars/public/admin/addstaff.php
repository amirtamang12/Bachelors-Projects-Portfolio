<?php
$pdo = new PDO('mysql:dbname=cars;host=localhost', 'root', '');
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="../styles.css"/>
		<title>Claires's Cars - Admin</title>
	</head>
	<body>
	<header>
		<section>
			<aside>
			<h3>Opening Hours:</h3>
				<p>Sun: Closed</p>
				<p>Mon-Fri: 09:00-17:30</p>
				<p>Sat: 09:00-17:00</p>
			</aside>
			<img src="../images/logo.png"/>

		</section>
	</header>
	<nav>
		<ul>
			<li><a href="/">Home</a></li>
			<li><a href="../cars.php">Showroom</a></li>
			<li><a href="../about.html">About Us</a></li>
			<li><a href="../contact.php">Contact us</a></li>
			<li><a href="career.php">Claire's Career</a></li>
		</ul>
	</nav>
		<img src="../images/randombanner.php"/>
	<main class="admin">

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

		
	<?php


	if (isset($_POST['submit'])) {

		$stmt = $pdo->prepare('INSERT INTO admin (admin_name, admin_email, admin_password) 
							   VALUES (:admin_name, :admin_email, :admin_password)');

		$criteria = [
			'admin_name' => $_POST['name'],
			'admin_email' => $_POST['email'],
			'admin_password' => $_POST['password'],
		];

		$stmt->execute($criteria);

		
		echo 'Staff added';
	}
	else {
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		?>


			<h2>Add Car</h2>

			<form action="addstaff.php" method="POST" enctype="multipart/form-data">
				<label>Staff Name</label>
				<input type="text" name="name" />


				<label>Staff email</label>
				<input type="text" name="email" />

				<label>Staff Password</label>
				<input type="password" name="password">

				<input type="submit" name="submit" value="Add Staff" />

			</form>
			

		
		<?php
		}

		else {
			?>
			<h2>Log in</h2>

			<form action="index.php" method="post">

				<label>Password</label>
				<input type="password" name="password" />

				<input type="submit" name="submit" value="Log In" />
			</form>
		<?php
		}

	}
	?>

</section>
	</main>


	<footer>
		&copy; Claire's Cars 2018
	</footer>
</body>
</html>
