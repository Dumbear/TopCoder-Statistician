<div class="body">
	<div>
		<div><h2><a href="<?php echo algorithm_match_url($match->id); ?>" class="match heading"><?php echo $match->full_name; ?></a></h2></div>
<?php	for ($division = 1; $division <= 2; ++$division) { ?>
		<div class="container">
			<div class="heading">Division <?php echo $division; ?></div>
			<div>
<?php		if (count($results[$division - 1]) === 0) { ?>
				<span class="info">No participants.</span>
<?php		} ?>
				<table class="tight"<?php if (count($results[$division - 1]) === 0) echo ' style="display: none"'; ?>>
					<thead>
						<tr>
							<th>Rank</th>
							<th>Coder</th>
							<th>Points</th>
<?php		if ((int)$match->type === 1) { ?>
							<th>Ad.</th>
<?php		} ?>
							<th>Level 1</th>
							<th>Level 2</th>
							<th>Level 3</th>
							<th>Challenge</th>
							<th>Rating</th>
							<th>Rating Change</th>
							<th>Volatility</th>
						</tr>
					</thead>
					<tbody>
<?php		foreach ($results[$division - 1] as $result) { ?>
						<tr>
							<td><?php echo $this->algorithm_html->match_result($result, 'rank'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'coder'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'points'); ?></td>
<?php			if ((int)$match->type === 1) { ?>
							<td><?php echo $this->algorithm_html->match_result($result, 'advanced'); ?></td>
<?php			} ?>
							<td><?php echo $this->algorithm_html->match_result($result, 'problem1'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'problem2'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'problem3'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'challenge'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'new_rating'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'rating_change'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'new_volatility'); ?></td>
						</tr>
<?php		}?>
					</tbody>
				</table>
			</div>
		</div>
<?php	} ?>
	</div>
</div>
