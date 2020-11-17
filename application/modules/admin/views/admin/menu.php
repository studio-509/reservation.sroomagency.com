<nav id="menu_admin">
	<ul class="menu">
		<li class="<?php if($section == "reservations")echo "active"; ?>">
			<a href="/admin/reservations">Réservations</a>
		</li>
		<li class="<?php if($section == "clients")echo "active"; ?>">
			<a href="/admin/clients">Clients</a>
		</li>
		<li class="<?php if($section == "games")echo "active"; ?>">
			<a href="/admin/games">Parties jouées</a>
		</li>
		<li class="<?php if($section == "salles")echo "active"; ?>">
			<a href="/admin/salles">Salles</a>
		</li>
		<li class="<?php if($section == "tarifs")echo "active"; ?>">
			<a href="/admin/tarifs">Tarifs | Promotions</a>
		</li>
		<li class="<?php if($section == "vouchers")echo "active"; ?>">
			<a href="/admin/vouchers">Carte Cadeaux</a>
		</li>
		<li class="<?php if($section == "emails")echo "active"; ?>">
			<a href="/admin/emails">Emails</a>
		</li>
		<li class="<?php if($section == "rh")echo "active"; ?>">
			<a href="/admin/rh">RH</a>
		</li>
		<li class="<?php if($section == "admins")echo "active"; ?>">
			<a href="/admin/admins">Admins</a>
		</li>
		<li class="<?php if($section == "stats")echo "active"; ?>">
			<a href="/admin/stats">Statistiques</a>
		</li>
	</ul>
</nav>

