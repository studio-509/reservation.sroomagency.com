$('body').ready(function() {
	/**
	* Gestion onglets
	*/
	$(document).on('click','._tab_drop',function(){	var tab = '#bloc_' + $(this).attr('id');
		$('._tab_bloc').addClass('hidden');
		$('._tab_drop').removeClass('button_active');	
		$(this).addClass('button_active');
		$(tab).removeClass('hidden');
	});
	
	
	
	/**
	* recherche partie
	*/
	$('body').on('keypress', '._recherche_games', function() {
		var delayInMilliseconds = 500; 
		setTimeout(function() {
			var search = $('._recherche_games').val();
			var searchstart = $('#datesearchstart').val();
			var searchend = $('#datesearchend').val();
			var datas = {"search":search,"searchstart":searchstart,"searchend":searchend};
	
			_Ajax.reload('/games/admin/Gamesadmin/search_games_list','tab_games_search',datas);
		}, delayInMilliseconds);
	
	});
	
	/**
	* recherche partie date
	*/
	$('body').on('change', '#datesearchstart, #datesearchend', function() {
			var search = $('._recherche_games').val();
			var searchstart = $('#datesearchstart').val();
			var searchend = $('#datesearchend').val();
			var datas = {"search":search,"searchstart":searchstart,"searchend":searchend};
	
			_Ajax.reload('/games/admin/Gamesadmin/search_games_list','tab_games_search',datas);	
	});
	
	$('body').on('change', '#lien_photo_file', function() {
			var fileadress = $(this).val().split("\\");
			$("#lien_photo").val(fileadress[2]);	
	});
	
	$('body').on('click', '.load_photo_file', function() {
			$('#lien_photo_file').trigger("click");	
	});
	
	
	/**	* affichage formulaire modification partie jouée	*/	
	$('body').on('click', '._games_add_update', function() {
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		var idresa = $(this).attr('data-id');		
		var titre = "Modification d'une partie jouée";
		var datas = {"titre":titre,"idresa":idresa};
		_inPop.open('/games/admin/Gamesadmin/infos', datas, 'alerte', 'fn_games.update()');
	});
	
	/**	* charger informations réservation dans formulaire	*/	
	$('body').on('click', '.load_resa_infos', function() {
		$('#nb_joueurs').val($('#resa_nbjoueurs').val());
		$('#prenom_j1').val($('#client_prenom').val());
		$('#nom_j1').val($('#client_nom').val());
		$('#email_j1').val($('#client_email').val());
		$('.resa_joueur').each(function() {
			var queljoueur = $(this).attr('data-id');
			var email = $(this).val();
			$('#email_j'+queljoueur).val(email);
		});		
		var nbjoueurs = parseInt($('#resa_nbjoueurs').val(),10);
		$('.infos_joueurs').each(function() {
			$(this).addClass('hidden');
		});
		for (var i=1;i<nbjoueurs+1;i++) {
			$('#infos_j'+i).removeClass('hidden');
		}
	});
	
	/**	* charger informations réservation dans formulaire	*/	
	$('body').on('keypress', '#nb_joueurs', function() {
		
		var delayInMilliseconds = 500; 
		
		setTimeout(function() {
			var nbjoueurs = parseInt($('#nb_joueurs').val(),10);
			$('.infos_joueurs').each(function() {
				$(this).addClass('hidden');
			});
			for (var i=1;i<nbjoueurs+1;i++) {
				$('#infos_j'+i).removeClass('hidden');
			}
		}, delayInMilliseconds);
	});
	
	/**	* formatage heure	*/	
 	$('body').on('keypress', '#tps_jeu', function(e) {
		var touche = String.fromCharCode(e.which);
		var testkey = /[0-9]/.test(touche);
		if (testkey) {		
			var delayInMilliseconds = 100; 		
			setTimeout(function() {
				if ($('#tps_jeu').val().length == 1) $('#tps_jeu').val(touche);
				else if ($('#tps_jeu').val().length == 2) $('#tps_jeu').val($('#tps_jeu').val());
				else if ($('#tps_jeu').val().length == 3) $('#tps_jeu').val($('#tps_jeu').val().substr(0,1)+':'+$('#tps_jeu').val().substr(1,1)+$('#tps_jeu').val().substr(2,1));
				else if ($('#tps_jeu').val().length == 5) $('#tps_jeu').val($('#tps_jeu').val().substr(0,1)+$('#tps_jeu').val().substr(2,1)+':'+$('#tps_jeu').val().substr(3,1)+$('#tps_jeu').val().substr(4,1));
				else if ($('#tps_jeu').val().length == 6) $('#tps_jeu').val($('#tps_jeu').val().substr(0,1)+':'+$('#tps_jeu').val().substr(1,1)+$('#tps_jeu').val().substr(3,1)+':'+$('#tps_jeu').val().substr(4,1)+$('#tps_jeu').val().substr(5,1));
				else if ($('#tps_jeu').val().length == 8) $('#tps_jeu').val($('#tps_jeu').val().substr(0,1)+$('#tps_jeu').val().substr(2,1)+':'+$('#tps_jeu').val().substr(3,1)+$('#tps_jeu').val().substr(5,1)+':'+$('#tps_jeu').val().substr(6,1)+$('#tps_jeu').val().substr(7,1));
			}, delayInMilliseconds);
		}
		else {
			//alert($('#tps_jeu').val().length);
 			if ($('#tps_jeu').val().length == 0) {
				var delayInMilliseconds = 50; 		
				setTimeout(function() {
					$('#tps_jeu').val("");
				}, delayInMilliseconds);
			}
 			else {
				var delayInMilliseconds = 50; 		
				setTimeout(function() {
					$('#tps_jeu').val($('#tps_jeu').val().substr(0,$('#tps_jeu').val().length-1));
				}, delayInMilliseconds);
				
			}  
		}
			
	}); 
	
 	$('body').on('focus', '#tps_jeu', function() {
		$('#tempsreal').val($('#tps_jeu').val());
		$('#tps_jeu').val('');
	});
	
	$('body').on('focusout', '#tps_jeu', function() {
		if ($(this).val() == "") {
			if ($('#tempsreal').val() != "") $(this).val($('#tempsreal').val());
			else $(this).val('00:00:00');			
		}
		else if ($(this).val().length <8) {
			var nbcarac = 8 - $(this).val().length;
			var basestring = "00:00:00";
			$(this).val(basestring.substr(0,nbcarac)+$(this).val());
		}
	}); 
	
	
	/**	* formatage indices	*/	
 	$('body').on('keypress', '#nb_indices', function(e) {
		var touche = String.fromCharCode(e.which);
		var testkey = /[0-9]/.test(touche);
		if (!testkey) {
 			if ($('#nb_indices').val().length == 0) {
				var delayInMilliseconds = 50; 		
				setTimeout(function() {
					$('#nb_indices').val("");
				}, delayInMilliseconds);
			}
 			else {
				var delayInMilliseconds = 50; 		
				setTimeout(function() {
					$('#nb_indices').val($('#nb_indices').val().substr(0,$('#nb_indices').val().length-1));
				}, delayInMilliseconds);
				
			}  
		}
			
	}); 
	
 	$('body').on('focus', '#nb_indices', function() {
		if ($(this).val() == "n/a") $('#nb_indices').val('');
	});
	
	$('body').on('focusout', '#nb_indices', function() {
		if ($(this).val() == "") $('#nb_indices').val('n/a');		
		
	}); 
	
	
	
	/**	* Suppresion partie	*/	
	$('body').on('click','._games_delete',function(){
		var id = $(this).attr('data-id');
		var jour = $('._jour_resa'+id).html();
		var horaire = $('._horaire_resa'+id).html();
		var nom_salle = $('._nom_salle'+id).html();
		var nom_equipe = $('._nom_equipe'+id).html();
		var datas = {"titre":"Suppression partie jouée","id":id,"txt":"Voulez vous vraiment supprimer la partie du <strong>"+jour+"</strong> à <strong>"+horaire+"</strong> pour la salle <strong>"+nom_salle+"</strong>? <br>Nom d'équipe : <strong>"+nom_equipe+"</strong>"};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_games.del('+id+')');	
	});	
	
	/**	* update partie	*/	
	$('body').on('click', '#_submit_games_admin_form', function(){
		
		var id = $('#game_id').val();
		var id_resa = $('#resa_id').val();
		var nom_equipe = $('#nom_equipe').val();
		var nb_joueurs = $('#nb_joueurs').val();
		var reussite = ($('#reussite').checked == true)?'1':'0';
		var nb_indices = $('#nb_indices').val();
		var tps_jeu = ($('#tps_jeu').val() == "n/a")?"":$('#tps_jeu').val();
		var lien_photo = $('#lien_photo').val();
		var pub_photo = ($('#pub_photo').checked == true)?'1':'0';
		var envoi_photo = ($('#envoi_photo').checked == true)?'1':'0';
		var envoi_mail = ($('#envoi_mail').checked == true)?'1':'0';
		var commentaire = $('#commentaire').val();
		var infos_joueurs = "";
		for (var i=1;i<parseInt(nb_joueurs,10)+1;i++) {
			if (($('#prenom_j'+i).val() != "") || ($('#nom_j'+i).val() != "") || ($('#email_j'+i).val() != "") || ($('#postal_j'+i).val() != "") || ($('#niveau_j'+i+' option:selected').val() != "no") || ($('#vecteur_j'+i+' option:selected').val() != "no")) {
				infos_joueurs += ($('#id_j'+i).val() != "")?$('#id_j'+i).val()+'|':'no|';
				infos_joueurs += (id !='')?id+'|':'no|';
				infos_joueurs += ($('#nom_j'+i).val() != "")?$('#nom_j'+i).val()+'|':'no|';
				infos_joueurs += ($('#prenom_j'+i).val() != "")?$('#prenom_j'+i).val()+'|':'no|';
				infos_joueurs += ($('#email_j'+i).val() != "")?$('#email_j'+i).val()+'|':'no|';
				infos_joueurs += ($('#postal_j'+i).val() != "")?$('#postal_j'+i).val()+'|':'no|';
				infos_joueurs += $('#niveau_j'+i+' option:selected').val()+'|';
				infos_joueurs += $('#vecteur_j'+i+' option:selected').val()+'||';
			}
		}
		infos_joueurs = infos_joueurs.substr(0,infos_joueurs.length-2);
		
		
/* 		var required = _tools.required('form_admin_games');
		var format_email = _tools.format_email('form_admin_games');	
		*/
		var titre = ($('#game_id').val()=="")?"Ajout d'une partie jouée":"Modification d'une partie jouée";
		
		//if(required == 0 && format_email == 0){
			var datas = {"titre":titre,"id":id,"id_resa":id_resa,"nom_equipe":nom_equipe,"nb_joueurs":nb_joueurs,"reussite":reussite,"nb_indices":nb_indices,"tps_jeu":tps_jeu,"lien_photo":lien_photo,"pub_photo":pub_photo,"envoi_photo":envoi_photo,"envoi_mail":envoi_mail,"commentaire":commentaire,"infos_joueurs":infos_joueurs};
			_Ajax.send('/games/admin/Gamesadmin/update', datas);
		//} 	
	});
	
	
	/**	* Reload après fermeture popup	**/	
	$('body').on('click','.closePopin',function(){	
		
		var search = $('._recherche_games').val();	
		var datas = {"search":search};
		$('html, body').animate({ scrollTop: 0 }, 'fast');
	
		_Ajax.reload('/games/admin/Gamesadmin/search_games_list','tab_games_search',datas);
		
	});
});
	
var fn_games = {	
	del : function(id){
			var datas = {"titre":"Suppression partie jouée","txt":"La partie jouée a bien été supprimée","id":id};
			_inPop.open('/games/admin/Gamesadmin/delete', datas, 'alerte');
			$('#_tr'+id).slideUp(500);
		}
};
	