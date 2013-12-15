<h2>

	<?php if($user): ?>
		Welcome to <?=APP_NAME?>, <?=$user->first_name?>
	<?php else: ?>
		Welcome to <?=APP_NAME?>!
	<?php endif; ?>

</h2>

	<?=APP_NAME?> is a micro-blog that allows you to make share your serendipitous adventures and follow your friends!
	<br><br>
		You can:
		<ul>
			<li>Edit your Posts</li>
			<li>Delete your Posts</li>
			<li>Upload a Profile Photo</li>
			<li>Share latest news</li>
		</ul>

	<br><br>
	Life is full of different events and adventures. <?=APP_NAME?> is fun! Share them here!

