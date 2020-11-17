<?php if($resavoucher == 'voucher'): ?>
<p>Votre paiement a été validé. Votre achat de carte cadeau est enregistré</p>
<p>Vous recevrez une confirmation par courrier électronique.</p>
<p>&nbsp;</p>
<p>Voici le lien vous permettant de télécharger votre carte cadeau.<br />
<a href="<?=$link?>" target="_blank"><?=$link?></a><br />
<em>(la création de la carte peut prendre plusieurs secondes)</em></p>

<?php elseif ($partieofferte == 'ok'): ?>
<p>Votre réservation est enregistrée.</p>
<p>Vous recevrez une confirmation par courrier électronique.</p>

<?php else: ?>
<p>Votre paiement a été validé. Votre réservation est enregistrée.</p>
<p>Vous recevrez une confirmation par courrier électronique.</p>

<?php endif; ?>

<p>&nbsp;</p>
<p>L'équipe de l'Escape Game <?php echo SITE_EXP; ?> Montauban vous remercie.</p>
