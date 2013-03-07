<div class="body">
	<div>
		<div><h2>Top <?php echo $limit; ?> Problem Ranks</h2></div>
<?php	$level_array = array(1, 2, 3);
		$division_array = array(1, 2);
?>
<?php	foreach ($level_array as $level_key => $level) { ?>
		<div class="container">
			<div class="heading">Level <?php echo $level; ?></div>
<?php		foreach ($division_array as $division_key => $division) { ?>
			<div class="<?php echo $division_key === 0 ? 'left' : 'right'; ?>-column">
				<div class="heading">Division <?php echo $division; ?></div>
				<table class="tight">
					<thead>
						<tr>
							<th>Rank</th>
							<th>Match</th>
							<th>Handle</th>
							<th>Time</th>
							<th>Points</th>
						</tr>
					</thead>
					<tbody>
<?php			foreach ($results[$level_key][$division_key] as $result) {
					$new_rating = (int)$result->new_rating;
					$problem_time = (int)eval("return \$result->problem{$level}_time;");
					$problem_points = (double)eval("return \$result->problem{$level}_final_points;");
					$problem_status = eval("return \$result->problem{$level}_status;");
					$problem_language = eval("return \$result->problem{$level}_language;");
?>
						<tr>
							<td><?php echo eval("return \$result->problem{$level}_rank;"); ?></td>
							<td><a href="algorithm/match/<?php echo $result->match_id; ?>" class="match"><?php echo $result->short_name; ?></a></td>
							<td><a href="algorithm/coder/<?php echo $result->coder_id; ?>" class="coder <?php echo get_rating_css($new_rating); ?>"><?php echo $result->handle; ?></a></td>
							<td><?php echo sprintf('%d:%02d:%02d.%03d', $problem_time / 3600000, $problem_time / 60000 % 60, $problem_time / 1000 % 60, $problem_time % 1000); ?></td>
							<td><span class="result <?php echo get_language_css($problem_language); ?>"><?php echo sprintf('%.2f', $problem_points); ?></span></td>
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
