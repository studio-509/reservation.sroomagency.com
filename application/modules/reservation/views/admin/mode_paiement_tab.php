<table>
		<tr>
			<th>Mode de paiement</th>
			<th>Référence</th>
			<th>Montant</th>
			<th></th>
		</tr>
		<?php 
		foreach ($mode_paiement as $mp) {
		?>
			<tr>
				<td><?=$mp->modep?></td>
				<td><?=$mp->reference?></td>
				<td><?=$mp->montant?></td>
				<td><a class="btn_actions btn_supp _del_paiement" data-id="<?=$mp->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></td>
			</tr>
		<?php
		}
		?>
	</table>