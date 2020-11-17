<div>
	<ul class="listOnglets">
		<?php
			$j = 0;
			foreach($salles as $salle):
			$class = ($j == 0)?'':'active';
		?>
		          <li><a id="salle_<?=$salle->id?>" class="button btnONG _tab_drop <?=$class?>"><?=$salle->nom?></a></li>
        <?php $j++; endforeach; ?>
	</ul>
</div>

<?php
	$i = 0;
	foreach($salles as $salle):
	$class = ($i == 0)?'':'masque2';
?>
    <div id="bloc_salle_<?=$salle->id?>" class="_tab_bloc <?=$class?> block_admin block_admin_ong">
		<p><?=$salle->nom?></p>
        <div id="bloc_timer_<?=$salle->id?>">
			<div id="countdown_<?=$salle->id?>"></div>
			<?php
				$now = time();
				$diff = 3600;
				$auto_start = 'false';
				if($salle->starter != '' && $salle->pause == 0):
					$diff = ($salle->starter + 3600) - $now;
					$auto_start = 'true';
				elseif($salle->starter != '' && $salle->pause != 0):
					$now = time();
					$new = $salle->starter + (time() - $salle->pause);
					$diff = ($new + 3600) - $now;
					$auto_start = 'false';
				endif;
			?>
			<script type="text/javascript">
				$('#countdown_<?=$salle->id?>').timeTo({
					start: <?=$auto_start?>,
					},
					<?=$diff?>,
					function(){
						var datas = {"titre":"Fin de partie","txt":"Fin de la partie sur salle <?=$salle->nom?>"};
						_inPop.open('/popin/confirm', datas, 'alerte', '_inPop.close()');
				});
			</script>
		</div>
		<div>
			<ul class="listOnglets">
				<li><a id="_timer_btn_start" class="<?=($salle->starter == '')?'_timer_start':''?> button" data-id="<?=$salle->id?>">Démarrer</a></li>
				<li><a id="_timer_btn_pause" class="<?=($salle->starter != '' && $salle->pause != 0)?'_timer_restart':(($salle->starter != '' && $salle->pause == 0)?'_timer_pause':'')?> button" data-id="<?=$salle->id?>"><?=($salle->starter != '' && $salle->pause != 0)?'Reprendre':'Pause'?></a></li>
				<li><a class="_timer_reset button" data-id="<?=$salle->id?>">Reset</a></li>
		</div>
		<div id="bloc_txt_<?=$salle->id?>">
			<div>
				<p>Message en cours d'affichage</p>
				<p id="_bloc_mess_<?=$salle->id?>"><?=$salle->affiche ?></p>
			</div>
			<div>
				<ul class="list_form">
					<li>
						<label>Envoyer un message aux joueurs</label>
						<textarea id="text_<?=$salle->id?>"></textarea>
					</li>
				</ul>
				<ul class="list_action">
					<li><a class="_mess_submit button" data-id="<?=$salle->id?>">Envoyer le message</a></li>
				</ul>
			</div>
		</div>
    </div>
<?php $i++; endforeach; ?>
