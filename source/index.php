<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="styles.css"/>
		<title>Northampton News - Home</title>
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
				    <div class="login"> <a href="login.php"> <button>Log In</button> </a></div>
					<div class="reg"> <a href="register.php"> <button>Register</button> </a> </div>
			</ul>
		</nav>
		<img src="images/banners/randombanner.php"/>
		<main>
			<article>
				<h2>Latest Articles</h2>
				<p>These are articles ordered by latest posted date</p>

				<ul>
					
					<li><a class="articleLink" href="technologynews3.php">Far out: NASA space telescope's 1st cosmic view goes deep</a></li>
					<li><a class="articleLink" href="technologynews2.php">Apple maintains prices on new iPhones despite inflation</a></li>
					<li><a class="articleLink" href="technologynews1.php">New space telescope shows Jupiter's auroras, tiny moons</a></li>
					<li><a class="articleLink" href="sportsnews3.php">Nepal lose to Bangladesh 3-1 in the final of SAFF Women's Championship</a></li>
					<li><a class="articleLink" href="sportsnews2.php">15-year-old makes debut for Arsenal in easy win at Brentford</a></li>
					<li><a class="articleLink" href="sportsnews1.php">Messi sends PSG two points clear with Lyon win</a></li>
					<li><a class="articleLink" href="localnews4.php">Pharmacies in front of Bir Hospital demolished</a></li>
					<li><a class="articleLink" href="localnews3.php">CIAA settled 17,169 complaints in 2021-22</a></li>
					<li><a class="articleLink" href="localnews2.php">Former PMs autobiography launched</a></li>
                    <li><a class="articleLink" href="localnews1.php">Bus accident claims seven lives, 25 injured</a></li>

				</ul>
			</article>
		</main>

		<footer>
			&copy; Northampton News 2017
		</footer>

	</body>
</html>
