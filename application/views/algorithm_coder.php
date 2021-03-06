<div class="body">
	<div>
		<div>
			<h2><a href="<?php echo algorithm_coder_url($coder->id); ?>" class="coder <?php echo $this->algorithm_html->rating_class($coder->algorithm_rating); ?>"><?php echo $coder->handle; ?></a></h2>
			<span><?php echo $coder->real_name; ?></span>
		</div>
		<div class="container">
			<div class="heading">Statistics</div>
			<div class="left-column" style="width: 28%">
				<table class="tight">
					<tr>
						<td>//TODO</td>
					</tr>
				</table>
			</div>
			<div class="right-column" style="width: 68%">
<?php	$n_matches = array(0, 0);
		$submission_info = array(
			array(array(0, 0, 0, 0), array(0, 0, 0, 0), array(0, 0, 0, 0)),
			array(array(0, 0, 0, 0), array(0, 0, 0, 0), array(0, 0, 0, 0))
		);
		$challenge_info = array(0, 0);
		foreach ($results as $result) {
			$division = (int)$result->division;
			++$n_matches[$division - 1];
			$challenge_info[0] += (int)$result->n_successful_challenges;
			$challenge_info[1] += (int)$result->n_failed_challenges;
			for ($level = 1; $level <= 3; ++$level) {
				$status = eval("return \$result->problem{$level}_status;");
				if ($status === 'Opened' || $status === 'Compiled') {
					++$submission_info[$division - 1][$level - 1][0];
				} else if ($status === 'Passed System Test') {
					++$submission_info[$division - 1][$level - 1][1];
				} else if ($status === 'Challenge Succeeded') {
					++$submission_info[$division - 1][$level - 1][2];
				} else if ($status === 'Failed System Test') {
					++$submission_info[$division - 1][$level - 1][3];
				}
			}
		}
?>
<?php	for ($division = 1; $division <= 2; ++$division) { ?>
				<div>
					<div class="heading">Division <?php echo $division; ?> <span class="sub">(<?php echo $n_matches[$division - 1]; ?> Matches)</span></div>
					<table class="tight">
						<thead>
							<tr>
								<th>Problem</th>
								<th># Submissions</th>
								<th># Failures (Challenge)</th>
								<th># Failures (System Test)</th>
								<th>Accuracy</th>
							</tr>
						</thead>
						<tbody>
<?php		$info_sum = array(0, 0, 0, 0);
			for ($level = 1; $level <= 3; ++$level) {
				$info = $submission_info[$division - 1][$level - 1];
				$info_sum[0] += $info[0];
				$info_sum[1] += $info[1];
				$info_sum[2] += $info[2];
				$info_sum[3] += $info[3];
?>
							<tr>
								<td>Level <?php echo $level; ?></td>
								<td><?php echo $info[1] + $info[2] + $info[3]; ?></td>
								<td><?php echo $info[2]; ?></td>
								<td><?php echo $info[3]; ?></td>
<?php			if ($info[1] + $info[2] + $info[3] === 0) { ?>
								<td>N/A</td>
<?php			} else { ?>
								<td><?php echo sprintf('%.2f %%', 100.0 * $info[1] / ($info[1] + $info[2] + $info[3])); ?></td>
<?php			} ?>
							</tr>
<?php		} ?>
							<tr class="split">
								<td>Overall</td>
								<td><?php echo $info_sum[1] + $info_sum[2] + $info_sum[3]; ?></td>
								<td><?php echo $info_sum[2]; ?></td>
								<td><?php echo $info_sum[3]; ?></td>
<?php		if ($info_sum[1] + $info_sum[2] + $info_sum[3] === 0) { ?>
								<td>N/A</td>
<?php		} else { ?>
								<td><?php echo sprintf('%.2f %%', 100.0 * $info_sum[1] / ($info_sum[1] + $info_sum[2] + $info_sum[3])); ?></td>
<?php		} ?>
							</tr>
						</tbody>
					</table>
				</div>
<?php	} ?>
				<div>
					<div class="heading">Challenges</div>
					<table class="tight">
						<thead>
							<tr>
								<th># Challenges</th>
								<th># Failures</th>
								<th>Total Points</th>
								<th>Accuracy</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $challenge_info[0] + $challenge_info[1]; ?></td>
								<td><?php echo $challenge_info[1]; ?></td>
								<td><?php echo sprintf('%.2f', $challenge_info[0] * 50.0 - $challenge_info[1] * 25.0); ?></td>
<?php	if ($challenge_info[0] + $challenge_info[1] === 0) { ?>
								<td>N/A</td>
<?php	} else { ?>
								<td><?php echo sprintf('%.2f %%', 100.0 * $challenge_info[0] / ($challenge_info[0] + $challenge_info[1])); ?></td>
<?php	} ?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div></div>
		</div>
		<div class="container">
			<div class="heading">Competition History</div>
			<div>
<?php	if (count($results) === 0) { ?>
				<span class="info">No competition history.</span>
<?php	} ?>
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
<?php	foreach ($results as $result) { ?>
						<tr>
							<td><?php echo $this->algorithm_html->match_result($result, 'match'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'division'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'rank'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'points'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'problem1'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'problem2'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'problem3'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'challenge'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'new_rating'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'rating_change'); ?></td>
							<td><?php echo $this->algorithm_html->match_result($result, 'new_volatility'); ?></td>
						</tr>
<?php	}?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
