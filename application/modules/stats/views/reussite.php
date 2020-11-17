<table id="tab_reussite" style="border:solid 1px black;">
	<tr>
		<td></td>
		<?php
		foreach ($salles as $s) {
		?>
			<td><?=$s->nom?></td>
		<?php
		}
		?>
		<td>Total</td>
	</tr>
	<tr>
		<td>Parties</td>
		<?php
		foreach ($salles as $s) {
		?>
			<td><?=modules::run('stats/admin/Statsadmin/reussite',$s->id);?></td>
		<?php
		}
		?>
		<td><?=modules::run('stats/admin/Statsadmin/reussite');?></td>
	</tr>
	<tr>
		<td>Réussites</td>
		<?php
		foreach ($salles as $s) {
		?>
			<td><?=modules::run('stats/admin/Statsadmin/reussite',$s->id,1);?></td>
		<?php
		}
		?>
		<td><?=modules::run('stats/admin/Statsadmin/reussite',"",1);?></td>
	</tr>
	<tr>
		<td>Taux Global</td>
		<?php
		foreach ($salles as $s) {
		?>
			<td><?=modules::run('stats/admin/Statsadmin/reussite',$s->id,1,1);?></td>
		<?php
		}
		?>
		<td><?=modules::run('stats/admin/Statsadmin/reussite',"",1,1);?></td>
	</tr>
	<tr>
		<td>Taux par Nombre de joueurs</td>
		<?php
		foreach ($salles as $s) {
		?>
			<td></td>
		<?php
		}
		?>
		<td></td>
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
			<td><?=modules::run('stats/admin/Statsadmin/reussite',$s->id,1,1,$i);?></td>
		<?php
		}
		?>
		<td><?=modules::run('stats/admin/Statsadmin/reussite',"",1,1,$i);?></td>
	</tr>
	<?php
	}
	?>
</table>
<?php
foreach ($salles as $s) {
?>
<table id="tab_classement_s<?=$s->id?>" style="border:solid 1px black;display:inline-block;">
	<tr>
		<th>Rang</th>
		<th>Nom d'équipe</th>
		<th>Temps</th>
	</tr>
	<?php
	foreach ($classement[$s->id] as $ranking) {
	?>
	<tr>
		<td><?=modules::run('stats/admin/Statsadmin/rang',$s->id,$ranking->tps_jeu);?></td>
		<td><?=$ranking->nom_equipe?></td>
		<td><?=$ranking->tps_jeu?></td>	
	</tr>
	<?php
	}
	?>
</table>
<?php
}
?>