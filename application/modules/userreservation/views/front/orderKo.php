<p>Votre paiement a été annulé ou refusé par la plate-forme bancaire de paiement.</p>
<?php if($resavoucher == 'voucher'): ?>
<p>Si vous souhaitez recommencer votre achat de carte cadeau, suivez ce <a href="<?php echo APP_URL.'/voucher'; ?>">lien</a></p>
<?php else: ?>
<p>Si vous souhaitez recommencer votre réservation, suivez ce <a href="<?php echo APP_URL.'/reservation'; ?>">lien</a></p>
<?php endif; ?>
<p>N'hésitez pas à nous contacter si le problème persiste.</p>
<br /><br />
<p>L'équipe de l'Escape Game <?php echo SITE_EXP; ?> Montauban vous remercie.</p>
