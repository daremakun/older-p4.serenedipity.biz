<div class="sereneload">
		<?php if(!$user): ?>
			<?php Router::redirect("/users/login"); ?>
		<?php else: ?>
	<h2>This is <?=$user->first_name?><?="&nbsp"?><?=$user->last_name?>'s profile.</h2>
		<?php endif; ?>
	<br/>
		<?php if($user) echo $user->first_name;?>
			<?php echo ' '; ?>
		<?php if($user) echo $user->last_name; ?>
			<?php echo '<br/>'; ?>
		<?php if($user) echo 'email: '.$user->email; ?>
			<?php echo '<br/>'; ?>
		<?php if($user)
        		$convert_time = $user->created;
        		echo 'You have been a member since: ';
        		echo date('M d Y', $convert_time);
		?>
	<br/>
	<hr/>
	<br/>

		<?php foreach($posts as $post): ?>
			<article>
				<h4>This post was added on:
			<time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
				<?=Time::display($post['created'])?>
			</time>                
    			</h4>
	<div>
		<p><?=$post['content']?><br></p></div><a href='/posts/edit/<?=$post['post_id']; ?>' > <u>Edit this post</u></a>
			</article>
	<br/>
		<?php endforeach; ?>
	<br/>
				<h3>Follow: <a href='/posts/users'>Other Posters</a></h3>
	</div>
	
</div>