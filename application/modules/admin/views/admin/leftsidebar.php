<section id="left_sidebar" class="clearfix">
	<nav id="menu_admin">
		<ul class="menu">
			<li class="first <?php if($section == "dashboard")echo "active"; ?>">
            	<span><a href="/admin/dashboard">Tableau de bord</a></span>
            </li>
			<li class="<?php if($section == "timer")echo "active"; ?>">
            	<span><a href="/admin/timer">Gestion du jeu</a></span>
            </li>
            <li class="<?php if($section == "clients")echo "active"; ?>">
            	<span><a href="/admin/clients">Clients</a></span>
            </li>
            <li class="<?php if($section == "reservations")echo "active"; ?>">
            	<span><a href="/admin/reservations">Gestion des réservations</a></span>
            </li>
            <li class="<?php if($section == "salles")echo "active"; ?>">
            	<span><a href="/admin/salles">Gestion des salles</a></span>
            </li>
            <li class="<?php if($section == "tarifs")echo "active"; ?>">
            	<span><a href="/admin/tarifs">Gestion des tarifs</a></span>
            </li>
            <li class="<?php if($section == "emails")echo "active"; ?>">
            	<span><a href="/admin/emails">Gestion des emails</a></span>
            </li>
            <li class="<?php if($section == "admins")echo "active"; ?>">
            	<span><a href="/admin/admins">Gestion des administrateurs</a></span>
            </li>
         </ul>
     </nav>
</section>

<section id="content" class="clearfix">
