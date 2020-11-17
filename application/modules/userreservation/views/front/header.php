<body class="_front">
	<?php echo modules::run('popin/front/Popin/index',$this->data); ?>
    <div id="global">
    	<div id="header-wrapper" class="wrapper bgcolor01">
            <header id="header" class="container">
            	<div class="col-xs-12 col-sm-4">
                	<a id="logo" href="https://<?php echo SITE_URL; ?>"><img src="https://<?php echo SITE_URL;?>/sites/all/themes/<?php echo SITE_THEME_NAME; ?>/images/logo.png" alt="Escape Game <?php echo SITE_EXP;?> MONTAUBAN"/></a>
                </div>
				
                <div class="col-xs-12 col-sm-8">
                    
                        <ul class="menu nav  pull-right ">
                            <li class=""><a href="https://<?php echo SITE_URL; ?>" title="" class="int-collapse-menu">Accueil</a></li>
                            <li class="active"><a href="https://<?php echo SITE_URL; ?>#concept" title="" class="int-collapse-menu">Concept</a></li>
                            <li class=""><a href="https://<?php echo SITE_URL; ?>#missions" title="" class="int-collapse-menu">Missions</a></li>
							<li class=""><a href="<?php echo APP_URL; ?>/voucher" title="" class="int-collapse-menu">Cadeau</a></li>
							<li class=""><a href="https://<?php echo SITE_URL; ?>#tarifs" title="" class="int-collapse-menu">Tarifs</a></li>
                            <li class=""><a href="https://<?php echo SITE_URL; ?>#faq" title="" class="int-collapse-menu">FAQ</a></li>
                            <li class=""><a href="https://<?php echo SITE_URL; ?>#contact" title="" class="int-collapse-menu">Contact</a></li>
                        </ul>	

                </div>
            </header>
            	
        </div>
        
        <section id="main-wrapper" class="wrapper mb48">
            <div id="main" class="clearfix">
            	<section id="content" class="clearfix">
                		<div class="titleWrapper mt32">
							<h2>ESCAPE GAME Montauban</h2>
							<h1>Réserver</h1>
							<h3><?php echo SITE_EXP;?></h3>
						</div>
                   <div><p style="text-align:center;">Cloture des réservations 4 heures avant.<br>Pour une réservation de dernière minute ou toute autre question sur votre réservation,<br> appelez nous au <br><strong><?=SRA_TEL?></strong></p><br><br></div>
				
<!--fin header-->
