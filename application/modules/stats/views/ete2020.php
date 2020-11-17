
<table id="tab_ete2020" width="100%">

	<!--Juillet-->
	<tr style="background-color:black;">
		<th colspan="6" style="padding:5px;"><h1> Juillet</h1></th>
	<tr>
	
	<?php
		$month = '07';
		
		$totalresas19 = 0;
		$totalca19 = 0;
		
		$totalresas20 = 0;
		$totalca20 = 0;
	?>
	
	
	<!--Semaine 27 -->
	<?php
		$firstDay19 = '01';
		$lastDay19 = '07';
		
		$firstDay20 = '01';
		$lastDay20 = '05';
		
		$startDate19 = '2019-'.$month.'-'.$firstDay19;
		$endDate19 = '2019-'.$month.'-'.$lastDay19;
		
		$startDate20 = '2020-'.$month.'-'.$firstDay20;
		$endDate20 = '2020-'.$month.'-'.$lastDay20;
	?>
	<tr style="border-top:solid;">
		<th>Semaine 27 (Partie Juillet uniquement)</th>
		<th>2019</th>
		<th>2020</th>
		<th>Ecart en valeur</th>
		<th>Ecart en %</th>
		<th>Resultat en %</th>
	</tr>
	<tr>
		<td>Nb Resas</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate19,$endDate19);
				$totalresas19 += $result1;
				echo $result1;
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate20,$endDate20);
				$totalresas20 += $result2;
				echo $result2;
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	<tr>
		<td>CA TTC</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate19,$endDate19);
				$totalca19 += $result1;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate20,$endDate20);
				$totalca20 += $result2;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	<tr>
		<td>CA HT</td>
		<td>
			<?php 
				$result1 = $result1/1.20;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $result2/1.10;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	
	<!--Semaine 28 -->
	<?php
		$firstDay19 = '08';
		$lastDay19 = '14';
		
		$firstDay20 = '06';
		$lastDay20 = '12';
		
		$startDate19 = '2019-'.$month.'-'.$firstDay19;
		$endDate19 = '2019-'.$month.'-'.$lastDay19;
		
		$startDate20 = '2020-'.$month.'-'.$firstDay20;
		$endDate20 = '2020-'.$month.'-'.$lastDay20;
	?>
	<tr style="border-top:solid;">
		<th>Semaine 28</th>
		<th>2019</th>
		<th>2020</th>
		<th>Ecart en valeur</th>
		<th>Ecart en %</th>
		<th>Resultat en %</th>
	</tr>
	<tr>
		<td>Nb Resas</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate19,$endDate19);
				$totalresas19 += $result1;
				echo $result1;
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate20,$endDate20);
				$totalresas20 += $result2;
				echo $result2;
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	<tr>
		<td>CA TTC</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate19,$endDate19);
				$totalca19 += $result1;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate20,$endDate20);
				$totalca20 += $result2;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	<tr>
		<td>CA HT</td>
		<td>
			<?php 
				$result1 = $result1/1.20;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $result2/1.10;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	
	<!--Semaine 29 -->
	<?php
		$firstDay19 = '15';
		$lastDay19 = '21';
		
		$firstDay20 = '13';
		$lastDay20 = '19';
		
		$startDate19 = '2019-'.$month.'-'.$firstDay19;
		$endDate19 = '2019-'.$month.'-'.$lastDay19;
		
		$startDate20 = '2020-'.$month.'-'.$firstDay20;
		$endDate20 = '2020-'.$month.'-'.$lastDay20;
	?>
	<tr style="border-top:solid;">
		<th>Semaine 29</th>
		<th>2019</th>
		<th>2020</th>
		<th>Ecart en valeur</th>
		<th>Ecart en %</th>
		<th>Resultat en %</th>
	</tr>
	<tr>
		<td>Nb Resas</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate19,$endDate19);
				$totalresas19 += $result1;
				echo $result1;
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate20,$endDate20);
				$totalresas20 += $result2;
				echo $result2;
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	<tr>
		<td>CA TTC</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate19,$endDate19);
				$totalca19 += $result1;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate20,$endDate20);
				$totalca20 += $result2;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	<tr>
		<td>CA HT</td>
		<td>
			<?php 
				$result1 = $result1/1.20;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $result2/1.10;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	
	<!--Semaine 30 -->
	<?php
		$firstDay19 = '22';
		$lastDay19 = '28';
		
		$firstDay20 = '20';
		$lastDay20 = '26';
		
		$startDate19 = '2019-'.$month.'-'.$firstDay19;
		$endDate19 = '2019-'.$month.'-'.$lastDay19;
		
		$startDate20 = '2020-'.$month.'-'.$firstDay20;
		$endDate20 = '2020-'.$month.'-'.$lastDay20;
	?>
	<tr style="border-top:solid;">
		<th>Semaine 30</th>
		<th>2019</th>
		<th>2020</th>
		<th>Ecart en valeur</th>
		<th>Ecart en %</th>
		<th>Resultat en %</th>
	</tr>
	<tr>
		<td>Nb Resas</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate19,$endDate19);
				$totalresas19 += $result1;
				echo $result1;
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate20,$endDate20);
				$totalresas20 += $result2;
				echo $result2;
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	<tr>
		<td>CA TTC</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate19,$endDate19);
				$totalca19 += $result1;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate20,$endDate20);
				$totalca20 += $result2;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	<tr>
		<td>CA HT</td>
		<td>
			<?php 
				$result1 = $result1/1.20;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $result2/1.10;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	
	<!--Semaine 31 -->
	<?php
		$firstDay19 = '29';
		$lastDay19 = '31';
		
		$firstDay20 = '27';
		$lastDay20 = '31';
		
		$startDate19 = '2019-'.$month.'-'.$firstDay19;
		$endDate19 = '2019-'.$month.'-'.$lastDay19;
		
		$startDate20 = '2020-'.$month.'-'.$firstDay20;
		$endDate20 = '2020-'.$month.'-'.$lastDay20;
	?>
	<tr style="border-top:solid;">
		<th>Semaine 31 (Partie Juillet uniquement)</th>
		<th>2019</th>
		<th>2020</th>
		<th>Ecart en valeur</th>
		<th>Ecart en %</th>
		<th>Resultat en %</th>
	</tr>
	<tr>
		<td>Nb Resas</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate19,$endDate19);
				$totalresas19 += $result1;
				echo $result1;
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate20,$endDate20);
				$totalresas20 += $result2;
				echo $result2;
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	<tr>
		<td>CA TTC</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate19,$endDate19);
				$totalca19 += $result1;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate20,$endDate20);
				$totalca20 += $result2;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	<tr>
		<td>CA HT</td>
		<td>
			<?php 
				$result1 = $result1/1.20;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $result2/1.10;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	<!--TOTAL Juillet -->
	<tr style="border-top:solid;background-color:gray;color:black;">
		<th>TOTAL JUILLET</th>
		<th>2019</th>
		<th>2020</th>
		<th>Ecart en valeur</th>
		<th>Ecart en %</th>
		<th>Resultat en %</th>
	</tr>
	<tr>
		<td>Nb Resas</td>
		<td>
			<?php 
				$result1 = $totalresas19;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $totalresas20;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	<tr>
		<td>CA TTC</td>
		<td>
			<?php 
				$result1 = $totalca19;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $totalca20;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	<tr>
		<td>CA HT</td>
		<td>
			<?php 
				$result1 = $result1/1.20;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $result2/1.10;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	
	
	
	
	<!--Aout-->
	<tr style="background-color:black;">
		<th colspan="6" style="padding:5px;"><h1> Août</h1></th>
	<tr>
	
	<?php
		$month = '08';
		
		$totalresas19 = 0;
		$totalca19 = 0;
		
		$totalresas20 = 0;
		$totalca20 = 0;
	?>
	
	
	<!--Semaine 31 -->
	<?php
		$firstDay19 = '01';
		$lastDay19 = '04';
		
		$firstDay20 = '01';
		$lastDay20 = '02';
		
		$startDate19 = '2019-'.$month.'-'.$firstDay19;
		$endDate19 = '2019-'.$month.'-'.$lastDay19;
		
		$startDate20 = '2020-'.$month.'-'.$firstDay20;
		$endDate20 = '2020-'.$month.'-'.$lastDay20;
	?>
	<tr style="border-top:solid;">
		<th>Semaine 31 (Partie Août uniquement)</th>
		<th>2019</th>
		<th>2020</th>
		<th>Ecart en valeur</th>
		<th>Ecart en %</th>
		<th>Resultat en %</th>
	</tr>
	<tr>
		<td>Nb Resas</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate19,$endDate19);
				$totalresas19 += $result1;
				echo $result1;
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate20,$endDate20);
				$totalresas20 += $result2;
				echo $result2;
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	<tr>
		<td>CA TTC</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate19,$endDate19);
				$totalca19 += $result1;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate20,$endDate20);
				$totalca20 += $result2;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	<tr>
		<td>CA HT</td>
		<td>
			<?php 
				$result1 = $result1/1.20;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $result2/1.10;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	
	<!--Semaine 32 -->
	<?php
		$firstDay19 = '05';
		$lastDay19 = '11';
		
		$firstDay20 = '03';
		$lastDay20 = '09';
		
		$startDate19 = '2019-'.$month.'-'.$firstDay19;
		$endDate19 = '2019-'.$month.'-'.$lastDay19;
		
		$startDate20 = '2020-'.$month.'-'.$firstDay20;
		$endDate20 = '2020-'.$month.'-'.$lastDay20;
	?>
	<tr style="border-top:solid;">
		<th>Semaine 32</th>
		<th>2019</th>
		<th>2020</th>
		<th>Ecart en valeur</th>
		<th>Ecart en %</th>
		<th>Resultat en %</th>
	</tr>
	<tr>
		<td>Nb Resas</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate19,$endDate19);
				$totalresas19 += $result1;
				echo $result1;
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate20,$endDate20);
				$totalresas20 += $result2;
				echo $result2;
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	<tr>
		<td>CA TTC</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate19,$endDate19);
				$totalca19 += $result1;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate20,$endDate20);
				$totalca20 += $result2;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	<tr>
		<td>CA HT</td>
		<td>
			<?php 
				$result1 = $result1/1.20;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $result2/1.10;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	
	<!--Semaine 33 -->
	<?php
		$firstDay19 = '12';
		$lastDay19 = '18';
		
		$firstDay20 = '10';
		$lastDay20 = '16';
		
		$startDate19 = '2019-'.$month.'-'.$firstDay19;
		$endDate19 = '2019-'.$month.'-'.$lastDay19;
		
		$startDate20 = '2020-'.$month.'-'.$firstDay20;
		$endDate20 = '2020-'.$month.'-'.$lastDay20;
	?>
	<tr style="border-top:solid;">
		<th>Semaine 33</th>
		<th>2019</th>
		<th>2020</th>
		<th>Ecart en valeur</th>
		<th>Ecart en %</th>
		<th>Resultat en %</th>
	</tr>
	<tr>
		<td>Nb Resas</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate19,$endDate19);
				$totalresas19 += $result1;
				echo $result1;
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate20,$endDate20);
				$totalresas20 += $result2;
				echo $result2;
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	<tr>
		<td>CA TTC</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate19,$endDate19);
				$totalca19 += $result1;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate20,$endDate20);
				$totalca20 += $result2;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	<tr>
		<td>CA HT</td>
		<td>
			<?php 
				$result1 = $result1/1.20;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $result2/1.10;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	
	<!--Semaine 34 -->
	<?php
		$firstDay19 = '19';
		$lastDay19 = '25';
		
		$firstDay20 = '17';
		$lastDay20 = '23';
		
		$startDate19 = '2019-'.$month.'-'.$firstDay19;
		$endDate19 = '2019-'.$month.'-'.$lastDay19;
		
		$startDate20 = '2020-'.$month.'-'.$firstDay20;
		$endDate20 = '2020-'.$month.'-'.$lastDay20;
	?>
	<tr style="border-top:solid;">
		<th>Semaine 34</th>
		<th>2019</th>
		<th>2020</th>
		<th>Ecart en valeur</th>
		<th>Ecart en %</th>
		<th>Resultat en %</th>
	</tr>
	<tr>
		<td>Nb Resas</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate19,$endDate19);
				$totalresas19 += $result1;
				echo $result1;
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate20,$endDate20);
				$totalresas20 += $result2;
				echo $result2;
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	<tr>
		<td>CA TTC</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate19,$endDate19);
				$totalca19 += $result1;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate20,$endDate20);
				$totalca20 += $result2;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	<tr>
		<td>CA HT</td>
		<td>
			<?php 
				$result1 = $result1/1.20;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $result2/1.10;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	
	<!--Semaine 35 -->
	<?php
		$firstDay19 = '26';
		$lastDay19 = '31';
		
		$firstDay20 = '24';
		$lastDay20 = '30';
		
		$startDate19 = '2019-'.$month.'-'.$firstDay19;
		$endDate19 = '2019-'.$month.'-'.$lastDay19;
		
		$startDate20 = '2020-'.$month.'-'.$firstDay20;
		$endDate20 = '2020-'.$month.'-'.$lastDay20;
	?>
	<tr style="border-top:solid;">
		<th>Semaine 35 (Partie Août uniquement)</th>
		<th>2019</th>
		<th>2020</th>
		<th>Ecart en valeur</th>
		<th>Ecart en %</th>
		<th>Resultat en %</th>
	</tr>
	<tr>
		<td>Nb Resas</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate19,$endDate19);
				$totalresas19 += $result1;
				echo $result1;
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate20,$endDate20);
				$totalresas20 += $result2;
				echo $result2;
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	<tr>
		<td>CA TTC</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate19,$endDate19);
				$totalca19 += $result1;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate20,$endDate20);
				$totalca20 += $result2;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	<tr>
		<td>CA HT</td>
		<td>
			<?php 
				$result1 = $result1/1.20;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $result2/1.10;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	<!--TOTAL Aout -->
	<tr style="border-top:solid;background-color:gray;color:black;">
		<th>TOTAL AOÛT</th>
		<th>2019</th>
		<th>2020</th>
		<th>Ecart en valeur</th>
		<th>Ecart en %</th>
		<th>Resultat en %</th>
	</tr>
	<tr>
		<td>Nb Resas</td>
		<td>
			<?php 
				$result1 = $totalresas19;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $totalresas20;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	<tr>
		<td>CA TTC</td>
		<td>
			<?php 
				$result1 = $totalca19;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $totalca20;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	<tr>
		<td>CA HT</td>
		<td>
			<?php 
				$result1 = $result1/1.20;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $result2/1.10;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>


	
	<!--Été complet-->
	<tr style="background-color:black;">
		<th colspan="6" style="padding:5px;"><h1> Été complet</h1></th>
	<tr>
	
	<!--TOTAL Été -->
	<tr style="border-top:solid;background-color:gray;color:black;">
		<th>TOTAL Été</th>
		<th>2019</th>
		<th>2020</th>
		<th>Ecart en valeur</th>
		<th>Ecart en %</th>
		<th>Resultat en %</th>
	</tr>
	<tr>
		<td>Nb Resas</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother','2019-07-01','2019-08-31');
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother','2020-07-01','2020-08-31');
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	<tr>
		<td>CA TTC</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother','2019-07-01','2019-08-31');
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother','2020-07-01','2020-08-31');
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	<tr>
		<td>CA HT</td>
		<td>
			<?php 
				$result1 = $result1/1.20;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $result2/1.10;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>	

<!--Septembre-->
	<tr style="background-color:black;">
		<th colspan="6" style="padding:5px;"><h1> Septembre</h1></th>
	<tr>
	
	<?php
		$month = '09';
		
		$totalresas19 = 0;
		$totalca19 = 0;
		
		$totalresas20 = 0;
		$totalca20 = 0;
	?>
	
	
	<!--Semaine 31 -->
	<?php
		$firstDay19 = '01';
		$lastDay19 = '30';
		
		$firstDay20 = '01';
		$lastDay20 = '30';
		
		$startDate19 = '2019-'.$month.'-'.$firstDay19;
		$endDate19 = '2019-'.$month.'-'.$lastDay19;
		
		$startDate20 = '2020-'.$month.'-'.$firstDay20;
		$endDate20 = '2020-'.$month.'-'.$lastDay20;
	?>
	<tr style="border-top:solid;">
		<th>Mois complet</th>
		<th>2019</th>
		<th>2020</th>
		<th>Ecart en valeur</th>
		<th>Ecart en %</th>
		<th>Resultat en %</th>
	</tr>
	<tr>
		<td>Nb Resas</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate19,$endDate19);
				$totalresas19 += $result1;
				echo $result1;
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/nbResaFromOneDayToAnother',$startDate20,$endDate20);
				$totalresas20 += $result2;
				echo $result2;
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	<tr>
		<td>CA TTC</td>
		<td>
			<?php 
				$result1 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate19,$endDate19);
				$totalca19 += $result1;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = modules::run('stats/admin/Statsadmin/cAFromOneDayToAnother',$startDate20,$endDate20);
				$totalca20 += $result2;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo $result3;
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>
	
	<tr>
		<td>CA HT</td>
		<td>
			<?php 
				$result1 = $result1/1.20;
				echo round($result1,2);
			?>
		</td>
		<td>
			<?php
				$result2 = $result2/1.10;
				echo round($result2,2);
			?>
		</td>
		<td>
			<?php
				$result3 = $result2 - $result1;
				echo round($result3,2);
			?>
		</td>
		<td>
			<?php
				$result4 = round($result3*100/$result1,2);
				echo ($result4 < 0)?$result4:"+".$result4;
			?>
		</td>
		<td>
			<?php
				$result5 = round($result2*100/$result1,2);
				echo $result5;
			?>
		</td>
	</tr>	
	
</table>