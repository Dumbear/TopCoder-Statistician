<div class="body">
	<div>
		<div><h2>Top <?php echo $limit; ?> Problem Ranks</h2></div>
<?php	for ($level = 1; $level <= 3; ++$level) { ?>
		<div class="container">
			<div class="heading">Level <?php echo $level; ?></div>
<?php		for ($division = 1; $division <= 2; ++$division) { ?>
			<div class="<?php echo $division === 1 ? 'left' : 'right'; ?>-column">
				<div class="heading">Division <?php echo $division; ?></div>
				<table class="tight">
					<thead>
						<tr>
							<th>Rank</th>
							<th>Match</th>
							<th>Coder</th>
							<th>Time</th>
							<th>Points</th>
						</tr>
					</thead>
					<tbody>
<?php			foreach ($results[$level - 1][$division - 1] as $result) { ?>
						<tr>
							<td><?php echo $this->algorithm_html->match_result($result, 'rank'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'match'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'coder'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, "problem{$level}_time"); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, "problem{$level}"); ?></td>
						</tr>
<?php			}?>
					</tbody>
				</table>
			</div>
<?php		} ?>
			<div></div>
		</div>
<?php	} ?>
	</div>
</div>
