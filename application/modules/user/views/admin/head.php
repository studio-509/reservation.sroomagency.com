<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administration | Centrale de réservation de <?php echo APP_NAME; ?></title>

    <meta name="robots" content="noindex, nofollow" />
    <link type="image/x-icon" href="<?php echo APP_URL; ?>/assets/img/icon/favicon.ico" rel="shortcut icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- css des modules -->
		<link rel="stylesheet" href="/assets/css/bootstrap.css" type="text/css" />
		<link rel="stylesheet" href="/assets/css/jquery-ui.theme.min.css" type="text/css" />
    <link rel="stylesheet" href="/assets/css/jquery-ui.min.css" type="text/css" />

	<?php foreach($module_css as $css){ ?>
		<link rel="stylesheet" href="<?php echo $css; ?>" type="text/css" />
	<?php } ?>

	<script type="text/javascript">var base_url = "<?php echo APP_URL; ?>"; </script>

	<!-- librairies selon module -->
	<?php foreach($lib_js as $lib){ ?>
		<script type="text/javascript" src="<?php echo $lib; ?>"></script>
	<?php } ?>

	<script type="text/javascript" src="/assets/js/tools.js"></script>
	<!-- js des modules -->
	<?php foreach($module_js as $js){ ?>
		<script type="text/javascript" src="<?php echo $js; ?>"></script>
	<?php } ?>
	
</head>
