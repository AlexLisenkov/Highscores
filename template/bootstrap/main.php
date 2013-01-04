<!DOCTYPE html>
<html lang="en">
<head>
	<?php $template->build('metadata'); ?>
</head>
<body>
	<div class="container">
		<div class="row-fluid">
			<div class="span3">
				<?php $template->build('left_sidebar'); ?>
			</div>
			<div class="span6">
				<?php echo $view; ?>
			</div>
			<div class="span3">
				<?php $template->build('right_sidebar'); ?>
			</div>
		</div>
	</div>
</body>