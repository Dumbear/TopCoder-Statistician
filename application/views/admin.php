<div class="body">
	<div class="content">
		<div class="container">
			<div class="heading">Algorithm</div>
			<div>
				<table class="gadget fixed">
					<tr><th colspan="2">Status</th></tr>
					<tr><td>Last Update:</td><td><?php echo $algorithm_status->timestamp; ?></td></tr>
					<tr>
						<td>Current Status:</td>
						<td><?php echo $algorithm_status->status === null ? 'All Done.' : $algorithm_status->status; ?></td>
					</tr>
<?php	if (count($pending_algorithm_matches) === 0) { ?>
					<tr><td>Pending Matches:</td><td>None.</td></tr>
<?php	} else { ?>
					<tr><td rowspan="<?php echo count($pending_algorithm_matches) + 1; ?>">Pending Matches:</td><th>Match</th></tr>
<?php		foreach ($pending_algorithm_matches as $match) { ?>
					<tr><td><a href="javascript: void(0)"><?php echo $match->short_name; ?></a></td></tr>
<?php		} ?>
<?php	} ?>
<?php	if (count($pending_algorithm_coders) === 0) { ?>
					<tr><td>Pending Coders:</td><td>None.</td></tr>
<?php	} else { ?>
					<tr><td rowspan="<?php echo count($pending_algorithm_coders) + 1; ?>">Pending Coders:</td><th>Coder</th></tr>
<?php		foreach ($pending_algorithm_coders as $coder) { ?>
					<tr><td><?php echo $coder->handle; ?></td></tr>
<?php		} ?>
<?php	} ?>
					<tr><td>Log:</td><td><?php echo $algorithm_status->log; ?></td></tr>
					<tr><th colspan="2">Operation</th></tr>
<?php	if ($algorithm_status->locked === '0') { ?>
					<tr><td>Refresh &amp; Update Match Archive:</td><td><a href="admin/algorithm/refresh_and_update">Refresh &amp; Update</a></td></tr>
<?php	} else { ?>
					<tr><td>Refresh &amp; Update Match Archive:</td><td><a href="javascript: void(0)" style="text-decoration: line-through">Refresh &amp; Update</a></td></tr>
<?php	} ?>
					<tr><td rowspan="5">Add Coders:</td><th>Coder</th></tr>
					<tr><td><input id="input_add_coders" type="text" style="width: 16em" /></td></tr>
					<tr><td class="notice">* Like <span style="font-style: oblique">handle1:realname1 handle2:realname2...</span></td></tr>
<?php	if ($algorithm_status->locked === '0') { ?>
					<tr><td><a id="a_add_coders" href="javascript: void(0)">Add All</a></td></tr>
<?php	} else { ?>
					<tr><td><a href="javascript: void(0)" style="text-decoration: line-through">Add All</a></td></tr>
<?php	} ?>
				</table>
			</div>
		</div>
	</div>
	<div class="sidebar">
		<div class="container">
		</div>
	</div>
	<div></div>
</div>
<script type="text/javascript">
$("#a_add_coders").click(function() {
	//TODO: escape string
	window.location.href = "admin/algorithm/add_coders/" + $("#input_add_coders").val();
});
</script>
