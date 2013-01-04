<div class="well sidebar-nav">
	<ul class="nav nav-list">
		<?php foreach (valid_skills() AS $row): ?>
			<li<?php if(path(1) === $row || $row === 'overall' && path(1) === '') echo ' class="active"'; ?>><?php echo anchor('index/'. $row, ucfirst($row)); ?></li>
		<?php endforeach; ?>
	</ul>
</div>