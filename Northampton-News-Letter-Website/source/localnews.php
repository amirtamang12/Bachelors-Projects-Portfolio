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
				<div class="login"> <a href="login.php"> <button>Log In</button> </a></div>
				<div class="reg"> <a href="register.php"> <button>Register</button> </a> </div>
			</ul>
		</nav>
		<img src="images/banners/randombanner.php"/>
		<main>
			<article>
				<h2>Local News</h2>
				<p>These are Local News</p>
				<ul>
                    <li><a class="articleLink" href="localnews4.php">Pharmacies in front of Bir Hospital demolished</a></li>
				    <li><a class="articleLink" href="localnews3.php">CIAA settled 17,169 complaints in 2021-22</a></li>
				    <li><a class="articleLink" href="localnews2.php">Former PMs autobiography launched</a></li>
                    <li><a class="articleLink" href="localnews1.php">Bus accident claims seven lives, 25 injured</a></li>
				</ul>
			</article>
		</main>

		<footer>
			&copy; Northampton News 2017
			<div class="logout"> <a href="logout.php"> <button>Logout</button> </a> </div>
		</footer>

	</body>
</html>
