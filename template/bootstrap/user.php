<?php if ($data): ?>
<h1><?php echo ucfirst($user); ?> <a target="blank" style="font-size: 12pt;" href="<?php echo base_url("image/$user")?>">[image]</a></h1>
<table class="table table-striped">

	<tr>
		<th style="width:1%">Skill</th>
		<th>Xp</th>
		<th style="width:1%">Level</th>
		<th style="width:1%">Rank</th>
	</tr>

	<?php foreach (valid_skills() AS $row): ?>
	<tr>
		<td><?php echo ucfirst($row); ?></td>
		<td><?php echo $data->xp($row); ?></td>
		<td><?php echo $data->level($row); ?></td>
		<td><?php echo $data->rank($row); ?></td>
	</tr>
	<?php endforeach; ?>

</table>
<?php else: ?>
<div class="alert alert-error">
	<h4>Error!</h4>
	The user `<strong><?php echo ucfirst($user); ?></strong>` you tried to look-up doesn't exist. Please try again with a different name.
</div>
<?php endif; ?>