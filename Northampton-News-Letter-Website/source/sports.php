<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="styles.css"/>
		<title>Sports - Northampton News</title>
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
				<h2>Sports News</h2>
				<p>These are Sports News</p>

				<ul>
                    <li><a class="articleLink" href="sportsnews3.php">Nepal lose to Bangladesh 3-1 in the final of SAFF Women's Championship</a></li>
					<li><a class="articleLink" href="sportsnews2.php">15-year-old makes debut for Arsenal in easy win at Brentford</a></li>
					<li><a class="articleLink" href="sportsnews1.php">Messi sends PSG two points clear with Lyon win</a></li>
				</ul>
			</article>
		</main>

		<footer>
			&copy; Northampton News 2017
			<div class="logout"> <a href="logout.php"> <button>Logout</button> </a> </div>
		</footer>

	</body>
</html>
