<div class="block_admin clear">		
		
		<a class="btn_actions button pull-right _admin_update" data-id="">Ajouter un nouvel administrateur</a>

		<?php

    	if(empty($admins))

			echo (' <div class="alert-message alert-ok"><p>Aucun résultat</p></div>');

		else {

		?>



            <table id="table_annonces" class="table_list" width="100%" border="0" cellspacing="0" cellpadding="0">

                <thead>

                <tr>

                    <th class="col01 first">Nom</th>

                    <th class="col02 ">Email</th>

                    <th class="col07 last">Actions</th>

                 </tr>

                 </thead>

                 <tbody>

                 <?php

                    $i = 0;

                    foreach($admins as $val){

                        $class = ($i%2 == 0)?"even":"odd";

                     ?>

                     <tr class="<?php echo $class; ?>" id="_tr<?=$val->id?>">

                         <td class="col01 first"><?=$val->civil . ' ' . $val->prenom . ' ' . $val->nom?></td>

                         <td class="col02"><?=$val->email?></td>

                         <td class="col07 last">

                            <ul class="list-action">
                                <li><a class="btn_actions btn_details _admin_update" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>
                                <li><a class="btn_actions btn_mdp _admin_password" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-renvoyer-mot-de-passe.png" title="Renvoyer mot de passe" alt="Mdp" /></a></li>
                                <li><a class="btn_actions btn_supp _admin_delete" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></li>

                            </ul>

                         </td>

                      </tr>

                  <?php $i++; } ?>

                  </tbody>

            </table>

        </div>



        <?php

	        echo $pagination;

	        }

	    ?>

