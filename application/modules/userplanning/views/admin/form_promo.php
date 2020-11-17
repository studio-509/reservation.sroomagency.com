<form name="form_promo" id="form_promo">

    <fieldset>

        <ul class="list_form">

            <li>

                <label for="titre_promo">Titre<span class='obligatoire'></span></label>

                <input type="text" class="_required" id="titre_promo" name="titre_promo" value="<?=isset($promo->titre)?$promo->titre:''?>">

                <div class="error masque2 text-center" id="error_titre_promo">Le titre est obligatoire</div>

            </li>

            <li>

                <label for="taux_promo">Valeur promotion</label>

                <input type="text" class="_required" id="taux_promo" name="taux_promo" value="<?=isset($promo->taux)?$promo->taux:''?>">

                <select id="type_promo" class="_required"  name="type_promo">

                    <option value="" <?=empty($promo->type_promo)?'selected="selected"':''?>></option>

                    <option value="pourcent"<?=(isset($promo->type_promo) && $promo->type_promo == '%')?'selected="selected"':''?>>% Pourcentage</option>

                    <option value="euro"<?=(isset($promo->type_promo) && $promo->type_promo == '€')?'selected="selected"':''?>>€ euros</option>

                </select>

                <div class="error masque2 text-center" id="error_taux_promo">Le taux est obligatoire</div>

                <div class="error masque2 text-center" id="error_type_promo">Le type de promotion est obligatoire</div>

            </li>

            <li>

                <label for="date_start">Date début :</label>

                <input type="text" id="date_start" class="_required" value="<?=isset($promo->date_debut)?date('d/m/Y',strtotime($promo->date_debut)):''?>">

                <div class="error masque2 text-center" id="error_date_start">La date de départ est obligatoire</div>

            </li>

            <li>

                <label for="date_end">Date Fin :</label>

                <input type="text" id="date_end" class="_required" value="<?=isset($promo->date_fin)?date('d/m/Y',strtotime($promo->date_fin)):''?>">

                <div class="error masque2 text-center" id="error_date_end">La date de fin est obligatoire</div>

            </li>

            <li>

                <label for="code_promo">Code</label>

                <input type="text" id="code_promo" class="_required" value="<?=!empty($promo->code)?$promo->code:''?>">

				<div class="error masque2 text-center" id="error_code_promo">Le code promo est obligatoire</div>

            </li>

            <li>

                <label>Salles : </label>
				
				<ul style="display:inline-block; width:75%;">
				

                <?php foreach ($list_salle as $val)

                {

                    if(isset($promo->is_global) && $promo->is_global == 1) {?>

                        
						<li style="display:inline;"><label style="width:150px;"><input type="checkbox" name="salle" value="<?=$val->id?>" checked> <?=$val->nom?></label></li>

                        <?php } else {

                            if(in_array($val->id,$salles)) {?>

                                <li style="display:inline:;"><label style="width:150px;"><input type="checkbox" name="salle" value="<?=$val->id?>" checked> <?=$val->nom?></label></li>

                                <?php } else { ?>

                                    <li style="display:inline;"><label style="width:150px;"><input type="checkbox" name="salle" value="<?=$val->id?>"> <?=$val->nom?></label></li>

                                    <?php }

                                }

                            } ?>
						

                            <div class="error masque2 text-center" id="error_salle">

                                Veuillez sélectionner au minimum une salle.

                            </div>

                        </li>
					</ul>

                    </ul>

                    <ul class="list_action">

                        <li>

                            <input type="button" class="button btn_L btn_annul" value="Annuler" onClick="_inPop.close(this)" />

                        </li>

                        <li>

                            <input class="button btnBlue" type="button" name="submit" id="_submit_promo_admin_form" value="Valider" />

                        </li>

                    </ul>

                    <input type="hidden" name="id_promo" value="<?=isset($promo->id)?$promo->id:''?>">

                </fieldset>

            </form>

            <script type="text/javascript">

            $(function(){

                $('#date_start').datepicker($.datepicker.regional[ "fr" ]);

                $('#date_end').datepicker($.datepicker.regional[ "fr" ]);

            });

            </script>

