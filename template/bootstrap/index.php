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
	<div class="pagination">
		<ul>
			<?php for ($page = 1; $page <= ceil($total_items / $items_per_page); $page++): ?>
				<li><?php echo anchor('index/'. $skill .'/' . $page, $page); ?></li>
			<?php endfor; ?>
		</ul>
	</div>
<?php endif; ?>
