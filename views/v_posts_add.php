<!-- Error handling if a user tried to submit an empty post -->
	<?php if(isset($error)): ?>
		<div class='error' align = "center">

			Cannot submit empty post! Please try again.
		<br><br>
		</div>
	<?php endif; ?>


<!-- if a $post_id has been set, this means that the user is actually editing a prior post.
User needs to be redirected to posts/p_edit/post_id instead -->

	<?php if(isset($post_id)): ?>
		<form method='POST' action='/posts/p_edit/<?=$post_id?>'>
	<?php else: ?>
		<form method='POST' action='/posts/p_add'>
	<?php endif; ?>

<div class="row-fluid">
	<div class = "span12" align = "center">

<!-- if the $post_id is set, then pre-populate text area with prior post -->
		<textarea name='content' id='content' rows="3"><?php if(isset($post_id)): ?><?=$post?><?php endif; ?></textarea>

	</div>
	<div class = "span12" align = "center">
		<button type='submit' value='Post'><i class = "icon-pencil"></i>Post!</button>
	</div>
</div>


</form>