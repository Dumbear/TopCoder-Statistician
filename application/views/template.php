<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>WHUACM@TopCoder<?php if (isset($module)) echo " - {$module}"; ?></title>
	<base href="<?php echo site_url(); ?>" />
	<link rel="stylesheet" type="text/css" href="css/ui-darkness/jquery-ui-1.10.2.custom.min.css" />
	<link rel="stylesheet" type="text/css" href="shjs/css/sh_darkness.min.css" />
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.2.custom.min.js"></script>
	<script type="text/javascript" src="shjs/sh_main.min.js"></script>
	<script type="text/javascript" src="js/md5-min.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
</head>
<body>

<div class="header">
	<h1>WHUACM@TopCoder<?php if (isset($module)) echo " - {$module}"; ?></h1>
</div>

<?php echo $content; ?>

<div class="footer">
</div>

<div id="dialog-modal" style="display: none"></div>

</body>
</html>
