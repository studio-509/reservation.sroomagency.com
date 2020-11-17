<!-- <?php if($prix == 0 ){
    ?>
    <h1>Erreur</h1>
    <?php
} else {
    ?> -->

<div class="row">
  <div class="col-xs-12 col-sm-6">
	<h3><strong>Ma réservation</strong></h3>
    <ul class="list_form">
      <li class="ttAventure"><?=$room->nom?></li>
      <li>Le <?=dateFr($jour)?> à <?=$horaire?></li>
      <li>Nombre de participants : <span class="rappelPrix"><?=$joueurs?></span></li>
	</ul>
	<p><em><a class="_modif_resa" id="modif_resa_calendar" data-id="<?=$id?>">Modifier ma réservation</a></em></p>
    
	<?php $titreagents = FALSE; for($i = 1; $i < PLAYERS_MAX; $i++) {$var = 'joueur' . $i;  if(isset($$var) && $$var != '') $titreagents = TRUE;} if ($titreagents == TRUE) echo "<h4><strong>E-mails des agents de mon équipe</strong></h4>";?> 
        <span>
          <?php
          for($i = 1; $i < PLAYERS_MAX; $i++)
          {
            $var = 'joueur' . $i;
            if(isset($$var) && $$var != '')
            echo $$var . '<br />';
          }
          ?>
        </span>
  </div>
  <div class="col-xs-12 col-sm-6">
    <h3><strong>Mes coordonnées</strong></h3>
    <ul class="list_form">
      <li class="recap_nom_resa"><strong><?=$civil . ' ' . $prenom . ' ' . $nom?></strong></li>
      <li><?=$email?></li>
      <li><?=$tel?></li>
    </ul>
	<p><em><a class="_modif_resa" id="modif_resa_coord" data-id="<?=$id?>">Modifier mes coordonnées</a></em></p>
	<p>&nbsp;</p>
	
	<ul class="list_form">
      <li>Montant de la partie : <span class="rappelPrix"><?=number_format($prix,2,',','')?> €</span></li>
      <?php if($remise != 0 || $montant_voucher != 0): ?>
        <li>Montant de votre réduction : <span class="rappelPrix"><?=number_format($remise+$montant_voucher,2,',',' ')?> €</span></li>
      <?php endif; ?>
      <li class="ttAventure">Montant à régler : <span class="rappelPrix"><?=number_format($total,2,',',' ')?> €</span></li>
	  </ul>
      <ul class="list_form"> 
	  <?php if($remise != 0 || $montant_voucher != 0): ?>
		<p>&nbsp;</p>
		<?php else: ?>
		<p><a class="_modif_resa" id="modif_resa_voucher" data-id="<?=$id?>">Je bénéficie d'une promo ou d'une carte cadeau</a></p>
		<?php endif; ?>
		</ul>
  </div>

</div>
    <p class="lireCGV mt16 mb16 mt32">
      <input type="checkbox" name="cgv" id="order_cgv" value="1"> J’ai lu et j’accepte les conditions générales de vente associées à ma réservation <a href="https://<?php echo SITE_URL;?>/cgv-escape-game-s-room-agency-montauban " title="Voir les CGV" target="_blank">(voir les CGV)</a>
      <p class="error masque2" id="error_cgv">Vous devez accepter les conditions générales de vente !</p>
    </p>
    <div class="row">
      <div class=" col-xs-12 col-sm-12 text-center mt16">
        <?php if($total > 0): ?>
          <a class="_order_process button btnValider" data-id="<?=$id?>">Procéder au paiement</a>
        <?php else: ?>
          <form name="voucherOk" method="post" id="id_voucher_ok_form" action="/reservation/orderOk">
            <input type="hidden" name="id_resa" id="id_resa_recap" value="<?=$id?>" />
			<input type="hidden" name="voucher" value="<?=$voucher?>" />
			<input type="hidden" name="partieofferte" value="ok" />
            <a class="_add_resa_total_nul form-submit button btnValider">Valider ma réservation </a>
          </form>
        <?php endif; ?>
      </div>
    </div>
    <div id="formOrder"></div>
    <!-- <?php } ?> -->
