<?php foreach($users as $person):?>

    <!-- Display each users' photo, name, and date joined. And option to follow/unfollow -->
	<div id = "users" class = "row-fluid">
		<div class = "span1">
			<img src = '/uploads/avatars/<?=$person['avatar']?>'>
		</div>
		<div class = "span5">
			<strong>
				<?php if (isset($person['last_name'])){ echo $person['first_name']." ".$person['last_name'];}
                else echo $person['first_name'];?>
			</strong>
			<br>

	<!-- Follow if not following or unfollow if followed -->
	<?php if(isset($connections[$person['user_id']])): ?>
		<span class = "faded">
		<a href = '/posts/unfollow/<?=$person['user_id']?>'>
			Unfollow
		</a>
	</span>
	<?php else: ?>
		<a href = '/posts/follow/<?=$person['user_id']?>'>
			Follow
		</a>
	<?php endif ?>
		</div>

	<!-- Display time stamp when the user joined the application -->
		<div class = "span6 text-right">
		<span class = "faded">
	<?php echo "member since ".date('M d Y', $person['created']);?>
		</span>
		</div>

	</div>

<?php endforeach; ?>