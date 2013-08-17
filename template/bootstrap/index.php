<h1><?php echo ucfirst($skill); ?> Highscores</h1>
<table class="table">

	<tr>
		<th style="width:1%">#</th>
		<th style="width:1%">Username</th>
		<th style="width:1%">Level</th>
		<th>Experience</th>
	</tr>

	<?php $i = 0; foreach ($data AS $row): ?>
	<tr>
		<td><?php echo (++$i) + $plus; ?>.</td>
		<td><?php echo anchor('user/'. $row->username, ucfirst($row->username)); ?></td>
		<td><?php echo $row->level($skill); ?></td>
		<td><?php echo number_format($row->{$skill.'_xp'}); ?></td>
	</tr>
	<?php endforeach; ?>

</table>

<!-- Pagination -->
<?php if ($total_items > $items_per_page): ?>
	<?php
	// Calculate pagination offsets
	$max = $current_page + 5;
	$min = $current_page - 5;

	if ($min <= 0)
		$min = 1;

	if ($max > ceil($total_items / $items_per_page))
		$max = ceil($total_items / $items_per_page);
	?>

	<div class="pagination">
		<ul>
			<?php for ($page = $min; $page <= $max; $page++): ?>
				<li<?php if ($page === $current_page): ?> class="active"<?php endif; ?>><?php echo anchor('index/'. $skill .'/' . $page, $page); ?></li>
			<?php endfor; ?>
		</ul>
	</div>
<?php endif; ?>
