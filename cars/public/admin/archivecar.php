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

		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		?>


			<h2>Archive Cars</h2>

			<a class="new" href="addcar.php">Add new car</a>

			<?php
			echo '<table>';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Model</th>';
			echo '<th style="width: 10%">Price</th>';
			echo '<th style="width: 5%">&nbsp;</th>';
			echo '<th style="width: 5%">&nbsp;</th>';
			echo '</tr>';

			$cars = $pdo->query('SELECT * FROM cars WHERE archive = 1');

			foreach ($cars as $car) {
				echo '<tr>';
				echo '<td>' . $car['name'] . '</td>';
				echo '<td>£' . $car['price'] . '</td>';
				echo '<td><a style="float: right" href="editcar.php?id=' . $car['id'] . '">Edit</a></td>';
				echo '<td><form method="post" action="deletecar.php">
				<input type="hidden" name="id" value="' . $car['id'] . '" />
				<input type="submit" name="submit" value="Delete" />
				</form></td>';
				echo '<td><a style="float: right" href="restore.php?id=' . $car['id'] . '"">Restore</a></td>';
				echo '</tr>';
			}

			echo '</thead>';
			echo '</table>';

		}

		else {
			?>
			<h2>Log in</h2>

			<form action="admin.php" method="post">
				<label>Password</label>
				<input type="password" name="password" />

				<input type="submit" name="submit" value="Log In" />
			</form>
		<?php
		}
	?>

</section>
	</main>
	<footer>
		&copy; Claire's Cars 2018
	</footer>

</body>
</html>
