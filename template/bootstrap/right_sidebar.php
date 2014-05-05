<?php if (config('site.homepage')): ?>
<div class="well">
	<?php echo anchor(config('site.homepage'), '<i class="icon-home icon-white"></i> Return to homepage', 'class="btn btn-large btn-primary btn-block"'); ?>
</div>
<?php endif; ?>

<div class="well">
	<form method="post" action="<?php echo base_url('view'); ?>">
		<label>View personal highscores</label>
		<input type="text" placeholder="Username..." name="username" />
		
		<button type="submit" class="btn btn-primary">Look-up</button>
	</form>
</div>

<div class="well">
	<form method="post" action="<?php echo base_url('gocompare'); ?>">
		<label>Compare users</label>
		<input type="text" placeholder="John" name="user[]" />
		<input type="text" placeholder="Peter" name="user[]" />
		<button type="submit" class="btn btn-primary">Start</button>
	</form>
</div>

<div class="well">
	<form method="post" action="<?php echo base_url('gotopage'); ?>">
		<label>Go to page</label>
		<input type="text" placeholder="Page number..." name="pagetogo" />
		<input type="hidden" name="current_skill" value="<?php echo path(1); ?>" />
		
		<button type="submit" class="btn btn-primary">Go</button>
	</form>
</div>