<div style="width:1400px;height:600px;">
	<canvas id="chart_resas_mois" width="100" height="40"></canvas>
	<script type="text/javascript">
		<?php
		unset ($datas);
		$datas = [];
		$color = [];
		$f = -9;
		$somme = array(0,0,0,0);
		
		foreach($years as $annee) {		
			foreach($frMonth as $nbmois => $nommois) {
				unset($tempdata);
				$tempdata = [];
				
				$tempdata[0] = modules::run('stats/admin/Statsadmin/resasmois',$nbmois,$annee->annee);
				
				//A commenter pour avoir le nombre de résas. A décommenter pour avoir la moyenne des résas depuis l'ouverture.
				/*$sommetemp = $tempdata[0];
				$tempdata[0] = ($tempdata[0]+$somme[0])/$f;
				$somme[0] += $sommetemp;
				unset($sommetemp);*/
				
				
				$color[0] = 'FF0000';
				$title[0] = "Toutes les salles";
				$i = 1;
				foreach($salles as $s) {
					$color[$s->id] = $s->theme_color;
					$title[$s->id] = $s->nom;
					$tempdata[$s->id] = modules::run('stats/admin/Statsadmin/resasmois',$nbmois,$annee->annee,$s->id);
					
					//A commenter pour avoir le nombre de résas. A décommenter pour avoir la moyenne des résas depuis l'ouverture.
					/*$sommetemp = $tempdata[$s->id];
					$tempdata[$s->id] = ($tempdata[$s->id]+$somme[$s->id])/$f;
					$somme[$s->id] += $sommetemp;
					unset($sommetemp);*/
					
					$i++;
				}
				if ($tempdata[0] != 0) {
					
					foreach ($tempdata as $key => $tempdat) { 
						
						$datas[$key] .= $tempdat.',';
						
					}
					$labels .= '"'.$nommois.$annee->annee.'",';
				}
				$f++;
			}
		}
		$labels = substr($labels,0,strlen($labels)-1);
		?>
		new Chart(
			document.getElementById("chart_resas_mois"),{
				"type":"line",
				"data":{
					"labels":[<?=$labels?>],
					"datasets":[
					<?php
					$i=1;
					foreach($datas as $key => $dat) {
						$dat = substr($dat,0,strlen($dat)-1);
					?>
						{
							"label":"<?=$title[$key]?>",
							"data":[<?=$dat?>],
							"fill":false,
							"borderColor":"#<?=$color[$key]?>",
							"lineTension":0.1
						}
					<?php
						if ($i < count($datas)) echo ",";
						$i++;
					}
					?>
					]
				}
			}
		);
		<?php
		unset($datas);
		unset($labels);
		unset($title);
		unset($color);
		?>
	</script>
</div>
<div style="width:1400px;height:600px;">
	<canvas id="chart_resas_mois_moyenne" width="100" height="40"></canvas>
	<script type="text/javascript">
		<?php
		$presentdate = new DateTime();
		$presentmonth = $presentdate->format('n');
		$presentyear = $presentdate->format('Y');
		unset ($datas);
		$datas = [];
		$color = [];
		$f = -9;
		$somme = array(0,0,0,0);
		
		foreach($years as $annee) {		
			foreach($frMonth as $nbmois => $nommois) {
				
				//echo '<script type="text/javascript">alert("'.$nbmois.'");</script>';
				if ($annee->annee == $presentyear && $nbmois > $presentmonth) {
					break;
				}
				else {
					unset($tempdata);
					$tempdata = [];
					
					$tempdata[0] = modules::run('stats/admin/Statsadmin/resasmois',$nbmois,$annee->annee);
					
					//A commenter pour avoir le nombre de résas. A décommenter pour avoir la moyenne des résas depuis l'ouverture.
					$sommetemp = $tempdata[0];
					$tempdata[0] = ($tempdata[0]+$somme[0])/$f;
					$somme[0] += $sommetemp;
					unset($sommetemp);
					
					
					$color[0] = 'FF0000';
					$title[0] = "Toutes les salles";
					$i = 1;
					foreach($salles as $s) {
						$color[$s->id] = $s->theme_color;
						$title[$s->id] = $s->nom;
						$tempdata[$s->id] = modules::run('stats/admin/Statsadmin/resasmois',$nbmois,$annee->annee,$s->id);
						
						//A commenter pour avoir le nombre de résas. A décommenter pour avoir la moyenne des résas depuis l'ouverture.
						$sommetemp = $tempdata[$s->id];
						$tempdata[$s->id] = ($tempdata[$s->id]+$somme[$s->id])/$f;
						$somme[$s->id] += $sommetemp;
						unset($sommetemp);
						
						$i++;
					}
					if ($tempdata[0] != 0) {
						
						foreach ($tempdata as $key => $tempdat) { 
							
							$datas[$key] .= $tempdat.',';
							
						}
						$labels .= '"'.$nommois.$annee->annee.'",';
					}
					$f++;
				}
			}
		}
		$labels = substr($labels,0,strlen($labels)-1);
		?>
		new Chart(
			document.getElementById("chart_resas_mois_moyenne"),{
				"type":"line",
				"data":{
					"labels":[<?=$labels?>],
					"datasets":[
					<?php
					$i=1;
					foreach($datas as $key => $dat) {
						$dat = substr($dat,0,strlen($dat)-1);
					?>
						{
							"label":"<?=$title[$key]?>",
							"data":[<?=$dat?>],
							"fill":false,
							"borderColor":"#<?=$color[$key]?>",
							"lineTension":0.1
						}
					<?php
						if ($i < count($datas)) echo ",";
						$i++;
					}
					?>
					]
				}
			}
		);
		<?php
		unset($datas);
		unset($labels);
		unset($title);
		unset($color);
		?>
	</script>
</div>
<div style="width:1400px;height:600px;">
	<canvas id="chart_resas_semaine" width="100" height="40"></canvas>
	<script type="text/javascript">
		<?php
		unset ($datas);
		$datas = [];
		$color = [];
		$sem = 1;
		foreach($years as $annee) {		
			for($sem=1;$sem<53;$sem++) {
				unset($tempdata);
				$tempdata = [];
				
				$tempdata[0] = modules::run('stats/admin/Statsadmin/resassemaine',$sem,$annee->annee);
				$color[0] = 'FF0000';
				$title[0] = "Toutes les salles";
				$i = 1;
				foreach($salles as $s) {
					$color[$s->id] = $s->theme_color;
					$title[$s->id] = $s->nom;
					$tempdata[$s->id] = modules::run('stats/admin/Statsadmin/resassemaine',$sem,$annee->annee,$s->id);
					$i++;
				}
				if ($tempdata[0] != 0) {
					
					foreach ($tempdata as $key => $tempdat) { 
						
						$datas[$key] .= $tempdat.',';
						
					}
					$labels .= '"Sem : '.$sem.'-'.$annee->annee.'",';
				}			
			}
		}
		$labels = substr($labels,0,strlen($labels)-1);
		?>
		new Chart(
			document.getElementById("chart_resas_semaine"),{
				"type":"line",
				"data":{
					"labels":[<?=$labels?>],
					"datasets":[
					<?php
					$i=1;
					foreach($datas as $key => $dat) {
						$dat = substr($dat,0,strlen($dat)-1);
					?>
						{
							"label":"<?=$title[$key]?>",
							"data":[<?=$dat?>],
							"fill":false,
							"borderColor":"#<?=$color[$key]?>",
							"lineTension":0.1
						}
					<?php
						if ($i < count($datas)) echo ",";
						$i++;
					}
					?>
					]
				}
			}
		);
		<?php
		unset($datas);
		unset($labels);
		unset($title);
		unset($color);
		?>
	</script>
</div>
<div style="width:1400px;height:600px;">
	<canvas id="chart_resas_mois_compare" width="100" height="40"></canvas>
	<script type="text/javascript">
		<?php
		unset ($datas);
		$datas = [];
		$color = [];
		$color[2016] = "FF0000";
		$color[2017] = "00BB22";
		$color[2018] = "0055CC";
		$color[2019] = "FFFF00";
		$i = 0;
		
			
		foreach($frMonth as $nbmois => $nommois) {
			unset($tempdata);
			$tempdata = [];
			
			foreach($years as $annee) {	
				
				$title[$annee->annee] = "Année ".$annee->annee;
				$tempdata[$annee->annee] = modules::run('stats/admin/Statsadmin/resasmois',$nbmois,$annee->annee);
				
			}

				
			foreach ($tempdata as $key => $tempdat) { 
				
				$datas[$key] .= $tempdat.',';
				
			}
			$labels .= '"'.$nommois.'",';
						
		}
		
		$labels = substr($labels,0,strlen($labels)-1);
		?>
		new Chart(
			document.getElementById("chart_resas_mois_compare"),{
				"type":"line",
				"data":{
					"labels":[<?=$labels?>],
					"datasets":[
					<?php
					$i=1;
					foreach($datas as $key => $dat) {
						$dat = substr($dat,0,strlen($dat)-1);
					?>
						{
							"label":"<?=$title[$key]?>",
							"data":[<?=$dat?>],
							"fill":false,
							"borderColor":"#<?=$color[$key]?>",
							"lineTension":0.1
						}
					<?php
						if ($i < count($datas)) echo ",";
						$i++;
					}
					?>
					]
				}
			}
		);
		<?php
		unset($datas);
		unset($labels);
		unset($title);
		unset($color);
		?>
	</script>
</div>