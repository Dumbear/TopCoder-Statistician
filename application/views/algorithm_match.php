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
							<th>Handle</th>
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
<?php		foreach ($results[$division - 1] as $result) {
				$old_rating = (int)$result->old_rating;
				$new_rating = (int)$result->new_rating;
				$rating_change = ($old_rating === $new_rating ? '' : ($old_rating < $new_rating ? '▲' : '▼')) . (string)abs($old_rating - $new_rating);
				$challenge_points = (double)$result->challenge_points;
?>
						<tr>
							<td><a href="<?php echo algorithm_room_url($match->id, $result->coder_id); ?>"><?php echo $result->division_rank; ?></a></td>
							<td><a href="algorithm/coder/<?php echo $result->coder_id; ?>" class="coder <?php echo get_rating_css($new_rating); ?>"><?php echo $result->handle; ?></a></td>
							<td><?php echo sprintf('%.2f', $result->final_points); ?></td>
<?php			if ((int)$match->type === 1) { ?>
							<td><?php echo (int)$result->advanced === 1 ? 'Y' : 'N'; ?></td>
<?php			} ?>
<?php			for ($level = 1; $level <= 3; ++$level) {
					$problem_id = eval("return \$result->problem{$level}_id;");
					$problem_points = (double)eval("return \$result->problem{$level}_final_points;");
					$problem_status = eval("return \$result->problem{$level}_status;");
					$problem_language = eval("return \$result->problem{$level}_language;");
					if ($problem_status === 'Passed System Test') {
?>
							<td><a href="algorithm/source_code/<?php echo $result->match_id; ?>/<?php echo $result->coder_id; ?>/<?php echo $problem_id; ?>" target="_blank" style="font-family: monospace">[+]</a> <span class="result <?php echo get_language_css($problem_language); ?>"><?php echo sprintf('%.2f', $problem_points); ?></span></td>
<?php				} else { ?>
							<td><span class="result <?php echo get_problem_status_css($problem_status); ?>"><?php echo $problem_status; ?></span></td>
<?php				} ?>
<?php			} ?>
							<td>+<?php echo $result->n_successful_challenges; ?>/-<?php echo $result->n_failed_challenges; ?> = <span class="bonus <?php echo get_challenge_points_css($challenge_points); ?>"><?php echo sprintf('%.2f', $challenge_points); ?></span></td>
							<td><span class="rating <?php echo get_rating_css($new_rating); ?>"><?php echo $new_rating; ?></span></td>
							<td><span class="rating-change <?php echo get_rating_change_css($old_rating, $new_rating); ?>"><?php echo $rating_change; ?></span></td>
							<td><?php echo $result->new_volatility; ?></td>
						</tr>
<?php		}?>
					</tbody>
				</table>
			</div>
		</div>
<?php	} ?>
	</div>
</div>
