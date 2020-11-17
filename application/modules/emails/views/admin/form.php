<form name="form" id="email_form">
	<fieldset>
		<ul class="list_form">
			<li>
                <label>action <span class="obligatoire">*</span> :</label>
                <select name="action" id="action">
	                <?php foreach($actions as $action): ?>
	                	<option value="<?=$action->id?>" <?=(isset($email->action) && $email->action == $action->action)?'selected="selected"':''?>><?=$action->action_detail?></option>
	                <?php endforeach; ?>
                </select>
            </li>
            <li>
                <label>sujet <span class="obligatoire">*</span> :</label>
                <input type="text" class="_required" name="sujet" id="sujet" value="<?=(isset($email->sujet))?$email->sujet:""?>" />
                <div class="error masque2" id="error_action">L'action est obligatoire</div>
            </li>
            <li>
                <label>Message <span class="obligatoire">*</span> :</label>
                <textarea class="_required" name="message" id="message"><?=(isset($email->message))?$email->message:""?></textarea>
                <div class="error masque2" id="error_action">Le message est obligatoire</div>
            </li>
		</ul>
		
		<input type="hidden" name="email_id" id="email_id" value="<?=(isset($email->id))?$email->id:""?>" />
		
		<ul class="list_action">
        	<li>
                <input type="button" class="button btn_L btn_annul" value="Annuler" onClick="_inPop.close(this)" />
            </li>
            <li>
                <input class="button btnBlue" type="button" name="submit" id="_submit_email_admin_form" value="Valider" />
            </li>
        </ul>
	</fieldset>
</form>