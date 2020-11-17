<ul class="listBtn mb16 mt16">
	<li>
		
			<a data-id="<?=$prev?>" data-orig="admin" class="_cal_drop">Semaine précédente</a>
		
	</li>
	<li>
		<a data-id="<?=$next?>" data-orig="admin" class="_cal_drop">Semaine suivante</a>
	</li>
</ul>
<input type="hidden" name="addIndispo" id="addIndispo" value="<?=($addIndispo?'1':'0')?>" />
<input type="hidden" name="addResa" id="addResa" value="<?=($addResa?'1':'0')?>" />
<div class="block_admin">
	<table id="calendar_table" style="border-collapse: collapse;">
		<thead>
			<tr>
				<!--<th>Horaires</th>-->
				<?php
					
				$start1 = $start;
				for($i=1;$i<8;$i++): ?>
				<th><?= getFrDay ($i)?><br /><span style="display:block;" <?=(($i==1)?'class="calday toto"':'class="calday"')?> data-day="<?=date('Y-m-d', $start1)?>"><?=date('d/m/Y', $start1)?></span>
				
						<?php 
						foreach($stafflist as $staff):
						?>	
							
					<span style="display:inline-block;float:left;width:<?=100/$nbstaff?>%;margin:0px;margin-top:5px;border:none;"><?=substr($staff->prenom,0,1).substr($staff->nom,0,1)?></span>
						<?php 
						endforeach;
						?>
			
				</th>
					<?php
					$start1 += 86400;
				endfor;
				?>
			</tr>
		</thead>
		<tbody>
			<?php 
			for ($j=0;$j<32;$j++) {
			$heure = ($j%2 == 0)?(8+$j/2):(7+($j+1)/2);
			$heure = (strlen($heure) == 1)?'0'.$heure:$heure;
			$heure = ($j%2 == 0)?$heure.'h00':$heure.'h30';
			
			$k = $j-1;
			$heureprec = ($k%2 == 0)?(8+$k/2):(7+($k+1)/2);
			$heureprec = (strlen($heureprec) == 1)?'0'.$heureprec:$heureprec;
			$heureprec = ($k%2 == 0)?$heureprec.'h00':$heureprec.'h30';
			
			$l = $j+1;
			$heuresuiv = ($l%2 == 0)?(8+$l/2):(7+($l+1)/2);
			$heuresuiv = (strlen($heuresuiv) == 1)?'0'.$heuresuiv:$heuresuiv;
			$heuresuiv = ($l%2 == 0)?$heuresuiv.'h00':$heuresuiv.'h30';
			?>
			<tr>
				<?php
				$start1 = $start;
				for($i=1;$i<8;$i++) { ?>
				<td>
					<?php 
					foreach($stafflist as $staff) {
						$heuressemaine[$staff->id] = 0;
						$minutessemaine[$staff->id] = 0;
						$working = false;
						$firsthour = false;
						$lasthour = false;
						if ($planningok[$staff->id] != 0) {
							foreach($planningok[$staff->id] as $p) {
								
								$testend = ($p->heure_fin == "00h00")?"24h00":$p->heure_fin;
								
								//compte heures cumulées semaine
								$htemp = 0;
								$mtemp = 0;
								$deb = explode('h',$p->heure_debut);
								$fin = explode('h',$testend);
								$htemp = (intval($fin[1]) < intval($deb[1]))?(intval($fin[0]) - intval($deb[0]) - 1):(intval($fin[0]) - intval($deb[0]));
								$mtemp = abs(intval($fin[1]) - intval($deb[1]));
								
								$minutessemaine[$staff->id] += $mtemp;								
								$heuressemaine[$staff->id] += $htemp;
								
								if ($minutessemaine[$staff->id] >= 60) {
									$minutessemaine[$staff->id] -= 60;
									$heuressemaine[$staff->id] += 1;
								}
								
								if ($p->jour == $i && $p->heure_debut <= $heure && $testend > $heure) { 									
									$working = true;
									if ($p->heure_debut == $heure) { 			
										$firsthour = true;
									}
									if ($testend == $heuresuiv) { 
										$lasthour= true;
										$lasthouraffiche = $p->heure_fin;
									}
								}
								
							}
						}		
					?>
					<span style="display:inline-block;float:left;overflow:visible;text-align:center;width:<?=100/$nbstaff?>%;height:10px;margin:0px;border-left:solid 1px #333;border-right:solid 1px #333;color:white;<?=($working == true)?'background-color:'.$staff->color.';':''?><?=($firsthour == true)?'border-top:solid 1px #333;':''?><?=($lasthour == true || $heure == "23h30")?'border-bottom:solid 1px #333;':''?>">
						<p style="position:relative;z-index:9999;"><?php if ($firsthour==true) echo $heure;?></p>
						<p style="position:relative;bottom:30px;z-index:9999;"><?php	if ($lasthour ==true) echo $lasthouraffiche;?></p>
						
					</span>
					<?php 
					}
					?>
				</td>
					<?php
					$start1 += 86400;
				}
				?>	
			</tr>
			<?php 
			} 
			?>
		</tbody>
	</table>
	<?php
	$dateweek = new DateTime();
	$dateweek->setTimestamp($start);
	$weeknumber = $dateweek->format('W');
	?>
	<p><strong>Semaine n°<?=$weeknumber?></strong></p>
	<?php
	foreach($stafflist as $staff) {
	?>
		<p><?=$staff->prenom?> <?=$staff->nom?> : <?=$heuressemaine[$staff->id]?>h<?=($minutessemaine[$staff->id]<10)?'0'.$minutessemaine[$staff->id]:$minutessemaine[$staff->id]?></p>
	<?php
	}
	?>
</div>