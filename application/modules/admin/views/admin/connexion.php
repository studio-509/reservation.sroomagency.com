<?php $this->load->view('/admin/head',$this->data); ?>
<div id="page" class="tpl_connection">
	<div id="content" class="clearfix">
    	<a id="logo" href="/">logo</a>
    	<h1>Identifiez-vous</h1>
        
        <form class="formLogin" action="/admin/connexion?page=<?=$_GET['page']?>/" method="post" enctype="multipart/form-data" name="forma">
        	<fieldset>
            	

                <ul class="list_form">
                	<li>
                        <input name="user" type="text" size="30" placeholder="Nom d'utilisateur" value="<?php echo set_value('user'); ?>" />
                        <?php echo form_error('user', '<div class="error">', '</div>'); ?>
                    </li>
                    <li>
                        <input name="mdp" type="password" size="30"  placeholder="Mot de passe" />
                        <?php echo form_error('mdp', '<div class="error">', '</div>'); ?>
                    </li>
                    <li class="last">
          				<input class="button" type="submit" value="Valider" />
                    </li>
                </ul>
                <?php if(isset($error)){ echo "<p class='error'>" . $error . "</p>"; } ?>
                <p class="txt_small"><a href="">Mot de passe oublié ?</a></p>
        	</fieldset>
        </form>
    </div>
</div>
</body>
</html>
