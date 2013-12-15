<?php foreach($posts as $post): ?>

	<article>

		<!-- Give the option to delete if this was your post -->
			<?php if($post['user_id']==$user->user_id):?>
            	<div class = "row-fluid">
					<div class = "span2">
						<img src = '<?=$user->avatar ?>' alt = "user" class = "img-polaroid">
				</div>
				<div class = "span8" >
			<?php if($post['first_name']): ?>
				<h4><?=$post['first_name']?> <?=$post['last_name']?>:</h4>
			<?php endif; ?>
	<blockquote><?=$post['content']?></blockquote>
				</div>

		<!-- Section to edit / delete posts -->
				<div class = "span1 edit_post" >
		<br><br>
			<a href = '/posts/edit_post/<?=$post['post_id']?>' ><i class="icon-edit"></i></a>
				</div>
				<div class = "span1 delete_post" >
		<br><br>
			<a href = '/posts/delete_post/<?=$post['post_id']?>' ><i class="icon-remove"></i></a>
				</div>
					</div>

			<?php else: ?>
				<div class = "row-fluid">
					<div class = "span2">
						<img src = '/uploads/avatars/<?=$post['avatar']?>' alt = "user" class="img-polaroid">
				</div>
					<div class="span8">
			<?php if($post['first_name']): ?>
		<h4><?=$post['first_name']?> <?=$post['last_name']?>:</h4>
			<?php endif; ?>
	<blockquote class = "other_user"><?=$post['content']?></blockquote>
				</div>
					<div class="span2">

					</div>
					</div>
<?php endif; ?>

		<!-- Display the time stamp when the post was first created -->
				<div class = "faded" style = "text-align: right">
					<time datetime="<?=Time::display($post['created'],'m/d/y g:i A')?>" >
						<?=Time::display($post['created'], 'm/d/y g:i A')?>
					</time>
				</div>

	</article>

<?php endforeach; ?>