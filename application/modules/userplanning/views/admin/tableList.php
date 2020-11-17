<pre>

<?php

    if(empty($tarifs))

		echo (' <div class="alert-message alert-warning"><div class="warning-sign"></div><div>Attention ! Aucun tarif défini pour cette salle prévue pour '.$salle->nbmin.' à '.$salle->nbmax.' joueurs.</div></div>');

	else {

?>

</pre>

<?php if(!empty($empty['empty_we']) || !empty($empty['empty_sem'])){

    ?>

    <div class="alert-message alert-warning"><div class="warning-sign"></div><div>Attention ! Cette salle est prévue pour <?= $salle->nbmin ?> à <?=$salle->nbmax?> joueurs. Veuillez compléter le(s) tarif(s) manquant(s)

    <?php  if ( ! empty($empty['empty_sem']) ) {

        $nbe = count( $empty['empty_sem'] );

        echo ' pour les groupes de ';

        for ($i = 0; $i < $nbe ; $i++) {

            echo $empty['empty_sem'][$i];

            if($i < ($nbe - 2)){

                echo ', ';

            }

            if($i == ($nbe - 2)){

                echo ' et ';

            }

        }

    }?>

    joueurs en tarif réduit

    <?php if ( ! empty($empty['empty_we']) ) {

        if (!empty($empty['empty_sem'])){

            echo ' et pour les groupes de ';

        } else {

            echo ' pour les groupes de ';

        }

        $nbe = count( $empty['empty_we'] );

        for ($i = 0; $i < $nbe ; $i++) {

            echo $empty['empty_we'][$i];

            if($i < ($nbe - 2)){

                echo ', ';

            }

            if($i == ($nbe - 2)){

                echo ' et ';

            }

        } ?>

        joueurs en tarif plein</div></div>

        <?php } ?>

    <?php } ?>

    <table id="table-annonces" class="table_list" width="100%" border="0" cellspacing="0" cellpadding="0">

        <thead>

            <tr>

            	<th class="col01 first">Type de tarif</th>

            	<th class="col02 ">Nombre de joueurs</th>

            	<th class="col02 ">Tarif</th>

                <th class="col07 last">Actions</th>

            </tr>

        </thead>

        <tbody>

			<?php

				$i = 0;

				foreach($tarifs as $val):

					$class = ($i%2 == 0)?"even":"odd";

			?>

				<tr class="<?=$class?>" id="_tr<?=$val->id?>">

                    <td class="col01 first"><?=(($val->type == 'sem')?'Tarif réduit':( ($val->type == 'we')?'Tarif plein':'Tarif special') )?></td>

					<td class="col02"><?=$val->joueurs?></td>

					<td class="col02"><?=number_format($val->prix,2)?> €</td>

					<td class="col07 last">

						<ul class="list-action">

							<li><a class="btn_actions btn_details _tarif_update" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>

                            <li><a class="btn_actions btn_details _tarif_delete" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></li>

						</ul>

					</td>

				</tr>

			<?php

				$i++;

				endforeach;

			?>

        </tbody>

    </table>

<?php } ?>

