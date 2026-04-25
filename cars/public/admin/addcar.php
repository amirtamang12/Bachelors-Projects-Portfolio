<?php
$hostname='db';
$username='student';
$password='student';
$dbname='cars';
$pdo = new PDO("mysql:dbname=cars;host=$hostname" ,$username, $password);
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

		$stmt = $pdo->prepare('INSERT INTO cars (name, description, price, manufacturerId,milage,new_price,type) 
							   VALUES (:model, :description, :price, :manufacturerId,:milage, :new_price, :type)');

		$criteria = [
			'model' => $_POST['model'],
			'description' => $_POST['description'],
			'price' => $_POST['price'],
			'manufacturerId' => $_POST['manufacturerId'],
			'milage' => $_POST['milage'],
			'type'=> $_POST['type'],
			'new_price' => $_POST['new_price']
		];

		$stmt->execute($criteria);

		if ($_FILES['image']['error'] == 0) {
			$fileName = $pdo->lastInsertId() . '.jpg';
			move_uploaded_file($_FILES['image']['tmp_name'], '../images/cars/' . $fileName);
		}

		if ($_FILES['image1']['error'] == 0) {
			$fileName = $pdo->lastInsertId() . '.jpg';
			move_uploaded_file($_FILES['image1']['tmp_name'], '../images/cars/' . $fileName);
		}
		if ($_FILES['image2']['error'] == 0) {
			$fileName = $pdo->lastInsertId() . '.jpg';
			move_uploaded_file($_FILES['image2']['tmp_name'], '../images/cars/' . $fileName);
		}
		if ($_FILES['image3']['error'] == 0) {
			$fileName = $pdo->lastInsertId() . '.jpg';
			move_uploaded_file($_FILES['image3']['tmp_name'], '../images/cars/' . $fileName);
		}

		echo 'Car added';
	}
	else {
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		?>


			<h2>Add Car</h2>

			<form action="addcar.php" method="POST" enctype="multipart/form-data">
				<label>Car Model</label>
				<input type="text" name="model" />

				<label>Description</label>
				<textarea name="description"></textarea>

				<label>Milage</label>
				<input type="text" name="milage" />

				<label>Car type</label>
				<input type="text" name="type" placeholder="Petrol or diesel" />

				<label>Price</label>
				<input type="text" name="price" />

				<label>Current Price</label>
				<input type="text" name="new_price" />

				<label>Category</label>

				<select name="manufacturerId">
				<?php
					$stmt = $pdo->prepare('SELECT * FROM manufacturers');
					$stmt->execute();

					foreach ($stmt as $row) {
						echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
					}

				?>

				</select>

				<label>Image</label>

				<input type="file" name="image" />
				<input type="file" name="image1" />
				<input type="file" name="image2" />
				<input type="file" name="image3" />

				<input type="submit" name="submit" value="Add Car" />

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
