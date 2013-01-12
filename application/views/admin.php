<div class="body">
	<div class="content">
		<div class="container">
			<div class="heading">Algorithm</div>
			<div>
				<table class="gadget fixed">
					<tr><th colspan="2">Status</th></tr>
					<tr><td>Last Update:</td><td></td></tr>
					<tr>
						<td>Current Status:</td>
						<td><?php echo $admin_info->algorithm_status === null ? 'All Done.' : $admin_info->algorithm_status; ?></td>
					</tr>
<?php	if (count($pending_algorithm_matches) === 0) { ?>
					<tr><td>Pending Matches:</td><td>None.</td></tr>
<?php	} else { ?>
					<tr><td rowspan="<?php echo count($pending_algorithm_matches) + 1; ?>">Pending Matches:</td><th>Match</th></tr>
<?php		foreach ($pending_algorithm_matches as $match) { ?>
					<tr><td><?php echo $match->short_name; ?></td></tr>
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
					<tr><th colspan="2">Operation</th></tr>
					<tr><td>Refresh Match Archive:</td><td><a href="admin/algorithm/refresh">Refresh</a></td></tr>
<?php	if (count($new_algorithm_matches) === 0) { ?>
					<tr><td>New Matches:</td><td>None.</td></tr>
<?php	} else { ?>
					<tr><td rowspan="<?php echo count($new_algorithm_matches) + 2; ?>">New Matches:</td><th>Match</th></tr>
<?php		foreach ($new_algorithm_matches as $match) { ?>
					<tr><td><?php echo $match->short_name; ?></td></tr>
<?php		} ?>
					<tr><td><a href="admin/algorithm/add_matches">Add All</a></td></tr>
<?php	} ?>
					<tr><td rowspan="4">Add Coders:</td><th>Coder</th></tr>
					<tr><td><input id="input_add_coders" type="text" style="width: 16em" /></td></tr>
					<tr><td class="notice">* Use space to separate coders.</td></tr>
					<tr><td><a id="a_add_coders" href="javascript: void(0)">Add All</a></td></tr>
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
