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
			<img src="images/logo.png"/>

		</section>
	</header>
	<nav>
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
	<section class="left">
		<p><span style="color:white">Please call us on  01604 90345 or email</span> <a href="mailto:enquiries@clairscars.co.uk">enquiries@clairscars.co.uk</a>

	</section>

	<section class="right">

		<h1>Contact us</h1>
		<form action="">
			<label>Name: </label>
			<input type="text" name="" id=""><br>
			<label>Email: </label>
			<input type="text" name="" id=""><br>
			<label>Contact: </label>
			<input type="text" name="" id=""><br>
			<label>Message</label>
			<textarea name="" id="" cols="30" rows="10"></textarea><br>
			<input type="submit" value="Submit">
			
		</form>

	<ul class="cars">


	</ul>

</section>
	</main>


	<footer>
		&copy; Claire's Cars 2018
	</footer>
</body>
</html>
