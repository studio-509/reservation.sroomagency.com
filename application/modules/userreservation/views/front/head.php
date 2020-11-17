<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Centrale de réservation de <?=SITE_EXP?></title>
    
    <meta name="robots" content="noindex, nofollow" />
    <link type="image/x-icon" href="<?php echo APP_URL; ?>/assets/img/icon/favicon.ico" rel="shortcut icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
    <!-- css des modules -->
    <link rel="stylesheet" href="/assets/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="https://<?=SITE_URL?>/sites/all/themes/<?=SITE_THEME_NAME?>/css/style.css" type="text/css" />
	<link rel="stylesheet" href="https://<?=SITE_URL?>/sites/all/themes/<?=SITE_THEME_NAME?>/css/editor.css" type="text/css" />
    <link rel="stylesheet" href="/assets/css/global.css" type="text/css" />
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
	
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-98435640-2', 'auto');
  ga('send', 'pageview');

	</script>
	
</head>