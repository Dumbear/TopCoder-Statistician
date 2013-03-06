<div class="body">
	<div>
		<div><h2>Top <?php echo $limit; ?> Division Ranks</h2></div>
<?php	$division_array = array(1, 2); ?>
		<div class="container">
<?php	foreach ($division_array as $division_key => $division) { ?>
			<div class="<?php echo $division_key === 0 ? 'left' : 'right'; ?>-column">
				<div class="heading">Division <?php echo $division; ?></div>
				<table class="tight">
					<thead>
						<tr>
							<th>Rank</th>
							<th>Match</th>
							<th>Handle</th>
							<th>Points</th>
						</tr>
					</thead>
					<tbody>
<?php		foreach ($results[$division_key] as $result) {
				$new_rating = (int)$result->new_rating;
?>
						<tr>
							<td><?php echo $result->division_rank; ?></td>
							<td><a href="algorithm/match/<?php echo $result->match_id; ?>" class="match"><?php echo $result->short_name; ?></a></td>
							<td><a href="algorithm/coder/<?php echo $result->coder_id; ?>" class="coder <?php echo get_rating_css($new_rating); ?>"><?php echo $result->handle; ?></a></td>
							<td><?php echo sprintf('%.2f', $result->final_points); ?></td>
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
