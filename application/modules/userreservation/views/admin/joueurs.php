<label>Nombre de joueurs :</label>
<select name="joueurs" id="joueurs">
	<option value="0" <?=($joueurs>$nbmax || $joueurs <$nbmin || $joueurs=='' || $joueurs==0)?'selected':''?>>--</option>
  <?php for($i = $nbmin; $i <= $nbmax; $i++): ?>
    <option value="<?=$i?>" <?=($joueurs==$i)?'selected':''?>><?=$i?></option>
  <?php endfor; ?>
</select>