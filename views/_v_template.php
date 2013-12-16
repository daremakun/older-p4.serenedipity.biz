<!DOCTYPE html>
	<html>
		<head>
        	<title><?php if(isset($title)) echo $title; ?></title>

        	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

			<!-- Common CSS/JSS -->
			<link rel="stylesheet" href="/css/bootstrap.css" type="text/css">
			<link rel="stylesheet" href="/css/main.css" type="text/css">
			<link href='http://fonts.googleapis.com/css?family=Lily+Script+One' rel='stylesheet' type='text/css'>

			<!-- Controller Specific CSS/JS -->
			<?php if(isset($client_files_head)) echo $client_files_head; ?>

        	<!-- Controller Specific JS/CSS -->
        	<?php if(isset($client_files_head)) echo $client_files_head; ?>
        
		</head>

	<body>

	<div id='menu'>
			<br>
			<!-- placeholder to be able to capitalize the app name on the home page -->
			<?php $placeholder = APP_NAME ?>
			<a href='/'><strong><span id = "logo"><?php echo strtoupper($placeholder); ?></span></strong></a>
		<br>

		<!-- Menu for users who are logged in -->
		<br>
		<?php if($user): ?>
			<ul>
				<li>
					<a href='/users/profile'>Profile</a>
				</li>
				<li>
					<a href='/posts/add'>New Post</a>
				</li>
				<li>
					<a href='/posts/index'>All Posts</a>
				</li>
				<li>
					<a href='/posts/following'>Friends' Posts</a>
				</li>
				<li>
					<a href='/posts/users'>All Users</a>
				</li>
				<li>
					<a href='/users/logout'>Logout</a>
				</li>
			</ul>
		<!-- Menu options for users who are not logged in -->
		<?php else: ?>
			<ul>
				<li>
					<a href='/users/signup'>Sign up</a>
				</li>
				<li>
					<a href='/users/login'>Log in</a>
				</li>
			</ul>
		<?php endif; ?>
		<br>
	</div>

	<div class = "main_body">
		<div id = "main_content">
				<?php if(isset($content)) echo $content; ?>
		</div>

		<?php if(isset($client_files_body)) echo $client_files_body; ?>
	</div>
	<div id = "footer" >
		<div id = "tagline">
			<br>
			
				<?php if(isset($title)) echo $title; else echo APP_TAGLINE?>
				
			<br>
			<div class = "faded" >
				Copyright © <?=APP_NAME?> is an application for <a href="http://www.extension.harvard.edu/courses/dynamic-web-applications">
				Harvard Extension CSCI-E-15</a> /
			</div>
		</div>
	</div>
         <script src="/js/bootstrap.min.js"></script>
	</body>
</html>