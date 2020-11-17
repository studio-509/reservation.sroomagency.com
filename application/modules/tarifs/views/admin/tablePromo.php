<?php

if(empty($promo))

echo (' <div class="alert-message alert-ok"><p>Aucun résultat</p></div>');

else {

  ?>

  <table id="table_promo" class="table_list" width="100%" border="0" cellspacing="0" cellpadding="0">

    <thead>

      <tr>

        <th class="col01 first">Titre</th>

        <th class="col02 ">Valeur</th>

        <th class="col02 ">Salles</th>

        <th class="col02 ">Date début</th>

        <th class="col02 ">Date fin</th>

        <th class="col02 ">Code</th>

        <th class="col07 last">Actions</th>

      </tr>

    </thead>

    <tbody>

      <?php foreach ($promo as $val) { ?>

        <tr>

          <td class="col01 first"><?=$val->titre?></td>

          <td class="col02"><?= $val->taux." ".$val->type_promo ?></td>

          <td class="col02">

            <?php

            if ($val->is_global == '1')

            {

              echo "Global";

            }

            else

            {

              $room = explode('|',$val->salles);

              echo '<ul class="list-unstyled">';

              foreach ($room as $promo) {

                foreach ($salles as $salle) {

                  if ($promo == $salle->id)

                  {

                    echo '<li>'.$salle->nom.'</li>';

                  }

                }

              }

              echo "</ul>";

            }

            ?>

          </td>

          <td class="col02"><?php echo date('d/m/Y',strtotime($val->date_debut));?></td>

          <td class="col02"><?php echo date('d/m/Y',strtotime($val->date_fin));?></td>

          <td class="col02"><?= (!empty($val->code)?$val->code:'')?></td>

          <td class="col07 last">

            <ul class="list-action">

              <li><a class="btn_actions btn_details _promo_update" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>

              <li><a class="btn_actions btn_details _promo_delete" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></li>

            </ul>

          </td>

        </tr>

        <?php } ?>

      </tbody>

    </table>

    <?php } ?>

