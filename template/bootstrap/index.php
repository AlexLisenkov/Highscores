<h1><?php echo ucfirst($skill); ?> Highscores</h1>
<table class="table">

	<tr>
		<th style="width:1%">#</th>
		<th style="width:1%">Username</th>
		<th>Experience</th>
	</tr>

	<?php $i = 0; foreach ($data AS $row): ?>
	<tr>
		<td><?php echo (++$i) + $plus; ?>.</td>
		<td><?php echo anchor('user/'. $row->username, ucfirst($row->username)); ?></td>
		<td><?php echo number_format($row->{$skill.'_xp'}); ?></td>
	</tr>
	<?php endforeach; ?>

</table>