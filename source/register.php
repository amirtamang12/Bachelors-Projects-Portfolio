<?php
$hostname='db';
$username='root';
$password='example';
$dbname='User';

$dbcon = new PDO("mysql:host=$hostname;dbname=$dbname",$username,$password);

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
                <h3>Register</h3>
                    <form action="register.php" method = "POST">
                        <label> Full Name:</label>
                        <input type="text" name="Name" placeholder=" Username" /><br>
                        <label> Email:</label>
                        <input type="email" name="Email" placeholder=" Email"/><br>
                        <label> Password</label>
                        <input type="password" class="form-control" name ="Password" id="inputPassword" placeholder=" Password"><br>
                        <input type="submit" value="Register" name="submit"/><br>

						<label>Already have an account?<a href="login.php">Login</a></label>
                    </form>
					

            <div>
            <?php
            $stmt = $dbcon->prepare('INSERT INTO User_account(Name, Email, Password)
            VALUES(:Name, :Email, :Password)');

            $criteria = [
            'Name' => $_POST['Name'],
            'Email' => $_POST['Email'],
            'Password' => password_hash($_POST['Password'], PASSWORD_DEFAULT)
            ];
            $stmt ->execute($criteria);
            if($stmt->rowCount()>0){
            header("Location: login.php");
            die();
            }
            else{
            echo 'Registration failed';
            }
            ?>
            </div>

        </main>
<footer>
	&copy; Northampton News 2017
</footer>
</body>
</html>