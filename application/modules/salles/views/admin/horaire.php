<?php



$nb_set = count($horaire_set);

// var_dump($nb_set);

$date = new DateTime();

for ($i=0; $i < $nb_set; $i++) :

    $h = $horaire_set[$i];

    $d = new DateTime($h->set_date_begin);

    global $set_id;

    $set_id = $h->set_id;

    $set = array_filter($horaires , function($v,$k){

        global $set_id;

        return $v->fk_set_id == $set_id;

    }, ARRAY_FILTER_USE_BOTH);

    // var_dump($set);

    ?>

    <div class="table_wrapper <?=($i>0?' slide" style="display:none;"':' first"')?> id="table_<?= $set_id ?>">

        <table id="set<?=$set_id?>" class="table_list" width="100%" >

        <thead>

            <tr>

                <th colspan="9" class="col01 first text-center">

                <?php

                if ($d->format('Y-m-d') <= $date->format('Y-m-d')) { ?>

                    <span class="date_set">Horaires en cours (depuis le <?=$d->format('d-m-Y')?>)</span>

                        <?php if($nb_set > 1){

                            echo "<span class='next_set'>A venir &#9658;</span>";

                    }

                } else {

                    if($i > 0){

                        echo "<span class='prev_set'>&#9668; En cours</span>";

                        // var_dump($nb_set,$i);

                    } ?>

                    <span class="date_set pull-right"><span class="_date_info">HORAIRES A VENIR <?php if($d->format('d-m-Y') != '31-12-2099'){ echo '(à partir du '.$d->format('d-m-Y').'  )</span>'; } else {

                        echo 'Date à définir</span>';

                    }?>

                    <a class="btn_actions btn_supp _set_date_update"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier date" alt="Update" /></a>

                    <select class="hidden _select_date" name="DateStart">

                        <option class="_option_date" value="" selected>Sélectionner le jour</option>

                        <?php

                            $monday = new DateTime('next monday');

                            for ($i=0; $i < 26; $i++) {

                                echo '<option class="_option_date" value="'.$monday->format('Y-m-d').'">Lundi '.$monday->format('d-m-Y').'</option>';

                                $monday->add(new DateInterval('P7D'));

                            }

                        ?>

                    </select>

                    <span class="hidden wrapper_date_btn">

                        <a class="btn_actions btn_supp _set_date_validate" attr-id="<?=$set_id?>">Valider</a>

                        <a class="btn_actions btn_supp _set_date_cancel">Annuler</a>

                    </span>

                    <?php if($i < ($nb_set - 1) ){

                        echo "<span class='next_set'>&#9658;</span>";

                        }

                    }?>

                    </th>

                </tr>

            <tr>

                <th class="col01 first text-center">Heure</th>

                <th class="col01 text-center th-day"><span class="day" style="font-weight:400;">Jours</span></th>



                <th class="col07 last text-center">Actions</th>

            </tr>

        </thead>

        <tbody>

            <?php foreach ($set as $key):

                $all = FALSE;

                if($key->hor_day == 'all'){

                    $all = TRUE;

                } else {

                    $days = explode(',',$key->hor_day);

                }?>



                <tr>

                    <td class="col01 first text-center" id="hor_<?=$key->hor_id?>"><?=$key->hor_start?></td>

                    <td class="col01 text-center"> <span class="td-day">

                    <?php

                        $jour = [1 => 'Lun', 2 => 'Mar', 3 => 'Mer', 4 => 'Jeu', 5 => 'Ven', 6 => 'Sam', 7 => 'Dim' ];

                        for($j = 1; $j <= 7 ; $j++){?>

                            <label><input type="checkbox" id="<?=$key->hor_id.'_'. $j ?>" disabled <?= ( ($all || in_array($j, $days) ) ? 'checked="checked"' : '') ?>><?=$jour[$j]?></label>

                        <?php }

                    ?>

                </span></td>

                    <td class="col07 last text-center">

                        <ul class="list-action">

							<li><a class="btn_actions btn_supp _horaire_update" data-id="<?=$key->hor_id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>

                            <li><a class="btn_actions btn_supp _horaire_delete" data-id="<?=$key->hor_id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></li>

                            <li><a class="btn_actions btn_supp _horaire_validate hidden">Valider</a></li>

                            <li><a class="btn_actions btn_supp _horaire_cancel hidden" data-id="<?=$key->hor_id?>">Annuler</a></li>

						</ul>

                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

        <tfoot>

            <tr>

                <td colspan="9" class="text-center td-action">

                    <ul class="list-action">

                        <li><a class="btn_actions btn_supp _horaire_add">Ajouter un horaire</a></li>

                        <li class="hidden"><label>Nouvel horaire : <input size="4" type="text" name="horaire" class="_required" data-id="<?= $set_id ?>" /></label></li>

                        <li class="hidden"><a class="btn_actions btn_supp _horaire_add_validate" data-id="<?=$set_id?>">Valider</a></li>

                        <li class="hidden"><a class="btn_actions btn_supp _horaire_add_cancel" >Annuler</a></li>

                    </ul>

                </td>

            </tr>

        </tfoot>

    </table>

    <input type="hidden" name="salle_id" value="<?=$salle->id?>">

</div>



    <?php endfor; ?>

