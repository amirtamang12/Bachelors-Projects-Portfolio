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

		$stmt = $pdo->prepare('UPDATE cars
								SET name = :name, 
								    description = :description, 
								    price = :price,
								    manufacturerId = :manufacturerId,
									new_price = :new_price,
									type = :type,
									milage = :milage
								   WHERE id = :id 
						');

		$criteria = [
			'name' => $_POST['name'],
			'description' => $_POST['description'],
			'price' => $_POST['price'],
			'manufacturerId' => $_POST['manufacturerId'],
			'milage' => $_POST['milage'],
			'type'=> $_POST['type'],
			'new_price' => $_POST['new_price'],
			'id' => $_POST['id']
		];

		$stmt->execute($criteria);

		if ($_FILES['image']['error'] == 0) {
			$fileName = $pdo->lastInsertId() . '.jpg';
			move_uploaded_file($_FILES['image']['tmp_name'], '../productimages/' . $fileName);
		}

		echo 'Product saved';
	}
	else {
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

			$car = $pdo->query('SELECT * FROM cars WHERE id = ' . $_GET['id'])->fetch();


		?>

			<h2>Edit Car</h2>

			<form action="editcar.php" method="POST" enctype="multipart/form-data">

				<input type="hidden" name="id" value="<?php echo $car['id']; ?>" />
				<label>Name</label>
				<input type="text" name="name" value="<?php echo $car['name']; ?>" />

				<label>Description</label>
				<textarea name="description"><?php echo $car['description']; ?></textarea>

				<label>Milage</label>
				<input type="text" name="milage" value="<?php echo $car['milage']; ?>"/>

				<label>Car type</label>
				<input type="text" name="type" placeholder="Petrol or diesel" value="<?php echo $car['type']; ?>" />s


				<label>Current Price</label>
				<input type="text" name="new_price"  value="<?php echo $car['new_price']; ?>"/>

				<label>Price</label>
				<input type="text" name="price" value="<?php echo $car['price']; ?>" />

				<label>Category</label>

				<select name="manufacturerId">
				<?php
					$stmt = $pdo->prepare('SELECT * FROM manufacturers');
					$stmt->execute();

					foreach ($stmt as $row) {
						if ($car['categoryId'] == $row['id']) {
							echo '<option selected="selected" value="' . $row['id'] . '">' . $row['name'] . '</option>';
						}
						else {
							echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';	
						}
						
					}

				?>

				</select>


				<?php

					if (file_exists('../productimages/' . $car['id'] . '.jpg')) {
						echo '<img src="../productimages/' . $car['id'] . '.jpg" />';
					}
				?>
				<label>Product image</label>

				<input type="file" name="image" />

				<input type="submit" name="submit" value="Save Product" />

			</form>

		<?php
		}

		else {
			?>
			<h2>Log in</h2>

			<form action="index.php" method="post">
				<label>Username</label>
				<input type="text" name="username" />

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
