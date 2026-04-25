<?php 
$hostname='db';
$username='root';
$password='example';
$dbname='cars';
$pdo = new PDO("mysql:dbname=cars;host=$hostname" ,$username, $password);
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="styles.css"/>
		<title>Claires's Cars - Our Cars</title>
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
		</section>
	</header>
	<nav>
		<img src="images/logo.png" width="250" />
		<ul>
			<li><a href="/">Home</a></li>
			<li><a href="cars.php">Showroom</a></li>
			<li><a href="about.html">About Us</a></li>
			<li><a href="contact.php">Contact us</a></li>
			<li><a href="career.php">Claire's Career</a></li>
		</ul>
	</nav>
		<img src="images/randombanner.php"/>
	<main class="admin">
	<?php 
		$manus = $pdo->prepare('SELECT * FROM manufacturers');
		$manus->execute();

	?>
	<section class="left">
		<ul>
			<?php foreach($manus as $man):?>
				<li><a href="#"><?php echo $man['name']?></a></li>
			<?php endforeach?>

		</ul>
	</section>

	<section class="right">

		<h1>Our cars</h1>

	<ul class="cars">


	<?php

	$cars = $pdo->prepare('SELECT * FROM cars LIMIT 10');
	$manu = $pdo->prepare('SELECT * FROM manufacturers WHERE id = :id');

	$cars->execute();


	foreach ($cars as $car) {
		$manu->execute(['id' => $car['manufacturerId']]);
		$manufacturer = $manu->fetch();
		echo '<li>';

		if (file_exists('images/cars/' . $car['id'] . '.jpg')) {
			echo '<a href="images/cars/' . $car['id'] . '.jpg"><img src="images/cars/' . $car['id'] . '.jpg" /></a>';
		}

		echo '<div class="details">';
		echo '<h2>' . $manufacturer['name'] . ' ' . $car['name'] . '</h2>';
		echo '<h3>Was £' . $car['price'] . ', now £' . $car['new_price'] . '</h3>';
		echo '<p>' . $car['description'] . '</p>';

		echo '</div>';
		echo '</li>';
	}

	?>

</ul>

</section>
	</main>


	<footer>
		&copy; Claire's Cars 2018
	</footer>
</body>
</html>
