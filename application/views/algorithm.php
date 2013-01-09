<div class="body">
	<div class="sidebar">
		<div class="container">
			<div class="heading">Gadgets</div>
			<table class="gadget">
				<tr><th>Statistics</th></tr>
				<tr><td><a href="">All WHUACMers</a></td></tr>
				<tr><th>Records</th></tr>
				<tr><td><a href="">First Coders to Achieve Highest Ratings</a></td></tr>
				<tr><td><a href="">Top 20 Division Ranks</a></td></tr>
				<tr><td><a href="">Top 20 Problem Ranks</a></td></tr>
				<tr><th>Tools</th></tr>
				<tr><td><a href="">Compete between WHUACMers</a></td></tr>
			</table>
		</div>
	</div>
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
			<div>
				<table class="data">
					<thead>
						<tr>
							<th class="match">Match</th>
							<th class="time">Time</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
