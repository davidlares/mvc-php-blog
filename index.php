<!DOCTYPE html>
<html>
<head>
	<title>DavidPress</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
	<div class="container">

		<div class="row">
			<div class="col-md-12">
				<h1>DavidPress</h1>
			</div>
		</div>

		<?php foreach($blogPosts as $blogPost):  ?>
		<div class="row">
			<div class="col-md-8">
				<div class="blog-post">
					<h2><?php echo $blogPost['title'] ?></h2>
					<p>Jan 1. 2020 by <a href="">David Lares</a></p>
					<div class="blog-post-image">
						<img src="http://placehold.it/700x100">
						<br><br>
					</div>
					<div class="blog-post-content">
					<?php echo $blogPost['content'] ?>
					</div>
				</div>

			</div>
			<div class="col-md-4">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>
		<?php endforeach ?>
 

		<div class="row">
			<div class="col-md-12 text-center">
				<br><br>
				<footer>
					DavidPress 2017 | Derechos reservados
					<br>
					<a href="admin/index.php">Admin Panel</a>
				</footer>
			</div>
		</div>	
	</div>
</body>
</html>