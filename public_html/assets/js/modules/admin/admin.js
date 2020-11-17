$('body').ready(function() {

	/**
     * suppression admin
     */
    $('body').on('click', '._admin_delete', function() {
		var id = $(this).attr('data-id');
		var datas = {"titre":"Suppression admin","txt":"Voulez vous vraiment supprimer cet admin ?"};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_admin.del('+id+')');
    	});

    /**
     * affichage formulaire modification admin
     */
    $('body').on('click', '._admin_update', function() {
		var id = $(this).attr('data-id');
		var titre = (id == '')?'Ajout admin':'Modification admin';
		var callback = (id == '')?'fn_admin.add()':'fn_admin.update()';
		var datas = {"titre":titre,"id":id};
		_inPop.open('/admin/infos', datas, 'alerte', callback);
    });

    /**
     * update admin
     */
    $('body').on('click', '#_submit_admin_form', function(){
	    var required = _tools.required('admin_form');
	    if(required == 0){
	    	var id = $('#admin_id').val();
			var titre = (id == '')?'Ajout admin':'Modification admin';
			var datas = {"titre":titre,"id":$('#admin_id').val(),"nom":$('#nom').val(),"prenom":$('#prenom').val(),"email":$('#email').val(),"login":$('#login').val(),"password":$('#password').val(),"old_pass":$('#old_pass').val()};
			_Ajax.send('/admin/update', datas);
			}
    });

    /**
     * renvoi mdp
     */
    $('body').on('click', '._admin_password', function() {
	    var id = $(this).attr('data-id');
	    var mdp = _tools.getPassword();
		var datas = {"titre":"Renvoi mot de passe","id":id,"password":mdp};
	    _Ajax.send('/admin/pass', datas);
    });

    /**
	 * génération mot de passe formulaire
	 **/
	$('body').on('click', '#_form_admin_pass', function(){
		var mdp = _tools.getPassword();
		$('#password').val(mdp);
	});

});

var fn_admin = {

	del : function(id){
		var datas = {"titre":"Suppression admin","txt":"Le admin à bien été supprimé","id":id};
		_inPop.open('/admin/delete', datas, 'alerte');
		$('#_tr'+id).slideUp(500);
	}
};

function HeureCheckEJS(){
	krucial = new Date;
	heure = krucial.getHours();
	min = krucial.getMinutes();
	sec = krucial.getSeconds();
	jour = krucial.getDate();
	mois = krucial.getMonth()+1;
	annee = krucial.getFullYear();
	if (sec < 10)
		sec0 = "0";
	else
		sec0 = "";
	if (min < 10)
		min0 = "0";
	else
		min0 = "";
	if (heure < 10)
		heure0 = "0";
	else
		heure0 = "";
	DinaHeure = heure0 + heure + ":" + min0 + min + ":" + sec0 + sec;
	which = DinaHeure
	if (document.getElementById){
		document.getElementById("ejs_heure").innerHTML=which;
	}
	setTimeout("HeureCheckEJS()", 1000)
	}
window.onload = HeureCheckEJS;
