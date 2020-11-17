<div class="row">

<div class="col-xs-12 col-sm-4 col-md-6">
	<div class="block_admin">
	<table class="table_list" width="100%" cellspacing="2" cellpadding="2">
		<thead>
            <tr>
            	<th class="col01 first" colspan="2">Liste des variables disponibles<?php 
				if(preg_match('/MSIE/i',$_SERVER['HTTP_USER_AGENT'])){
			echo "IE";
		}
		else {
			echo "n'est pas IE";
		}
		?></th>
             </tr>
        </thead>
        <tbody>
			<tr class="even">
				<td>__PRENOM__</td>
				<td>Prénom du joueur qui a effectué la réservation</td>
			</tr>
			<tr class="odd">
				<td>__DATE__</td>
				<td>Date de la partie</td>
			</tr>
			<tr class="even">
				<td>__HEURE__</td>
				<td>Prénom du joueur qui a effectué la réservation</td>
			</tr>
			<tr class="odd">
				<td>__SCENARIO__</td>
				<td>Titre du scénario</td>
			</tr>
			<tr class="even">
				<td>__DESCRIPTIF__</td>
				<td>Descriptif du scénario</td>
			</tr>
			<tr class="odd">
				<td>__ADRESSE__</td>
				<td>Adresse de la salle</td>
			</tr>
			<tr class="even">
				<td>__PRIX__</td>
				<td>Somme à régler avant la partie (réservation téléphonique)</td>
			</tr>
			<tr class="odd">
				<td>__NOMBRE__</td>
				<td>Nombre d'équipiers du joueur</td>
			</tr>
        </tbody>
	</table>
    </div>
</div>

		<?php
    	if(empty($emails))
			echo ('<div class="alert-message alert-ok"><p>Aucun résultat</p></div>');
		else {
		?>
<div class="col-xs-12 col-sm-4 col-md-6">
	<div class="block_admin">
    	<table id="table_annonces" class="table_list" width="100%" border="0" cellspacing="0" cellpadding="0">
        	<thead>
            <tr>
            	<th class="col01 first">Liste des emails automatisés</th>
                <th class="col07 last">Actions</th>
             </tr>
             </thead>
             <tbody>
			 <?php
				$i = 0;
				foreach($emails as $val){
					$class = ($i%2 == 0)?"even":"odd";
				 ?>
				 <tr class="<?php echo $class; ?>" id="_tr<?=$val->id?>">
                     <td class="col01 first"><?=$val->action_detail?></td>
					 <td class="col07 last">
						<ul class="list-action">
							<li><a class="btn_actions btn_details _email_update" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>
						</ul>
					 </td>
				  </tr>
			  <?php $i++; } ?>
              </tbody>
        </table>
	</div>
</div>

<a id="_test_patch_ie">Test patch IE</a>

</div>
        <?php } ?>
