<?php
$hostname='db';
$username='root';
$password='example';
$dbname='User';

$dbcon = new PDO("mysql:host=$hostname;dbname=$dbname",$username,$password);

if(isset($_POST['Email'], $_POST['Password'])) {

    //prepare statement to select all users from user table
    $stmt = $dbcon-> prepare('SELECT * FROM User_account WHERE Email = :Email;');
    
    $criteria = [
    'Email' => $_POST['Email']
    ];
    
    $stmt -> execute($criteria);
    $users = $stmt -> fetch();
    
    //un hashing passwords!
    if(password_verify($_POST['Password'], $users['Password'])) {
    $_SESSION['login'] = true;
    $_SESSION['Email'] = $_POST['Email'];
    
    //Once logged in re-directs the user to the homepage
    header("Location: index.php");
    die();
    }
    //If username and password do not match display this message
    else {
    echo 'Username OR Password did not match our records. Please try again';
    }
     
    }
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="styles.css"/>
		<title>Local News - Northampton News</title>
	</head>
	<body>
		<header>
			<section>
				<h1 class="nnh">Northampton News</h1>
			</section>
		</header>
		<nav class="nav">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="">Categories</a>
					<ul>
						<li><a class="articleLink" href="localnews.php">Local News</a></li>
						<li><a class="articleLink" href="sports.php">Sports</a></li>
						<li><a class="articleLink" href="technology.php">Technology</a></li>
					</ul>
                </li>
			</ul>
		</nav>
		<img src="images/banners/randombanner.php"/>
		<main>
			
			<article>
        <h3>Log In</h3>
            <form action="login.php" method = "POST">
                <label> Email:</label>
                    <input type="email" name="Email" placeholder="Email"/><br>
                <label> Password:</label>
                <input type="password" name="Password" placeholder="Password"/><br>
                <input type="submit" name="submit" value="Login" /><br>
            
				<label>Register Now?<a href="register.php">Register</a></label>
			</form>
		</article>
		</main>

		<footer>
			&copy; Northampton News 2017
		</footer>

	</body>
</html>