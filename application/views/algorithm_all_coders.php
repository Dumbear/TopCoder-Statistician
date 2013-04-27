<div class="body">
	<div>
		<div class="container">
			<div class="heading">All Coders</div>
			<div>
<?php	if (count($coders) === 0) { ?>
				<span class="info">No coders.</span>
<?php	} ?>
				<table class="tight"<?php if (count($coders) === 0) echo ' style="display: none"'; ?>>
					<thead>
						<tr>
							<th>Rank</th>
							<th>Handle</th>
							<th>Real Name</th>
							<th># Matches</th>
							<th>Rating</th>
							<th>Max Rating</th>
							<th>Min Rating</th>
							<th>Volatility</th>
						</tr>
					</thead>
					<tbody>
<?php	$rank = 0; ?>
<?php	foreach ($coders as $coder) { ?>
<?php		++$rank; ?>
						<tr>
							<td><?php echo $rank; ?></td>
							<td><?php echo $this->algorithm_html->coder($coder, 'handle'); ?></td>
							<td><?php echo $this->algorithm_html->coder($coder, 'real_name'); ?></td>
							<td><?php echo $this->algorithm_html->coder($coder, 'n_matches'); ?></td>
							<td><?php echo $this->algorithm_html->coder($coder, 'rating'); ?></td>
							<td><?php echo $this->algorithm_html->coder($coder, 'max_rating'); ?></td>
							<td><?php echo $this->algorithm_html->coder($coder, 'min_rating'); ?></td>
							<td><?php echo $this->algorithm_html->coder($coder, 'volatility'); ?></td>
						</tr>
<?php	} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
