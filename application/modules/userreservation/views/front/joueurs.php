<h3 class="labelResa" id="selectionJoueurs" >2. Sélectionnez le nombre de joueurs&nbsp;</h3>


<select name="joueurs" id="joueurs">

	<option value="0">--</option>


  <?php for($i = $nbmin; $i <= $nbmax; $i++): 
	if ($i):
  
  ?>


    <option value="<?=$i?>" <?=($i == $nbjoueursmaint)?'selected="selected"':''?>><?=$i?></option>


  <?php 
  endif;
  endfor; ?>


</select>
