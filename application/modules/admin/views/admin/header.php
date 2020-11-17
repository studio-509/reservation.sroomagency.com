<body class="no-front">
	<?php echo modules::run('popin/front/Popin/index',$this->data); ?>
    <div id="global">
    	<div id="header-wrapper" class="wrapper bgcolor01">
            <header id="header" class="container">
                <div class="col-xs-12 col-sm-4 mb8 mt8">
                	<a id="logo" href="/admin/dashboard">Centrale de réservation de <?php echo APP_NAME; ?></a>
                </div>
				<div class="text-center mb8 mt8 col-sm-1"><span id="ejs_heure"></span></div>
				<div class="col-xs-12 col-sm-3 mt8 pull-right">
                    <div id="log_header">
                    	<div class="user_name pull-left">Bienvenue <strong><?php echo $user ?></strong></div>
                        <div class="pull-right"><a href="/admin/logout">déconnexion</a></div>
                    </div>
                     <div id="notification">
                     </div>

                 </div>
				 
            </header>
            <div id="menu-wrapper" class="wrapper">
            	<div class="container">
                	<?php $this->load->view('/admin/menu');?>
                </div>
            </div>
        </div>
        
        <section id="main-wrapper" class="wrapper">
            <div id="main" class="container clearfix">
            	<section id="content" class="clearfix">
<!--fin header-->
