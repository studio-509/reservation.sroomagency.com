<div style="width:350px;height:650px;display:inline-block;">
	<canvas id="chart_composition_total" width="100" height="100"></canvas>
	<script type="text/javascript">
		<?php
		$nbmin = $salles[0]->nbmin;
		$nbmax = $sallesmax[0]->nbmax;
		$i = $nbmin;
		for ($i=$nbmin;$i<$nbmax+1;$i++) {
			$tempdata = modules::run('stats/admin/Statsadmin/composition',"",$i,1);
			$datas .= ($i == $nbmax)?$tempdata:$tempdata.",";
			$labels .= ($i == $nbmax)?'"'.$i.' joueurs"':'"'.$i.' joueurs",';
		}
		?>
		new Chart(
			document.getElementById("chart_composition_total"),{
				"type":"pie",
				"data":{
					"labels":[<?=$labels?>],
					"datasets":[{
						"label":"My First Dataset",
						"data":[<?=$datas?>],
						"backgroundColor":[
							"rgb(255, 99, 132)",
							"rgb(54, 162, 235)",
							"rgb(54, 162, 0)",
							"rgb(54, 0, 235)",
							"rgb(255, 205, 86)"
						]
					}]
				}
			}
		);
		<?php
		unset($datas);
		unset($labels);
		?>
	</script>
	<table id="tab_composition" style="border:solid 1px black;">
		<tr style="border:solid 1px black;">
			<th>Nb joueurs</th>
			<?php
			foreach ($salles as $s) {
			?>
				<th><?=$s->nom?></th>
				<th>%</th>
			<?php
			}
			?>
			<th>Total</th>
			<th>%</th>
		</tr>
		
		<?php
		$nbmin = $salles[0]->nbmin;
		$nbmax = $sallesmax[0]->nbmax;
		$i = $nbmin;
		for ($i=$nbmin;$i<$nbmax+1;$i++) {
		?>
		<tr>
			<td><?=$i?></td>
			<?php
			foreach ($salles as $s) {
			?>
				<td><?=modules::run('stats/admin/Statsadmin/composition',$s->id,$i);?></td>
				<td><?=modules::run('stats/admin/Statsadmin/composition',$s->id,$i,1);?></td>
			<?php
			}
			?>
			<td><?=modules::run('stats/admin/Statsadmin/composition',"",$i);?></td>
			<td><?=modules::run('stats/admin/Statsadmin/composition',"",$i,1);?></td>
		
		</tr>
		<?php
		}
		?>
	</table>
</div>
<div style="width:350px;height:650px;display:inline-block;">
	<canvas id="chart_horaires_total" width="100" height="100"></canvas>
	<script type="text/javascript">
		<?php
		$nbmax = count($horlist);
		$i=1;
		foreach ($horlist as $hor) {
			$tempdata = modules::run('stats/admin/Statsadmin/horaires',"",$hor->hor_start,1);
			$datas .= ($i == $nbmax)?$tempdata:$tempdata.",";
			$labels .= ($i == $nbmax)?'"'.$hor->hor_start.'"':'"'.$hor->hor_start.'",';
			$i++;
		}
		?>
		new Chart(
			document.getElementById("chart_horaires_total"),{
				"type":"pie",
				"data":{
					"labels":[<?=$labels?>],
					"datasets":[{
						"label":"My First Dataset",
						"data":[<?=$datas?>],
						"backgroundColor":[
							"rgb(255, 99, 132)",
							"rgb(54, 162, 235)",
							"rgb(54, 162, 0)",
							"rgb(54, 0, 235)",
							"rgb(100, 80, 10)",
							"rgb(80, 10, 100)",
							"rgb(255, 205, 86)"
						]
					}]
				}
			}
		);
		<?php
		unset($datas);
		unset($labels);
		?>
	</script>
	<table id="tab_horaires" style="border:solid 1px black;">
		<tr>
			<th>Horaire</th>
			<?php
			foreach ($salles as $s) {
			?>
				<th><?=$s->nom?></th>
				<th>%</th>
			<?php
			}
			?>
			<th>Total</th>
			<th>%</th>
		</tr>
		
		<?php
		foreach ($horlist as $hor) {
		?>
		<tr>
			<td><?=$hor->hor_start?></td>
			<?php
			foreach ($salles as $s) {
			?>
				<td><?=modules::run('stats/admin/Statsadmin/horaires',$s->id,$hor->hor_start);?></td>
				<td><?=modules::run('stats/admin/Statsadmin/horaires',$s->id,$hor->hor_start,1);?></td>
			<?php
			}
			?>
			<td><?=modules::run('stats/admin/Statsadmin/horaires',"",$hor->hor_start);?></td>
			<td><?=modules::run('stats/admin/Statsadmin/horaires',"",$hor->hor_start,1);?></td>
		
		</tr>
		<?php
		}
		?>
	</table>
</div>
<div style="width:350px;height:650px;display:inline-block;">
	<canvas id="chart_jourssemaine_total" width="100" height="100"></canvas>
	<script type="text/javascript">
		<?php
		$nbmax = 7;
		$i=1;
		foreach ($frDay as $key => $day) {
			$tempdata = modules::run('stats/admin/Statsadmin/joursSemaine',"","".$key,1);
			$datas .= ($i == $nbmax)?$tempdata:$tempdata.",";
			$labels .= ($i == $nbmax)?'"'.$day.'"':'"'.$day.'",';
			$i++;
		}
		?>
		new Chart(
			document.getElementById("chart_jourssemaine_total"),{
				"type":"pie",
				"data":{
					"labels":[<?=$labels?>],
					"datasets":[{
						"label":"My First Dataset",
						"data":[<?=$datas?>],
						"backgroundColor":[
							"rgb(255, 99, 132)",
							"rgb(54, 162, 235)",
							"rgb(54, 162, 0)",
							"rgb(54, 0, 235)",
							"rgb(100, 80, 10)",
							"rgb(80, 10, 100)",
							"rgb(255, 205, 86)"
						]
					}]
				}
			}
		);
		<?php
		unset($datas);
		unset($labels);
		?>
	</script>
	<table id="tab_jourssemaine" style="border:solid 1px black;">
		<tr>
			<th>Jour de la semaine</th>
			<?php
			foreach ($salles as $s) {
			?>
				<th><?=$s->nom?></th>
				<th>%</th>
			<?php
			}
			?>
			<th>Total</th>
			<th>%</th>
		</tr>
		
		<?php
		foreach ($frDay as $key => $day) {
		?>
		<tr>
			<td><?=$day?></td>
			<?php
			foreach ($salles as $s) {
			?>
				<td><?=modules::run('stats/admin/Statsadmin/joursSemaine',$s->id,"".$key);?></td>
				<td><?=modules::run('stats/admin/Statsadmin/joursSemaine',$s->id,"".$key,1);?></td>
			<?php
			}
			?>
			<td><?=modules::run('stats/admin/Statsadmin/joursSemaine',"","".$key);?></td>
			<td><?=modules::run('stats/admin/Statsadmin/joursSemaine',"","".$key,1);?></td>
		
		</tr>
		<?php
		}
		?>
	</table>
</div>
<div style="width:350px;height:650px;display:inline-block;">
	<canvas id="chart_delai_total" width="100" height="100"></canvas>
	<script type="text/javascript">
		<?php
		$nbmax = count($delai);
		$i = 1;
		foreach ($delai as $del) {
			$tempdata = modules::run('stats/admin/Statsadmin/delai',"",$del['mini'],$del['maxi'],1);
			$datas .= ($i == $nbmax)?$tempdata:$tempdata.",";
			$labels .= ($i == $nbmax)?'"'.$del['titre'].'"':'"'.$del['titre'].'",';
			$i++;
		}
		?>
		new Chart(
			document.getElementById("chart_delai_total"),{
				"type":"pie",
				"data":{
					"labels":[<?=$labels?>],
					"datasets":[{
						"label":"My First Dataset",
						"data":[<?=$datas?>],
						"backgroundColor":[
							"rgb(255, 99, 132)",
							"rgb(54, 162, 235)",
							"rgb(54, 162, 0)",
							"rgb(54, 0, 235)",
							"rgb(255, 205, 86)"
						]
					}]
				}
			}
		);
		<?php
		unset($datas);
		unset($labels);
		?>
	</script>
	<table id="tab_delai" style="border:solid 1px black;">
		<tr>
			<th>Délai</th>
			<?php
			foreach ($salles as $s) {
			?>
				<th><?=$s->nom?></th>
				<th>%</th>
			<?php
			}
			?>
			<th>Total</th>
			<th>%</th>
		</tr>
		
		<?php
		foreach ($delai as $del) {
		?>
		<tr>
			<td><?=$del['titre']?></td>
			<?php
			foreach ($salles as $s) {
			?>
				<td><?=modules::run('stats/admin/Statsadmin/delai',$s->id,$del['mini'],$del['maxi']);?></td>
				<td><?=modules::run('stats/admin/Statsadmin/delai',$s->id,$del['mini'],$del['maxi'],1);?></td>
			<?php
			}
			?>
			<td><?=modules::run('stats/admin/Statsadmin/delai',"",$del['mini'],$del['maxi']);?></td>
			<td><?=modules::run('stats/admin/Statsadmin/delai',"",$del['mini'],$del['maxi'],1);?></td>
		
		</tr>
		<?php
		}
		?>
	</table>
</div>
<table>
	<tr>
		<th></th>
		<?php
		foreach($frMonth as $nbmois => $nommois) {
		?>
		<th><?=$nommois?></th>
		
		<?php
		}
		?>
	</tr>
	<?php
	foreach($years as $annee) {		
	?>
	<tr>
		<td><?=$annee->annee?></td>
		<?php
		foreach($frMonth as $nbmois => $nommois) {
		?>
		<td><?=modules::run('stats/admin/Statsadmin/ecartmois',$nbmois,$annee->annee);?></td>	
		<?php
		}
		?>
	
	</tr>
	<?php
	}
	?>
</table>
<table id="tab_joursethoraires" style="border:solid 1px black;">
	<?php
	$maxjh = 0;
	foreach ($horlist as $hor) {
		foreach ($frDay as $key => $day) {
			$tempjh = modules::run('stats/admin/Statsadmin/joursEtHoraires',"".$key,$hor->hor_start);
			if ($tempjh > $maxjh) $maxjh = $tempjh;
		}		
	}
	$diviseur = $maxjh/2.5;
	?>
	<tr>
		<th></th>
		<?php
		foreach ($frDay as $key => $day) {
		?>
			<th style="height:40px;width:80px;font-size:15px;text-align:center;font-weight:bold;"><?=$day?></th>
		<?php
		}
		?>
	</tr>
	
	<?php
	foreach ($horlist as $hor) {
	?>
	<tr>
		<td style="height:40px;width:80px;font-size:15px;text-align:center;font-weight:bold;"><?=$hor->hor_start?></td>
		<?php
		foreach ($frDay as $key => $day) {
			$percjh = modules::run('stats/admin/Statsadmin/joursEtHoraires',"".$key,$hor->hor_start);
			$redcolor = round($percjh*254/$diviseur);	
			$redcolor = ($redcolor > 254)?254:$redcolor;
			
			$greencolor = round(($maxjh-$percjh)*254/$diviseur);	
			$greencolor = ($greencolor > 254)?254:$greencolor;
		?>
			<td style="background-color:rgb(<?=$redcolor?>,<?=$greencolor?>,0);height:40px;width:80px;font-size:15px;text-align:center;">
				<?=round($percjh,2).'%'?>				
			</td>
		<?php
		}
		?>		
	</tr>
	<?php
	}
	?>
</table>
<table id="tab_joursethorairesvacances" style="border:solid 1px black;">
	<?php
	$maxjh = 0;
	foreach ($horlist as $hor) {
		foreach ($frDay as $key => $day) {
			$tempjh = modules::run('stats/admin/Statsadmin/joursEtHorairesVacances',"".$key,$hor->hor_start,"vacances");
			if ($tempjh > $maxjh) $maxjh = $tempjh;
		}		
	}
	$diviseur = $maxjh/2.5;
	?>
	<tr>
		<th></th>
		<?php
		foreach ($frDay as $key => $day) {
		?>
			<th style="height:40px;width:80px;font-size:15px;text-align:center;font-weight:bold;"><?=$day?></th>
		<?php
		}
		?>
	</tr>
	
	<?php
	foreach ($horlist as $hor) {
	?>
	<tr>
		<td style="height:40px;width:80px;font-size:15px;text-align:center;font-weight:bold;"><?=$hor->hor_start?></td>
		<?php
		foreach ($frDay as $key => $day) {
			$percjh = modules::run('stats/admin/Statsadmin/joursEtHorairesVacances',"".$key,$hor->hor_start,"vacances");
			$redcolor = round($percjh*254/$diviseur);	
			$redcolor = ($redcolor > 254)?254:$redcolor;
			
			$greencolor = round(($maxjh-$percjh)*254/$diviseur);	
			$greencolor = ($greencolor > 254)?254:$greencolor;
		?>
			<td style="background-color:rgb(<?=$redcolor?>,<?=$greencolor?>,0);height:40px;width:80px;font-size:15px;text-align:center;">
				<?=round($percjh,2).'%'?>				
			</td>
		<?php
		}
		?>		
	</tr>
	<?php
	}
	?>
</table>
<table id="tab_joursethorairesscolaires" style="border:solid 1px black;">
	<?php
	$maxjh = 0;
	foreach ($horlist as $hor) {
		foreach ($frDay as $key => $day) {
			$tempjh = modules::run('stats/admin/Statsadmin/joursEtHorairesVacances',"".$key,$hor->hor_start,"scolaires");
			if ($tempjh > $maxjh) $maxjh = $tempjh;
		}		
	}
	$diviseur = $maxjh/2.5;
	?>
	<tr>
		<th></th>
		<?php
		foreach ($frDay as $key => $day) {
		?>
			<th style="height:40px;width:80px;font-size:15px;text-align:center;font-weight:bold;"><?=$day?></th>
		<?php
		}
		?>
	</tr>
	
	<?php
	foreach ($horlist as $hor) {
	?>
	<tr>
		<td style="height:40px;width:80px;font-size:15px;text-align:center;font-weight:bold;"><?=$hor->hor_start?></td>
		<?php
		foreach ($frDay as $key => $day) {
			$percjh = modules::run('stats/admin/Statsadmin/joursEtHorairesVacances',"".$key,$hor->hor_start,"scolaires");
			$redcolor = round($percjh*254/$diviseur);	
			$redcolor = ($redcolor > 254)?254:$redcolor;
			
			$greencolor = round(($maxjh-$percjh)*254/$diviseur);	
			$greencolor = ($greencolor > 254)?254:$greencolor;
		?>
			<td style="background-color:rgb(<?=$redcolor?>,<?=$greencolor?>,0);height:40px;width:80px;font-size:15px;text-align:center;">
				<?=round($percjh,2).'%'?>				
			</td>
		<?php
		}
		?>		
	</tr>
	<?php
	}
	?>
</table>