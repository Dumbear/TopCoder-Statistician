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
							<td><a href="algorithm/coder/<?php echo $coder->id; ?>" class="coder <?php echo get_rating_css($coder->algorithm_rating); ?>"><?php echo $coder->handle; ?></a></td>
							<td><?php echo $coder->real_name; ?></td>
							<td><?php echo $coder->n_algorithm_matches; ?></td>
							<td><span class="rating <?php echo get_rating_css($coder->algorithm_rating); ?>"><?php echo $coder->algorithm_rating; ?></span></td>
							<td><span class="rating <?php echo get_rating_css($coder->max_rating); ?>"><?php echo $coder->max_rating; ?></span></td>
							<td><span class="rating <?php echo get_rating_css($coder->min_rating); ?>"><?php echo $coder->min_rating; ?></span></td>
							<td><?php echo $coder->algorithm_volatility; ?></td>
						</tr>
<?php	}?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
