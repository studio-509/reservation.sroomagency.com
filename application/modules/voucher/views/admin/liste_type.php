<div class="block_admin">

  <a class="btn_actions button pull-right _voucher_update" data-id="">Ajouter un nouveau type de carte</a>

  <?php

  if(empty($voucher_type))

  {

    echo (' <div class="alert-message alert-ok"><p>Aucun résultat</p></div>');

  }

  else {

    ?>

    <table id="table_annonces" class="table_list" width="100%" border="0" cellspacing="0" cellpadding="0">

      <thead>

        <tr>

          <th class="col01 first">Titre</th>

          <th class="col01">Active</th>
		  
		  <th class="col01">Visible</th>

          <th class="col01">Description</th>

          <th class="col01">Prix</th>

          <th class="col07 last">Actions</th>

        </tr>

      </thead>

      <tbody>

        <?php

        $i = 0;

        foreach($voucher_type as $val){

          $class = ($i%2 == 0)?"even":"odd";

          ?>

          <tr class="<?php echo $class; ?>" id="_tr<?=$val->id?>">

            <td class="col01 first"><?=$val->titre?></td>

            <td class="col01"><?=($val->active == 1)?'OUI':'NON'?></td>
			
			<td class="col01"><?=($val->visible == 1)?'OUI':'NON'?></td>

            <td class="col01"><?=$val->description?></td>

            <td class="col01"><?=$val->prix?></td>

            <td class="col07 last">

              <ul class="list-action">
			    <li><a class="btn_actions btn_details _voucher_update" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>
                <li><a class="btn_actions btn_supp _voucher_delete" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></li>
              </ul>

            </td>

          </tr>

          <?php $i++; } ?>

        </tbody>

      </table>

    </div>

    <?php } ?>
	
	
	<div><h2 class="top15">Données communes aux cartes cadeaux</h2>
	
	<div class="block_admin clear top15">

      <table id="table_cgv" class="table_list" width="100%" border="0" cellspacing="0" cellpadding="0">

        <thead>

          <tr>

            <th class="col01 first">Descriptif</th>

            <th class="col01 last">Action</th>

          </tr>

        </thead>

        <tbody>

          <tr>

            <td class="col01 first"><?=$descriptif->cgv?></td>

            <td class="col01 last">

              <ul class="list-action">

                <li><a class="btn_actions btn_details _desc_update"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>

              </ul>

            </td>

          </tr>

        </tbody>

      </table>

    </div>

    <div class="block_admin clear top15">

      <table id="table_cgv" class="table_list" width="100%" border="0" cellspacing="0" cellpadding="0">

        <thead>

          <tr>

            <th class="col01 first">Conditions Générales de Vente</th>

            <th class="col01 last">Action</th>

          </tr>

        </thead>

        <tbody>

          <tr>

            <td class="col01 first"><?=$cgv->cgv?></td>

            <td class="col01 last">

              <ul class="list-action">

                <li><a class="btn_actions btn_details _cgv_update"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>

              </ul>

            </td>

          </tr>

        </tbody>

      </table>

    </div>
	
	</div>
	



