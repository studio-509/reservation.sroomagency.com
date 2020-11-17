$('body').ready(function() {
	/**
	* Gestion onglets
	*/
	$(document).on('click','._tab_drop',function(){	var tab = '#bloc_' + $(this).attr('id');	$('._tab_bloc').addClass('hidden');	$('._tab_drop').removeClass('button_active');	$(this).addClass('button_active');	$(tab).removeClass('hidden');
	});
	
	
	/**
	* recherche client
	*/
	$('body').on('keypress', '._recherche_client', function() {		var delayInMilliseconds = 500; 		setTimeout(function() {			var search = $('._recherche_client').val();				var datas = {"search":search};	
			_Ajax.reload('/clients/admin/Clientsadmin/search_clients_list','tab_clients_search',datas);		}, delayInMilliseconds);	
	});
	
	/**
	* recherche joueur
	*/
	$('body').on('keypress', '._recherche_joueur', function() {
		var delayInMilliseconds = 500; 
		setTimeout(function() {
			var search = $('._recherche_joueur').val();	
			var datas = {"search":search};	

			_Ajax.reload('/clients/admin/Clientsadmin/search_joueurs_list','tab_joueurs_search',datas);
		}, delayInMilliseconds);	
	});
	
	/**
	* recherche société
	*/
	$('body').on('keypress', '._recherche_societe', function() {
		var delayInMilliseconds = 500; 
		setTimeout(function() {
			var search = $('._recherche_societe').val();	
			var datas = {"search":search};	

			_Ajax.reload('/clients/admin/Clientsadmin/search_societes_list','tab_societes_search',datas);
		}, delayInMilliseconds);	
	});
	/**	* affichage formulaire modification client	*/	
	$('body').on('click', '._client_add_update', function() {
		$('html, body').animate({ scrollTop: 0 }, 'fast');		var id = $(this).attr('data-id');
		
		var titre = (id=="") ? "Ajout d'un client":"Modification client";		var datas = {"titre":titre,"id":id};		_inPop.open('/clients/admin/Clientsadmin/infos', datas, 'alerte', 'fn_client.update()');
	});
	
	/**	* affichage formulaire modification joueur	*/	
	$('body').on('click', '._joueur_add_update', function() {
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		var id = $(this).attr('data-id');
		
		var titre = (id=="") ? "Ajout d'un joueur":"Modification joueur";
		var datas = {"titre":titre,"id":id};
		_inPop.open('/clients/admin/Clientsadmin/infos_joueur', datas, 'alerte', 'fn_joueur.update()');
	});
	
	/**	* affichage formulaire modification société	*/	
	$('body').on('click', '._societe_add_update', function() {
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		var id = $(this).attr('data-id');
		
		var titre = (id=="") ? "Ajout d'une société":"Modification société";
		var datas = {"titre":titre,"id":id};
		_inPop.open('/clients/admin/Clientsadmin/infos_societe', datas, 'alerte', 'fn_societe.update()');
	});
	/**	* Suppresion Client	*/	
	$('body').on('click','._client_delete',function(){		var id = $(this).attr('data-id');
		var prenom = $('._prenom_client'+id).html();
		var nom = $('._nom_client'+id).html();
		var email = $('._email_client'+id).html();		var datas = {"titre":"Suppression client","id":id,"txt":"Voulez vous vraiment supprimer "+prenom+" "+nom+" (email : "+email+") de la base clients ?"};		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_client.del('+id+')');	
	});	
	
	/**	* Suppresion Joueur	*/	
	$('body').on('click','._joueur_delete',function(){
		var id = $(this).attr('data-id');
		var prenom = $('._prenom_joueur'+id).html();
		var nom = $('._nom_joueur'+id).html();
		var email = $('._email_joueur'+id).html();
		var datas = {"titre":"Suppression joueur","id":id,"txt":"Voulez vous vraiment supprimer "+prenom+" "+nom+" (email : "+email+") de la base joueurs ?"};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_joueur.del('+id+')');	
	});	
	
	/**	* Suppresion Société	*/	
	$('body').on('click','._societe_delete',function(){
		var id = $(this).attr('data-id');
		var nom = $('._nom_societe'+id).html();
		var datas = {"titre":"Suppression société","id":id,"txt":"Voulez vous vraiment supprimer "+nom+" de la base sociétés ?"};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_societe.del('+id+')');	
	});
	
	/**	* update client	*/	
	$('body').on('click', '#_submit_client_admin_form', function(){		var required = _tools.required('form_admin_client');		var format_email = _tools.format_email('form_admin_client');	
		var titre = ($('#client_id').val()=="")?"Ajout d'un client":"Modification d'un client";		if(required == 0 && format_email == 0){			var datas = {"titre":titre,"id":$('#client_id').val(),"civil":$('#civil option:selected').val(),"nom":$('#nom').val(),"prenom":$('#prenom').val(),"email":$('#email').val(),"tel":$('#tel').val(),"login":$('#login').val(),"password":$('#password').val(),"old_pass":$('#old_pass').val()};			_Ajax.send('/clients/admin/Clientsadmin/update', datas);		}	
	});
	
	/**	* update joueur	*/	
	$('body').on('click', '#_submit_joueur_admin_form', function(){
		var required = _tools.required('form_admin_joueur');
		var format_email = _tools.format_email('form_admin_joueur');	
		var titre = ($('#joueur_id').val()=="")?"Ajout d'un joueur":"Modification d'un joueur";
		if(required == 0 && format_email == 0){
			var datas = {"titre":titre,"id":$('#joueur_id').val(),"civil":$('#civil option:selected').val(),"nom":$('#nom').val(),"prenom":$('#prenom').val(),"email":$('#email').val(),"id_reservation":$('#id_resa').val(),"login":$('#login').val(),"password":$('#password').val(),"old_pass":$('#old_pass').val()};
			_Ajax.send('/clients/admin/Clientsadmin/update_joueur', datas);
		}	
	});
	
	/**	* update société	*/	
	$('body').on('click', '#_submit_societe_admin_form', function(){
		var required = _tools.required('form_admin_societe');
		var format_email = _tools.format_email('form_admin_societe');	
		var titre = ($('#societe_id').val()=="")?"Ajout d'une société":"Modification d'une société";
		if(required == 0 && format_email == 0){
			var datas = {"titre":titre,"id":$('#societe_id').val(),"nom":$('#nom').val(),"adresse":$('#adresse').val(),"comp_adresse":$('#comp_adresse').val(),"code_postal":$('#code_postal').val(),"ville":$('#ville').val(),"tel":$('#tel').val(),"email":$('#email').val(),"nom_contact":$('#nom_contact').val(),"comment":$('#comment').val()};
			_Ajax.send('/clients/admin/Clientsadmin/update_societe', datas);
		}	
	});
	
	/**	* renvoi mdp	*/	
	$('body').on('click', '._client_password', function() {		var id = $(this).attr('data-id');		var mdp = _tools.getPassword();		var datas = {"titre":"Renvoi mot de passe","id":id,"password":mdp};		_Ajax.send('/clients/admin/Clientsadmin/pass', datas);	
	});	
	
	/**	* Gestion resultat / page	**/	$('body').on('change','._pag_setup', function(){	var datas = {'pag':$(this).val()};	_Ajax.reload('/clients/admin/Clientsadmin/search_clients_list','tab_clients_search',datas);	});	
	
	/**	* Reload après fermeture popup	**/	
	$('body').on('click','.closePopin',function(){	
		if ($('#joueurs_list').hasClass('button_active')) {
			var search = $('._recherche_client').val();	
			var datas = {"search":search};
			$('html, body').animate({ scrollTop: 0 }, 'fast');
		
			_Ajax.reload('/clients/admin/Clientsadmin/search_clients_list','tab_clients_search',datas);
		}
		if ($('#joueurs_list').hasClass('button_active')) {
			var search = $('._recherche_joueur').val();	
			var datas = {"search":search};
			$('html, body').animate({ scrollTop: 0 }, 'fast');
		
			_Ajax.reload('/clients/admin/Clientsadmin/search_joueurs_list','tab_joueurs_search',datas);	
			
		}
		if ($('#societes_list').hasClass('button_active')) {
			var search = $('._recherche_societe').val();	
			var datas = {"search":search};
			$('html, body').animate({ scrollTop: 0 }, 'fast');
		
			_Ajax.reload('/clients/admin/Clientsadmin/search_societes_list','tab_societes_search',datas);	
			
		}
	});
});
	
	var fn_client = {	
		del : function(id){			var datas = {"titre":"Suppression client","txt":"Le client à bien été supprimé","id":id};			_inPop.open('/clients/admin/Clientsadmin/delete', datas, 'alerte');			$('#_tr'+id).slideUp(500);
			}
	};
	var fn_joueur = {	
		del : function(id){
			var datas = {"titre":"Suppression joueur","txt":"Le joueur à bien été supprimé","id":id};
			_inPop.open('/clients/admin/Clientsadmin/delete_joueur', datas, 'alerte');
			$('#_tr'+id).slideUp(500);
			}
	};
	var fn_societe = {	
		del : function(id){
			var datas = {"titre":"Suppression société","txt":"La société à bien été supprimée","id":id};
			_inPop.open('/clients/admin/Clientsadmin/delete_societe', datas, 'alerte');
			$('#_tr'+id).slideUp(500);
			}
	};