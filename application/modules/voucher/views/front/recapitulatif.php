<div class="row">
    <div class="col-xs-12 col-sm-12">
	<h3>Carte cadeau</h3>
	<ul class="list_form">
		<li>Votre choix : <strong>"<?=$v->titre?>" à <?=$v->prix?>,00 €</strong></li>
		<li>Offerte par <strong><?=$v->civil?> <?=$v->prenom?> <?=$v->nom?></strong> à <strong><?=$v->civil_d?> <?=$v->prenom_d?> <?=$v->nom_d?></strong></li>
	</ul>    
	</div>
	</div>
	<p class="lireCGV mt16 mb16">Pour finaliser votre commande, cliquez sur le bouton "Procéder au paiement".<br>
		Vous allez être redirigé vers la page de paiement en ligne afin de régler votre carte cadeau. <br><br>
		<strong>Une fois le paiement validé, un lien pour télécharger votre carte cadeau vous sera proposé.</strong></p>
	<p class="lireCGV mt16 mb16">
	<input type="checkbox" name="cgv" id="order_cgv" value="1"> J’ai lu et j’accepte les conditions générales de vente associées à ma réservation <a href="https://<?php echo SITE_URL; ?>/cgv-escape-game-s-room-agency-montauban" title="Voir les CGV" target="_blank">(voir les CGV)</a>
	<p class="error masque2" id="error_cgv">Vous devez accepter les conditions générales de vente !</p></p>
		
			<div class="row">
				<!--	<div class="col-xs-12 col-sm-6 pull-right text-center mt32">
					<a class="_order_voucher_process button btnValider">Procéder au paiement</a> </div>-->
				<div class="col-xs-12 col-sm-12 pull-right text-center mt32"><a class="_order_voucher_process button btnValider">Procéder au paiement</a></div>
			</div>
					
			<!--	<div class="col-xs-12 col-sm-6 text-center mt16">
					<a class="button btn_L btn_annul mt16" onClick="_inPop.close()">Annuler</a> /div>
				<div class="col-xs-12 col-sm-6 text-center mt16"><input type="button" class="button btn_L btn_annul mt32" value="Annuler" onClick="_inPop.close(this)" /></div>
			</div>-->