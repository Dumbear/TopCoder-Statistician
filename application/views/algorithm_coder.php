<div class="body">
	<div>
		<div>
			<h2><a href="<?php echo algorithm_coder_url($coder->id); ?>" class="coder <?php echo get_rating_css($coder->algorithm_rating); ?>"><?php echo $coder->handle; ?></a></h2>
			<span><?php echo $coder->real_name; ?></span>
		</div>
		<div class="container">
			<div class="heading">Competition History</div>
			<div>
				<table class="tight"<?php if (count($results) === 0) echo ' style="display: none"'; ?>>
					<thead>
						<tr>
							<th>Match</th>
							<th>Div.</th>
							<th>Rank</th>
							<th>Points</th>
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
<?php	foreach ($results as $result) {
			$old_rating = (int)$result->old_rating;
			$new_rating = (int)$result->new_rating;
			$rating_change = ($old_rating === $new_rating ? '' : ($old_rating < $new_rating ? '▲' : '▼')) . (string)abs($old_rating - $new_rating);
			$challenge_points = (double)$result->challenge_points;
?>
						<tr>
							<td><a href="algorithm/match/<?php echo $result->match_id; ?>" class="match"><?php echo $result->short_name; ?></a></td>
							<td><?php echo $result->division; ?></td>
							<td><a href="<?php echo algorithm_room_url($result->match_id, $result->coder_id); ?>"><?php echo $result->division_rank; ?></a></td>
							<td><?php echo $result->final_points; ?></td>
<?php		for ($i = 1; $i <= 3; ++$i) {
				$problem_points = (double)eval("return \$result->problem{$i}_final_points;");
				$problem_status = eval("return \$result->problem{$i}_status;");
				$problem_language = eval("return \$result->problem{$i}_language;");
				if ($problem_status === 'Passed System Test') {
?>
							<td><span class="result <?php echo get_language_css($problem_language); ?>"><?php echo sprintf('%.2f', $problem_points); ?></span></td>
<?php			} else { ?>
							<td><span class="result <?php echo get_problem_status_css($problem_status); ?>"><?php echo $problem_status; ?></span></td>
<?php			} ?>
<?php		} ?>
							<td>+<?php echo $result->n_successful_challenges; ?>/-<?php echo $result->n_failed_challenges; ?> = <span class="bonus <?php echo get_challenge_points_css($challenge_points); ?>"><?php echo sprintf('%.2f', $challenge_points); ?></span></td>
							<td><span class="rating <?php echo get_rating_css($new_rating); ?>"><?php echo $new_rating; ?></span></td>
<?php		 ?>
							<td><span class="rating-change <?php echo get_rating_change_css($old_rating, $new_rating); ?>"><?php echo $rating_change; ?></span></td>
							<td><?php echo $result->new_volatility; ?></td>
						</tr>
<?php	}?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
