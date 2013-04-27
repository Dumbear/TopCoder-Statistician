<div class="body">
	<div>
		<div><h2>Top <?php echo $limit; ?> Division Ranks</h2></div>
		<div class="container">
<?php	for ($division = 1; $division <= 2; ++$division) { ?>
			<div class="<?php echo $division === 1 ? 'left' : 'right'; ?>-column">
				<div class="heading">Division <?php echo $division; ?></div>
				<table class="tight">
					<thead>
						<tr>
							<th>Rank</th>
							<th>Match</th>
							<th>Coder</th>
							<th>Points</th>
						</tr>
					</thead>
					<tbody>
<?php		foreach ($results[$division - 1] as $result) { ?>
						<tr>
							<td><?php echo $this->algorithm_html->match_result($result, 'rank'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'match'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'coder'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'points'); ?></td>
						</tr>
<?php		}?>
					</tbody>
				</table>
			</div>
<?php	} ?>
			<div></div>
		</div>
	</div>
</div>
