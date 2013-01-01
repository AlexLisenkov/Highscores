<div class="well">
	<?php echo anchor(config('site.homepage'), '<i class="icon-home icon-white"></i> Return to homepage', 'class="btn btn-large btn-primary btn-block"'); ?>
</div>

<div class="well">
	<form method="post" action="<?php echo base_url('view'); ?>">
		<label>View personal highscores</label>
		<input type="text" placeholder="Username..." name="username" />
		
		<button type="submit" class="btn btn-primary">Look-up</button>
	</form>
</div>