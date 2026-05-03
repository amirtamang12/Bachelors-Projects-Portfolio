<?php 
$hostname = 'db';
$username = 'root'; 
$password = 'example'; //
$dbname   = 'cars';

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    // Set error mode to see useful messages if something goes wrong
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM stories";
    $stmt = $pdo->query($query); // This actually executes the query
    
    // FIX 1: Changed $results to $result to match your foreach loop
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 

} catch (PDOException $e) {
    // FIX 2: Create an empty array so the foreach loop doesn't crash if the DB fails
    $result = []; 
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="styles.css"/>
		<title>Claires's Cars - Home</title>
		<style>
			.column {
				float: left;
				width: 50%;
			}
  
  /* Clear floats after the columns */
			.row:after {
				content: "";
				display: table;
				clear: both;
			}
		</style>
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
					<img src="images/logo.png" width="250"/>
		<ul>

			<li><a href="index.php">Home</a></li>
			<li><a href="cars.php">Showroom</a></li>
			<li><a href="about.html">About Us</a></li>
			<li><a href="contact.php">Contact us</a></li>
			<li><a href="career.php">Claire's Career</a></li>
		</ul>

	</nav>
<img src="images/randombanner.php"/>
	<main class="home">
		<p>Welcome to Claire's Cars, Northampton's specialist in classic and import cars.</p>
		<div class="row">
			<?php foreach($result as $data):?>
				<div class="column">
					<img src="images/stories/<?php echo $data['story']?>" alt="" height="250">
				</div>
			<?php endforeach?>
		</div>
		
	</main>


	<footer>
		&copy; Claire's Cars 2018
	</footer>
</body>
</html>
