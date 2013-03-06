<div class="body">
	<div class="content">
		<div class="container">
			<div class="heading">Match Archive</div>
			<ul class="menu">
				<li><a href="algorithm" class="choice<?php if ($type === 'all') echo ' current' ?>">All</a></li>
				<li>|</li>
				<li><a href="algorithm/srm" class="choice<?php if ($type === 'srm') echo ' current' ?>">Single Round Match</a></li>
				<li><a href="algorithm/tour" class="choice<?php if ($type === 'tour') echo ' current' ?>">Tournament</a></li>
			</ul>
			<div></div>
			<div class="pagination"><?php echo $pagination; ?></div>
<?php	$count = 0; ?>
			<div class="left-column">
				<table class="data match-list">
					<thead>
						<tr>
							<th>Match</th>
							<th style="width: 10em">Time</th>
						</tr>
					</thead>
					<tbody>
<?php	while ($count < 50 && $count < count($matches)) { ?>
						<tr>
							<td class="match"><a href="algorithm/match/<?php echo $matches[$count]->id; ?>" class="match"><?php echo $matches[$count]->short_name; ?></a></td>
							<td class="time"><?php echo $matches[$count]->time; ?></td>
						</tr>
<?php		++$count; ?>
<?php	} ?>
					</tbody>
				</table>
			</div>
			<div class="right-column">
				<table class="data match-list">
					<thead>
						<tr>
							<th>Match</th>
							<th style="width: 10em">Time</th>
						</tr>
					</thead>
					<tbody>
<?php	while ($count < 100 && $count < count($matches)) { ?>
						<tr>
							<td class="match"><a href="algorithm/match/<?php echo $matches[$count]->id; ?>" class="match"><?php echo $matches[$count]->short_name; ?></a></td>
							<td class="time"><?php echo $matches[$count]->time; ?></td>
						</tr>
<?php		++$count; ?>
<?php	} ?>
					</tbody>
				</table>
			</div>
			<div></div>
			<div class="pagination"><?php echo $pagination; ?></div>
		</div>
	</div>
	<div class="sidebar">
		<div class="container">
			<div class="heading">Gadgets</div>
			<table class="gadget">
				<tr><th>Statistics</th></tr>
				<tr><td><a href="algorithm/all_coders">All Coders</a></td></tr>
 				<tr><th>Records</th></tr>
				<tr><td><a href="algorithm/top_ranks">Top Division Ranks</a></td></tr>
				<tr><td><a href="algorithm/top_problem_ranks">Top Problem Ranks</a></td></tr>
				<!-- <tr><td><a href="javascript: void(0)">First Coders to Achieve Highest Ratings</a></td></tr>
				<tr><th>Tools</th></tr>
				<tr><td><a href="javascript: void(0)">Compete between WHUACMers</a></td></tr> -->
			</table>
		</div>
		<div class="container">
			<div class="heading">Admin</div>
<?php	if ($this->session->userdata('admin') === false) { ?>
			<form action="admin/login" method="post" class="login">
				<table class="gadget">
					<tr><th colspan="3">Login</th></tr>
					<tr><td>Key:</td><td><input name="key" type="password" style="width: 100%" /></td><td><input type="submit" value="Login" /></td></tr>
				</table>
			</form>
<?php	} else { ?>
			<table class="gadget">
				<tr><th>Manage</th></tr>
				<tr><td><a href="admin">Enter</a></td></tr>
				<tr><td><a href="admin/logout">Logout</a></td></tr>
			</table>
<?php	} ?>
			<table class="gadget">
				<tr><th colspan="2">Update</th></tr>
				<tr><td>Last Update:</td><td><?php echo $status->timestamp; ?></td></tr>
			</table>
		</div>
	</div>
	<div></div>
</div>
