<table id="reservation_table" class="table_list" width="100%" border="0" cellspacing="0" cellpadding="0">
  <thead>
    <tr>
      <th class="col01 first">Date</th>
      <th class="col02 ">Scénario</th>
      <th class="col07 last">Actions</th>
    </tr>
  </thead>

  <tbody>

    <?php

    $i = 0;

    foreach($reservations as $val){

      if($val->jour < date('Y-m-d') || ($val->jour == date('Y-m-d') && $val->horaire < date('H')))

      {

        $class = 'passe';

        $etat = 'cloturé';

      }

      elseif($val->regle == 0 && $val->valide == 0)

      {

        $class = 'encours';

        $etat = 'en cours de réservation';

      }

      elseif($val->regle == 0 && $val->valide == 1)

      {

        $class = 'resa_alerte';

        $etat = 'Règlement avant le jeu';

      }

      else

      {

        $class = 'libre';

        $etat = 'Réservation validée';

      }

      ?>

      <tr class="<?=$class?>" id="_tr<?=$val->id?>">
        <td class="col01 first"><?=dateFr($val->jour)?> <?=$val->horaire?></td>
        <td class="col02"><?=$val->scenario?></td>
        <td class="col07 last">
			<a class="btn_actions btn_supp _reservation_delete" data-id="<?=$val->id?>" resindis="indispo"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a>
        </td>
      </tr>

      <?php $i++; } ?>

    </tbody>
  </table>