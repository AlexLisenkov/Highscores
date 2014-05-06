<?php if ($data): ?>
<table class="table table-striped">
	<tr >
		<th style="width:1% text-align: right;">&nbsp;</th>
		<th style="width:1% text-align: right;">&nbsp;</th>
		<th style="width:1% text-align: right;">&nbsp;</th>
		<th style="text-align: right;"><h1><?php echo ucfirst($data[0]->username); ?></h1></th>		
			<th style="width:1%; text-align: center; line-height: 60px">- VS -</th>
		<th><h1><?php echo ucfirst($data[1]->username); ?></h1></th>
		<th style="width:1%">&nbsp;</th>
		<th style="width:1%">&nbsp;</th>
		<th style="width:1%">&nbsp;</th>
	</tr>
	<tr style="background-color: none; background: linear-gradient(to bottom, #11cc00, #0ea300); color: white;">
		<th style="width:1% text-align: right;">&nbsp;</th>
		<th style="width:1% text-align: right;">Rank</th>
		<th style="width:1% text-align: right;">Level</th>
		<th style="text-align: right;">Xp</th>		
			<th style="width:1%; text-align: center;">Skill</th>
		<th>Xp</th>
		<th style="width:1%">Level</th>
		<th style="width:1%">Rank</th>
		<th style="width:1%">&nbsp;</th>
	</tr>

	<?php foreach (valid_skills() AS $row): ?>
	<tr>
		<th style="width:1%"><div class="<?php if( $data[0]->xp($row) == $data[1]->xp($row) ){ echo 'even'; } elseif( $data[0]->xp($row) > $data[1]->xp($row) ){ echo 'higher'; } else { echo 'lower'; }?>">&nbsp;</div></th>
		<td style="text-align: right;"><?php echo $data[0]->rank($row); ?></td>
		<td style="text-align: right;"><?php echo $data[0]->level($row); ?></td>
		<td style="text-align: right;"><?php echo $data[0]->xp($row); ?></td>
			<td style="font-weight: bold; text-align: center;"><?php echo ucfirst($row); ?></td>
		<td><?php echo $data[1]->xp($row); ?></td>
		<td><?php echo $data[1]->level($row); ?></td>
		<td><?php echo $data[1]->rank($row); ?></td>
		<th style="width:1%"><div class="<?php if( $data[1]->xp($row) == $data[0]->xp($row) ){ echo 'even'; } elseif( $data[1]->xp($row) > $data[0]->xp($row) ){ echo 'higher'; } else { echo 'lower'; }?>">&nbsp;</div></th>
	</tr>
	<?php endforeach; ?>

</table>
<?php else: ?>
<div class="alert alert-error">
	<h4>Error!</h4>
	The user `<strong><?php echo ucfirst($user); ?></strong>` you tried to look-up doesn't exist. Please try again with a different name.
</div>
<?php endif; ?>