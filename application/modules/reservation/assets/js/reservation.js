$(document).ready(function() {

	/**
	* afficher mode de paiement
	*/
	$('body').on('click', '._payment_mode', function() {
		var id = $(this).attr('data-id');
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		var titre = 'Mode(s) de paiement';
		var datas = {'id':id,'titre':titre};
		_inPop.open('/reservation/admin/Reservationadmin/mode_paiement', datas, 'success');

	});

	/**
	* ouverture form ajout mode de paiement
	*/
	$('body').on('click', '._add_mode_paiement', function() {
		$(this).addClass('hidden');
		$('#add_paiement_form').removeClass('hidden');
	});

	/**
	* annulation form ajout mode de paiement
	*/
	$('body').on('click', '#cancel_add_paiement', function() {
		$('#add_paiement_form').addClass('hidden');
		$('._add_mode_paiement').removeClass('hidden');
	});

	/**
	* validation ajout mode de paiement
	*/
	$('body').on('click', '#add_paiement', function() {
		var idresa = $(this).attr('data-id');
		var required = _tools.required('add_paiement_form');
		if (required == 0) {
			var modep = $('#modep option:selected').val();
			var reference = $('#reference').val();
			var montant = $('#montant').val();
		}
		var datas = {'id_resa':idresa,'modep':modep,'reference':reference,'montant':montant};
		_Ajax.reload('/reservation/admin/Reservationadmin/add_mode_paiement','mode_paiement_tab' ,datas);
	});

	/**
	* suppresion mode de paiement
	*/
	$('body').on('click', '._del_paiement', function() {
		var idresa = $('#add_paiement').attr('data-id');
		var id = $(this).attr('data-id');
		var datas = {'id':id,'id_resa':idresa};
		_Ajax.reload('/reservation/admin/Reservationadmin/del_mode_paiement','mode_paiement_tab' ,datas);
	});

	/**
	* afficher commentaires réservation
	*/
	$('body').on('click', '._comment_resa', function() {
		var id = $(this).attr('data-id');
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		var datas = {'id':id};
		_inPop.open('/reservation/admin/Reservationadmin/loadComment', datas, 'success');

	});

	/**
	* afficher infos société
	*/
	$('body').on('click', '._societe_resa', function() {
		var id = $(this).attr('data-id');
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		var datas = {'id':id};
		_inPop.open('/reservation/admin/Reservationadmin/loadCompanyinfos', datas, 'success');

	});

	/**
	* suppression reservation
	*/
	$('body').on('click', '._reservation_delete', function() {
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		var id = $(this).attr('data-id');
		if ($(this).attr('resindis') == 'resa') {
			var datas = {"titre":"Suppression reservation","txt":"Voulez vous vraiment supprimer la reservation de "+$(this).attr('data-client')+", le "+$(this).attr('data-date')+" pour le scénario "+$(this).attr('data-scenario')+" ?"};
			_inPop.open('/popin/confirm', datas, 'alerte', 'fn_reservation.del('+id+')');
		}
		else {
			var datas = {"titre":"Suppression indisponibilité","txt":"Voulez vous vraiment supprimer cette indisponibilité ?"};
			_inPop.open('/popin/confirm', datas, 'alerte', 'fn_reservation.delindispo('+id+')');
		}

	});
	/**
	* update reservation
	*/
	$('body').on('click', '._reservation_update', function(){
		var id = $(this).attr('data-id');
		var hiddensalle = '#hidden'+id;
		var idsalle = $(hiddensalle).attr('data-id');
		$('#id_reservation').val(id);
		var tab = '#bloc_resa_cal';
		$('._tab_bloc').hide();
		$('._tab_drop').removeClass('button_active');
		$(tab).show();
		$('#resa_cal').addClass('button_active');
		$('#select_options').show();
		$('._add_resa').addClass('hidden');
		$('._add_indispo').addClass('hidden');
		$('#sel').removeClass('hidden');
		$('#salle-admin').val(idsalle);
		var datas = {"id_reservation":id,"salle":idsalle,"addResa":1};
		temp = _Ajax.callback('/reservation/admin/Reservationadmin/getResaInfos', datas, 'fn_reservation');
		_Ajax.reload('/reservation/admin/Reservationadmin/infos_up','info_resa' ,datas, function(){
			$('html, body').animate({ scrollTop: $('#formrow').offset().top-80 }, 'fast');
		});
			_Ajax.reload('/reservation/admin/Reservationadmin/calendar', 'calendar', datas);


	});
	/**
	* onglets
	*/
	$('._tab_drop').click(function(){
		var tab = '#bloc_' + $(this).attr('id');
		$('._tab_bloc').hide();
		$('._tab_drop').removeClass('button_active');
		$(tab).show();
		$(this).addClass('button_active');
		$('#select_options').show();
		$('#salle_reservation').val('');
		$('#joueurs_reservation').val('');
		if ($(this).attr('id')=='resa_liste') {
			$('#info_resa').html('');
			$('#addIndispo').val(0);
			$('#addResa').val(0);
			$('#formrow').remove();
			$('#sel').addClass('hidden');
			$('._add_indispo,._add_resa').removeClass('hidden');
		}
		else {
			var addIndispo = 0;
			var addResa = 0;
		}
		if (($(this).attr('id')=='resa_cal')) {
			var datas = {"salle":1};
			$('#salle-admin').val('1');
			$('#joueurs').val("0");
			_Ajax.reload('/reservation/admin/Reservationadmin/calendar', 'calendar', datas);
		}

	});
	/**
	* jump semaines
	*/
	$('body').on('click', '._cal_drop', function(){
		var time = $(this).attr('data-id');
		var origine = $(this).attr('data-orig');
		// var link = (origine == 'admin')?'admin/Reservationadmin':'Reservation';
		if (origine == 'admin'){
			var link = 'admin/Reservationadmin';
			var salle = $('#salle-admin option:selected').val();
		} else {
			var link = 'Reservation';
			var salle = $('#salle option:selected').val();
			var idresamaintien = $('#id_resa_maintien_modif').val();
		}
		var datas = {"start":time,"salle":salle,"addIndispo":$('#addIndispo').val(),"addResa":$('#addResa').val(),"idresamaintien":idresamaintien};
		_Ajax.reload('/reservation/' + link + '/calendar', 'calendar', datas);
	});
	/**
	* jump jour
	*/
	$('body').on('click', '._cal_drop_mobile', function(){
		var time = $(this).attr('data-id');
		var origine = $(this).attr('data-orig');
		var link = (origine == 'admin')?'admin/Reservationadmin':'Reservation';
		var datas = {"start":time};
		_Ajax.reload('/reservation/' + link + '/mobileCalendar', 'calendar', datas);
	});
	/**
	* jump salles front
	*/
	$(document).on('change','#salle',function(){
		var time = $('#maintiendate').val();
		var id = $('#salle option:selected').val();
		var origine = $(this).attr('data-orig');
		var mobile = ($(this).attr('data-mobile') == 0)?'calendar':'mobileCalendar';
		var link = (origine == 'admin')?'admin/Reservationadmin':'Reservation';
		var idresamaintien = $('#id_resa_maintien_modif').val();
		var datas = {"salle":id,"start":time,"idresamaintien":idresamaintien};
		if (origine == 'admin'){
			_Ajax.reload('/reservation/Reservation/getNbmax', 'sel', datas);
			_Ajax.reload('/reservation/' + link + '/' + mobile, 'calendar', datas);
		}
		if(origine == 'front'){
			_Ajax.reload('/reservation/Reservation/index','_calendrier',datas);
			_Ajax.change_uri('/reservation/Reservation/changeUri', datas);
		}
	});

	/**
	 * ouverture et fermeture menu mobile
	 */

	jQuery(document).ready(function($){
    $(".btn-menu-mobile").on("click", function(event) {
        event.preventDefault();
		$this=$(this);
		if($this.hasClass('is-opened'))
			{
				$this.addClass('is-closed').removeClass('is-opened');
			}
		else
			{
				$this.removeClass('is-closed').addClass('is-opened');
			}
        $("#nav-mobile").slideToggle("slow");
        $this.toggleClass("active");
		});
	});

	/**
	 * jump horaire front mobile
	 */
 	$('body').on('touchend click', '._mobile_front_resa', cancelDuplicates(function(){
		var horaire = $(this).attr('data-hour');
		var nbjoueurs = $('#joueursMobile option:selected').val();
		var nom = $('#nom').val();
		var prenom = $('#prenom').val();
		var email = $('#email').val();
		var tel = $('#tel').val();
		var voucher = $('#voucher').val();
		var civil = $('#civil option:selected').val();
		if ($('#dateCalendarMobile').val() != '') {
			var timestamp = parseInt((new Date($('#dateCalendarMobile').val()).getTime() / 1000).toFixed(0));
			var maintiendate = timestamp;
		}
		else {
			maintiendate = '';
		}
		var id = $('#salle_mobile option:selected').val();
		jQuery.ajax({
			type: 'POST',
			url: '/reservation/Reservation/changeMobileUri',
			data: {
				'salle': id,
				'start':maintiendate,
				'nbjoueurs':nbjoueurs,
				'horaire':horaire,
				'nom':nom,
				'prenom':prenom,
				'email':email,
				'tel':tel,
				'civil':civil,
				'voucher':voucher,
				'jump':'horaire'
			},
			success: function(data, textStatus, jqXHR) {
				window.location.href = data;
				},
			error: function(jqXHR, textStatus, errorThrown) {
				//alert("errortototititi");
				}
			});
	}));


	/**
	 * jump date front mobile
	 */
 	$('#dateCalendarMobile').change(function(){
		var nbjoueurs = $('#joueursMobile option:selected').val();
		var nom = $('#nom').val();
		var prenom = $('#prenom').val();
		var email = $('#email').val();
		var tel = $('#tel').val();
		var voucher = $('#voucher').val();
		var civil = $('#civil option:selected').val();
		if ($('#dateCalendarMobile').val() != '') {
			var timestamp = parseInt((new Date($('#dateCalendarMobile').val()).getTime() / 1000).toFixed(0));
			var maintiendate = timestamp;
		}
		else {
			maintiendate = '';
		}
		var id = $('#salle_mobile option:selected').val();
		jQuery.ajax({
			type: 'POST',
			url: '/reservation/Reservation/changeMobileUri',
			data: {
				'salle': id,
				'start':maintiendate,
				'nbjoueurs':nbjoueurs,
				'nom':nom,
				'prenom':prenom,
				'email':email,
				'tel':tel,
				'civil':civil,
				'voucher':voucher,
				'jump':'date'
			},
			success: function(data, textStatus, jqXHR) {
				window.location.href = data;
				},
			error: function(jqXHR, textStatus, errorThrown) {
				//alert("error");
				}
			});
	});

	/**
	 * jump nbjoueurs front mobile
	 */
	$('#joueursMobile').change(function(){
		var nom = $('#nom').val();
		var prenom = $('#prenom').val();
		var email = $('#email').val();
		var tel = $('#tel').val();
		var voucher = $('#voucher').val();
		var horaire = $('.horaire_mobile_selected').attr('data-hour');
		var nbjoueurs = $('#joueursMobile option:selected').val();
		var civil = $('#civil option:selected').val();
		if ($('#dateCalendarMobile').val() != '') {
			var timestamp = parseInt((new Date($('#dateCalendarMobile').val()).getTime() / 1000).toFixed(0));
			var maintiendate = timestamp;
		}
		else {
			maintiendate = '';
		}
		var id = $('#salle_mobile option:selected').val();;
		jQuery.ajax({
			type: 'POST',
			url: '/reservation/Reservation/changeMobileUri',
			data: {
				'salle': id,
				'start':maintiendate,
				'nbjoueurs':nbjoueurs,
				'horaire':horaire,
				'nom':nom,
				'prenom':prenom,
				'email':email,
				'tel':tel,
				'civil':civil,
				'voucher':voucher,
				'jump':'nbjoueurs'

			},
			success: function(data, textStatus, jqXHR) {
				window.location.href = data;
				},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("error");
				}
			});
	});

	/**
	 * jump salles front mobile
	 */
	$('#salle_mobile').change(function(){
		var nom = $('#nom').val();
		var prenom = $('#prenom').val();
		var email = $('#email').val();
		var tel = $('#tel').val();
		var voucher = $('#voucher').val();
		var horaire = $('.horaire_mobile_selected').attr('data-hour');
		var nbjoueurs = $('#joueursMobile option:selected').val();
		var civil = $('#civil option:selected').val();
		if (($('#dateCalendarMobile').val())&&($('#dateCalendarMobile').val() != '')) {
			var timestamp = parseInt((new Date($('#dateCalendarMobile').val()).getTime() / 1000).toFixed(0));
			var maintiendate = timestamp;
		}
		else {
			maintiendate = '';
		}

		var id = $('#salle_mobile option:selected').val();
		jQuery.ajax({
			type: 'POST',
			url: '/reservation/Reservation/changeMobileUri',
			data: {
				'salle': id,
				'start':maintiendate,
				'nbjoueurs':nbjoueurs,
				'horaire':horaire,
				'nom':nom,
				'prenom':prenom,
				'email':email,
				'tel':tel,
				'civil':civil,
				'voucher':voucher,
				'jump':'salle'
			},
			success: function(data, textStatus, jqXHR) {
				window.location.href = data;
				},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("error");
				}
			});
	});
	/**
	* jump salles admin
	*/
	$('#salle-admin').change(function(){
		var addIndispo = $('#addIndispo').val();
		var addResa = $('#addResa').val();

		var joueurs = $('#joueurs').val();
		if ((typeof addIndispo !== 'undefined') && addIndispo==1) {
			$('#indisSel').html('');
			$('#validbuttonarea').remove();
		}
		if (typeof addIndispo == 'undefined') {
			var addIndispo = 0;
		}
		if (typeof addResa == 'undefined') {
			var addResa = 0;
		}
		var selectsallename = $('#salle-admin option:selected').text();
		$('#salle_resa_nom').html(selectsallename);
		$('#formrow').addClass('hidden');
		var id = $('#salle-admin option:selected').val();
		var datas = {"salle":id,'addIndispo':addIndispo,'addResa':addResa,'joueurs':joueurs};
		message = JSON.stringify(datas);
		jQuery.ajax({
  			type: 'POST',
  			url: '/reservation/admin/Reservationadmin/getNbmax',
  			data: {
	  			'message':message
  			},
  			success: function(data, textStatus, jqXHR) {
                    $('#sel').html(data);

					var nbjoueurs = $('#joueurs').val();

					for(i=1;i<6;i++){
						$('#form_joueur'+i).hide();
					}

					for(i=1;i<nbjoueurs;i++){
						$('#form_joueur'+i).show();
					}
            },
  			error: function(jqXHR, textStatus, errorThrown) {
	  			alert("error");
	  		}
		});
		_Ajax.reload('/reservation/admin/Reservationadmin/calendar', 'calendar', {'start':$('.toto').attr('data-day'),'salle':$('#salle-admin option:selected').val(),'addIndispo':addIndispo,'addResa':addResa});
	});
	/**
	* Affichage formulaire reservation admin
	**/
	$('body').on('click','._add_resa',function(){
		var id = $(this).attr('data-id');
		var hiddensalle = '#hidden'+id;
		//var idsalle = $(hiddensalle).attr('data-id');
		addIndispo = 0 ;
		addResa = 1 ;
		$('.calday').css({
			'cursor':'default',
			'text-decoration': 'none'
		});
		$('#id_reservation').val('');
		var tab = '#bloc_resa_cal';
		$('._tab_bloc').hide();
		$('._tab_drop').removeClass('button_active');
		$(tab).show();
		$('#resa_cal').addClass('button_active');
		$('#select_options').show();
		$('#salle_reservation').val('');
		$('#joueurs_reservation').val('');
		$('#sel').removeClass('hidden');
		$('#salle-admin').val('1');
		$('#joueurs').val("0");
		var datas = {"id_reservation":id,"addResa":1,"salle":1};
		_Ajax.reload('/reservation/admin/Reservationadmin/infos_up','info_resa' ,datas);
			_Ajax.reload('/reservation/admin/Reservationadmin/calendar', 'calendar', datas);
	});
	/**
	* Champs joueurs xx dynamique
	**/
	$('body').on('change','#joueurs',function(){
		var nbJoueurs = $(this).val();

		for(i=1;i<6;i++){
			$('#form_joueur'+i).hide();
		}

		for(i=1;i<nbJoueurs;i++){
			$('#form_joueur'+i).show();
		}
		var jour = $(this).attr('data-day');
		var horaire = $(this).attr('data-hour');
		var salle = $('#salle-admin option:selected').val();
		var joueurs = $('#joueurs option:selected').val();
		if ($('#jour_resa').val() != '' && $('#horaire_resa').val() != '' && joueurs !='0' && $('input[name=tarifstand]:checked').val()=='1') {
			var datas = {"jour":jour,'horaire':horaire,'joueurs':joueurs,'salle':salle};
			message = JSON.stringify(datas);
			jQuery.ajax({
				type: 'POST',
				url: '/reservation/admin/Reservationadmin/calculPrix',
				data: {
					'message':message
				},
				success: function(data, textStatus, jqXHR) {
						$('#tarif').val(data)
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert("error");
				}
			});
		}
		/* for(i=5;i>=nbJoueurs;i--){
			$('#form_joueur'+i).hide();
		} */
	});
	/**
	* affichage/masquage champ tarif special
	*/
	$('body').on('change','#tarifstand', function() {
		if ($('input[name=tarifstand]:checked').val()=='1') $('#tarif').prop("disabled", true);
		else $('#tarif').prop("disabled", false);
	});
	/**
	* affichage/masquage des infos société
	*/
	$('body').on('change','input[name=societe]', function() {
		if ($('input[name=societe]:checked').val()=='1') {
			$('#infossociete').show();
			if ($('input[name=tel_societe]').val()=='') $('input[name=tel_societe]').val($('input[name=tel]').val());
			if ($('input[name=email_societe]').val()=='') $('input[name=email_societe]').val($('input[name=email]').val());
			if ($('input[name=nom_contact_societe]').val()=='' && $('input[name=prenom]').val()!='' && $('input[name=nom]').val()!='') $('input[name=nom_contact_societe]').val($('input[name=prenom]').val()+' '+$('input[name=nom]').val());
		}
		else $('#infossociete').hide();
	});
	/**
	* add/update resa admin
	*/
	$('body').on('click', '#_submit_resa_admin_form', function(){
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		$('.error').each(function(){
			if($(this).is(':visible'))$(this).hide();
		});
		$('.bg_error').each(function(){
			$(this).removeClass('bg_error');
		});
		var tarifstand = ($('input[name=tarifstand]:checked').val()=='1')?'1':'0';
		var tarif = (tarifstand != '1')?$('#tarif').val():'';
		var comment = (($('#comment').val().length)&&($('#comment').val()!='Écrivez un commentaire'))?$('#comment').val():'';
		var envoimail = $('input[name=envoimail]:checked').val()||'';

		var id_societe = $('#id_societe').val();
		var societe = $('input[name=societe]:checked').val()||'';
		var nom_societe = $('#nom_societe').val();
		var adresse_societe = $('#adresse_societe').val();
		var comp_adresse_societe = $('#comp_adresse_societe').val();
		var code_postal_societe = $('#code_postal_societe').val();
		var ville_societe = $('#ville_societe').val();
		var tel_societe = $('#tel_societe').val();
		var email_societe = $('#email_societe').val();
		var nom_contact_societe = $('#nom_contact_societe').val();
		var comment_societe = ($('#comment_societe').val().length)?$('#comment_societe').val():'';

		var required = _tools.required('resa_admin_form');
		var format_email = _tools.format_email('resa_admin_form');
		var voucher = $('#voucher').val();
		var error = 0;
		if(voucher != ''){
			jQuery.ajax({
				type: 'POST',
				url: '/voucher/test',
				data: {
					'voucher': voucher
				},
				success: function(data, textStatus, jqXHR) {
					if(data == 0){
						error = 1;
						$('#error_voucher').show();
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert("error");
				}
			});
		}

		var joueurs = $('#joueurs option:selected').val();
		if(required == 0 && format_email == 0 && error == 0 && envoimail != '' && joueurs != 0){
			var nomsalle = $('#salle-admin option:selected').html();
			var id = $('#id_reservation').val();
			var civil = $('#civil option:selected').val();
			var nom = $('#nom').val();
			var prenom = $('#prenom').val();
			var email = $('#email').val();
			var tel = $('#tel').val();
			var pass = $('#password').val();
			var login = $('#login').val();
			var old_pass = $('#old_pass').val();
			var jour = $('#jour_resa').val();
			var jour_fr = new Date(jour);
			var horaire = $('#horaire_resa').val();
			var salle = ($('#salle_reservation').val() != '')?$('#salle_reservation').val():$('#salle-admin option:selected').val();
			var joueurs = ($('#joueurs_reservation').val() != '')?$('#joueurs_reservation'):$('#joueurs option:selected').val();
			var reglement = $('input[name=reglement]:checked').val();
			var j1 = $('#joueur1').val();
			var j2 = $('#joueur2').val();
			var j3 = $('#joueur3').val();
			var j4 = $('#joueur4').val();
			var j5 = $('#joueur5').val();
			var titre = (id == '')?'Confirmation de la date selectionnée':'Modification réservation';
			var link = (id == '')?'add':'update';

			if (id == '') {
				var txt ='Vous avez choisi de créer une nouvelle réservation pour '+nomsalle+' pour le '+jour_fr.toLocaleDateString('fr-FR')+' à '+horaire+'. Validez ce choix pour la création';
				var datas = {'titre':titre,'jour':jour,'horaire':horaire,'txt':txt,"comment":comment,"envoimail":envoimail,"societe":societe,"tarifstand":tarifstand,"tarif":tarif};
				_inPop.open('/popin/valid',datas,'','fn_reservation.add()');
			}
			else {
				var datas = {"titre":titre,"id":id,"civil":civil,"nom":nom,"prenom":prenom,"email":email,"tel":tel,"login":login,"password":pass,"old_pass":old_pass,"jour":jour,"horaire":horaire,"salle":salle,"joueurs":joueurs,"joueur1":j1,"joueur2":j2,"joueur3":j3,"joueur4":j4,"joueur5":j5,"voucher":voucher,"reglement":reglement,"comment":comment,"envoimail":envoimail,"id_societe":id_societe,"societe":societe,"nom_societe":nom_societe,"adresse_societe":adresse_societe,"comp_adresse_societe":comp_adresse_societe,"code_postal_societe":code_postal_societe,"ville_societe":ville_societe,"tel_societe":tel_societe,"email_societe":email_societe,"nom_contact_societe":nom_contact_societe,"comment_societe":comment_societe,"tarifstand":tarifstand,"tarif":tarif};
				_Ajax.send('/reservation/admin/Reservationadmin/' + link, datas);
			}
		}
		else if (joueurs == 0 || envoimail == '') {
			if (joueurs == 0) {
				$('.error_form').show();
				$('#error_nbjoueurs').show();
			}
			if (envoimail == '') {
				$('#envoimailoui').addClass('bg_error');
				$('#envoimailnon').addClass('bg_error');
				$('.error_form').show();
				$('#error_envoimail').show();
			}
		}
	});
	// règlement sur place
	$('body').on('click', '._reservation_paid', function(){
		var id = $(this).attr('data-id');
		var datas = {"id":id};
		_Ajax.send('/reservation/admin/Reservationadmin/paid', datas);
		$('#_tr' + id).removeClass('resa_alerte');
	});
	/**
	* formulaire réservation front
	*/
	$('body').on('click', '._front_resa', function(){
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		var jour = $(this).attr('data-day');
		var horaire = $(this).attr('data-hour');
		$('#jour_maintien_modif').val(jour);
		$('#heure_maintien_modif').val(horaire);
		var joueurs = $('#joueurs option:selected').val();
		var salle = $('#salle option:selected').val();
		var titre = 'Réservez votre aventure';
		var resaid = $('#id_resa_maintien_modif').val();
		var datas = {"titre":titre,"jour":jour,"horaire":horaire,"nbJoueurs":joueurs,"salle":salle};

		if (joueurs == 0) {
			var datas = {"titre":"Aucun nombre de joueurs sélectionné","txt":"Veuillez sélectionner un nombre de joueurs avant de choisir votre créneau horaire."};
			_inPop.open('/reservation/Reservation/wrong_player_number', datas, 'alerte');
			//$('#_tr'+id).slideUp(500);
		}
		else {
			if ($('#id_resa_maintien_modif').val() != '') {
				_inPop.open('/reservation/Reservation/modif', {"titre":"Modification données de réservation","jour":jour,"horaire":horaire,"nbJoueurs":joueurs,"salle":salle,"id":resaid,"typemodif":"modif_cal"});
			}
			else {
			_inPop.open('/reservation/Reservation/form', datas);
			}

		}

	});
	/**
	* annulation modifications réservation
	*/

	$('body').on('click', '._cancel_modif', function(){
		var id = $(this).attr('data-id');
		var datas = {"titre":"Annulation modifications","txt":"Voulez-vous vraiment annuler les modifications faites sur votre réservation ?"};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_reservation.reload("'+id+'")','fn_reservation.modifreload()');

	});
	/**
	* validation formulaire client
	*/
/* 	$('body').on('click', '#_submit_resa_front_form', function(){
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		$('.error').each(function(){
			if($(this).is(':visible'))$(this).hide();
		});
		$('.bg_error').each(function(){
			$(this).removeClass('bg_error');
		});
		var required = _tools.required('resa_front_form');
		var format_email = _tools.format_email('resa_front_form');
		if(required == 0 && format_email == 0){
			var civil = $('#civil option:selected').val();
			var nom = $('#nom').val();
			var prenom = $('#prenom').val();
			var email = $('#email').val();
			var tel = $('#tel').val();
			var pass = $('#password').val();
			var login = $('#login').val();
			var old_pass = $('#old_pass').val();
			var jour = $('#jour_resa').val();
			var horaire = $('#horaire_resa').val();
			var salle = $('#salle option:selected').val();
			var joueurs = $('#joueurs option:selected').val();
			var id_resa = $('#reservation_id').val();
			var client_id = $('#client_id').val();
			var voucher = $('#voucher').val();
			var j1 = $('#joueur1').val();
			var j2 = $('#joueur2').val();
			var j3 = $('#joueur3').val();
			var j4 = $('#joueur4').val();
			var j5 = $('#joueur5').val();
			var datas = {"id_resa":id_resa,"client_id":client_id,"civil":civil,"nom":nom,"prenom":prenom,"email":email,"tel":tel,"login":login,"password":pass,"old_pass":old_pass,"jour":jour,"horaire":horaire,"salle":salle,"voucher":voucher,"joueurs":joueurs,"joueur1":j1,"joueur2":j2,"joueur3":j3,"joueur4":j4,"joueur5":j5};
			_Ajax.send('/reservation/add', datas);
		}
	}); */
	$('body').on('click', '#_submit_resa_front_form', function(){
		///

		$('.error').each(function(){
			if($(this).is(':visible'))$(this).hide();
		});
		$('.bg_error').each(function(){
			$(this).removeClass('bg_error');
		});

		var required = _tools.required('resa_front_form');
		var format_email = _tools.format_email('resa_front_form');
		if(required == 0 && format_email == 0){
			var civil = $('#civil option:selected').val();
			var nom = $('#nom').val();
			var prenom = $('#prenom').val();
			var email = $('#email').val();
			var tel = $('#tel').val();
			var pass = $('#password').val();
			var login = $('#login').val();
			var old_pass = $('#old_pass').val();
			var jour = $('#jour_resa').val();
			var horaire = $('#horaire_resa').val();
			var salle = $('#salle option:selected').val();
			var joueurs = $('#joueurs option:selected').val();
			var id_resa = $('#reservation_id').val();
			var client_id = $('#client_id').val();
			var voucher = $('#voucher').val();
			var j1 = $('#joueur1').val();
			var j2 = $('#joueur2').val();
			var j3 = $('#joueur3').val();
			var j4 = $('#joueur4').val();
			var j5 = $('#joueur5').val();
			var datas = {"id_resa":id_resa,"client_id":client_id,"civil":civil,"nom":nom,"prenom":prenom,"email":email,"tel":tel,"login":login,"password":pass,"old_pass":old_pass,"jour":jour,"horaire":horaire,"salle":salle,"voucher":voucher,"joueurs":joueurs,"joueur1":j1,"joueur2":j2,"joueur3":j3,"joueur4":j4,"joueur5":j5};

			var infosok = 'ok';

		}

		else {
			$('html, body').animate({ scrollTop: 0 }, 'fast');
		}

		///
		var salle = $('#id_room').val();
		var voucher = $('#voucher').val();
		$('.errorv').each(function(){
			if($(this).is(':visible'))$(this).hide();
		});
		if (voucher.length > 0) {

			jQuery.ajax({
				type: 'POST',
				url: '/voucher/test',
				data: {
					'voucher': $('#voucher').val(),
					'salle': salle
				},
				success: function(data, textStatus, jqXHR) {
					switch (data) {
						case '0':

						$('#voucher').addClass('bg_error');
						$('#error_voucher').show();
						$('#voucher').val('');
						break;
						case '1':

						$('#voucher').addClass('bg_error');
						$('#used_voucher').show();
						$('#voucher').val('');
						break;
						case '2':

						$('#voucher').addClass('bg_error');
						$('#passed_voucher').show();
						$('#voucher').val('');
						break;
						case '3':
						$('#voucher').addClass('bg_error');
						$('#notthisroom_voucher').show();
						$('#voucher').val('');
						break;
						case '4':
							if (infosok == 'ok') {
								$('#_submit_resa_front_form').hide();
								$('#_btn_att_resa_front_form').show();
								$('html, body').animate({ scrollTop: 0 }, 'fast');
								_Ajax.send('/reservation/add', datas);
							}
						break;
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert("error");
				}
			});
		}
		else {


			if (infosok == 'ok') {
				$('#_submit_resa_front_form').hide();
				$('#_btn_att_resa_front_form').show();
				$('html, body').animate({ scrollTop: 0 }, 'fast');
				_Ajax.send('/reservation/add', datas);
			}
		}
	});
	/**
	* Annulation reservation
	*/
	$('body').on('click', '._reset_resa', function(){
		var id = $(this).attr('data-id');
		var datas = {"titre":"Suppression reservation","txt":"Voulez vous vraiment abandonner la réservation en cours ?","id":id};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_reservation.delFront('+id+')', 'fn_reservation.reload('+id+')');
	});
	/**
	* validation reservation total nul
	*/

	$('body').on('click', '._add_resa_total_nul', function(){



		if($('#order_cgv').prop('checked') === false){
			$('#error_cgv').show();
		}
		else {
			var element = document.getElementById('id_voucher_ok_form');
			element.submit();
		}
	});
	/**
	* validation reservation
	*/
	$('body').on('click', '._order_process', function(){
		$('#error_cgv').hide();
		if($('#order_cgv').prop('checked') === false){
			$('#error_cgv').show();
		}
		else{
			_Ajax.order('/reservation/order', {"id":$(this).attr('data-id')}, 'fn_reservation');
		}
	});
	$('body').on('click', '._order_admin_process', function(){
		_Ajax.order('/reservation/order', {"id":$(this).attr('data-id')}, 'fn_reservation');
	});
	/**
	* modification reservation
	*/
	$('body').on('click', '._modif_resa', function(){

		if ($(this).attr('id') == 'modif_resa_calendar') {

			$('#id_resa_maintien_modif').val($(this).attr('data-id'));
			var idresamaintien = $(this).attr('data-id');
			var time = $('#maintiendate').val();
			var idsalle = $('#salle option:selected').val();

			var datas = {"salle":idsalle,"start":time,"idresamaintien":idresamaintien};
			_inPop.close();
			_Ajax.reload('/reservation/Reservation/index','_calendrier',datas);

		}
		else {
		_inPop.open('/reservation/Reservation/modif', {"id":$(this).attr('data-id'),"typemodif":$(this).attr('id')});
		}
	});
	/**
	* Gestion resultat / page
	**/
	$('body').on('change','._pag_setup', function(){
		var datas = {'pag':$(this).val()};
		_Ajax.reload('/reservation/admin/Reservationadmin/listing','bloc_resa_liste',datas);
		// $('#bloc_resa_cal').hide();
	});

	/**
	* Gestion basscule réservations / indispos
	**/
	$('body').on('change','._res_indispo', function(){
		var datas = {'resindis':$(this).val()};
		_Ajax.reload('/reservation/admin/Reservationadmin/listing','bloc_resa_liste',datas);
		// $('#bloc_resa_cal').hide();
	});
	/**
	* Gestion indisponibilités
	*/
	$('body').on('click','._add_indispo',function(){

		var tab = '#bloc_resa_cal';
		$('._tab_bloc').hide();
		$('._tab_drop').removeClass('button_active');
		$(tab).show();
		$('#resa_cal').addClass('button_active');
		$('#select_options').show();
		$('#salle_reservation').val('');
		$('#joueurs_reservation').val('');

		$('#sel').addClass('hidden');
		console.log('click');
		addIndispo = 1;
		addResa = 0;
		$('#info_resa').html('Selectionnez le jour/ou le créneau horaire :<div id="indisSel" style="color:red;"></div><div id="checkall"></div><div id="annulindispo" class="col-sm-1"><a class="button btn_L btn_annul mt32 _annul_resaindis">Annuler</a></div>');
		//if ($('#annulindispo').length < 1) {
		//	$('<div id="annulindispo"><a class="button btn_L btn_annul mt32" href="/admin/reservations">Annuler</a>  </div>').appendTo('#cancel_area');
		//}
		$('.calday').css({
			'cursor':'pointer',
			'text-decoration': 'underline'
		});
		_Ajax.reload('/reservation/admin/Reservationadmin/calendar','calendar',{'start':$('.toto').attr('data-day'),'salle':$('#salle-admin option:selected').val(),'addIndispo':addIndispo,'addResa':addResa});
		//$('._add_indispo,._add_resa').addClass('hidden');
	});

	/**
	* Gestion annulation création résa/indispo admin
	*/
	$('body').on('click','._annul_resaindis',function(){
		addIndispo = 0;
		addResa = 0;
		$('#joueurs').val("0");
		$('#sel').addClass('hidden');
		$('.calday').css({
			'cursor':'default',
			'text-decoration': 'none'
		});
		if ($('#annulindispo').length) {
			$('#annulindispo').remove();
		}
		$('#info_resa').html('');
		_Ajax.reload('/reservation/admin/Reservationadmin/calendar','calendar',{'start':$('.toto').attr('data-day'),'salle':$('#salle-admin option:selected').val(),'addIndispo':0,'addResa':0});
	});

	/**
	* Gestion sélection d'un jour complet pour une indispo
	*/
	$('body').on('click','.calday',function(e){
		$('#checkall').html('<div id="checkcheckall"><input type="checkbox" name="allRoom" id="allRoom">Toutes les salles</div>');
		if(typeof addIndispo == 'undefined' || addIndispo == 0){
			e.preventDefault();
			return;
		}
		var jour = $(this).attr('data-day');
		var jour_fr = new Date(jour);
		$('#indisSel').html('le '+ jour_fr.toLocaleDateString('fr-FR') + ' sur tous les créneaux horaires');
		if(!$('._valid_indispo').length){
			$('<div class="col-md-3 col-md-offset-3 text-center"><button class="_valid_indispo button ">Valider</button></div>').appendTo('#info_resa');
		}
		indispo = jour;
	});
	/**
	* Gestion bouton validation création indispo
	*/
	$('body').on('click','._valid_indispo',function(){
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		var txt = '<strong>'+$('#indisSel').html()+'</strong>';
/* 		if (indispo.length == 10){
			var dateIn = new Date(indispo);
			txt = '<strong>'+dateIn.toLocaleDateString('fr-FR')+'</strong>';

		} else if (indispo.length == 16){
			var dateIn = new Date(indispo);
			var heure = dateIn.toLocaleString('fr-FR');
			var re = /:/gi;
			var newheure = heure.replace(re, "h");

			txt = '<strong>'+dateIn.toLocaleString('fr-FR')+'</strong>';
		} */
		if($('#allRoom').is(':checked')){
			txt += ' sur <strong>toutes les salles</strong> ';
			salle = 'all';
		} else {
			txt += ' sur la salle <strong>'+$('#salle-admin option:selected').html()+'</strong>';
			salle = $('#salle-admin option:selected').val();
		}
		var datas = {'indispo':indispo,"titre":"Indisponibilité","txt":"Voulez vous rendre indisponible "+txt+" ?"};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_reservation.setIndispo("'+indispo+'","'+salle+'")');
	});

	/**
	* recherche résa
	*/
	$('body').on('keypress', '#searchresa', function() {
		var delayInMilliseconds = 500;
		setTimeout(function() {
			var search = $('#searchresa').val();
			var searchstart = $('#datesearchstart').val();
			var searchend = $('#datesearchend').val();
			var datas = {"search":search,"searchstart":searchstart,"searchend":searchend};

			_Ajax.reload('/reservation/admin/Reservationadmin/listingsearch','tab_resa_search',datas);
		}, delayInMilliseconds);

	});

	/**
	* recherche résa date
	*/
	$('body').on('change', '#datesearchstart, #datesearchend', function() {
			var search = $('#searchresa').val();
			var searchstart = $('#datesearchstart').val();
			var searchend = $('#datesearchend').val();
			var datas = {"search":search,"searchstart":searchstart,"searchend":searchend};

			_Ajax.reload('/reservation/admin/Reservationadmin/listingsearch','tab_resa_search',datas);
	});


	/**

	*Gestion des checkbox pour impression fiche d'aventure

	*/
	$('body').on('change','._check_fiche',function() {

		var lienfiche;

		if ($(this).is(':checked')) {
			if (!$('#sheet_create').attr('href')) {
				$('#sheet_create').attr('href','https://'+window.location.host+'/reservation/admin/Reservationadmin/printfiche/');
				$('#sheet_create').attr('target','_blank');
			}
			lienfiche = $('#sheet_create').attr('href');
			lienfiche += $(this).val()+'a';
			$('#sheet_create').attr('href',lienfiche);
		}

		else {
			if($('input:checked').length == 0) {
				$('#sheet_create').removeAttr('href');
				$('#sheet_create').removeAttr('target');
			}
			else {
				lienfiche = $('#sheet_create').attr('href');
				var searchstring = $(this).val()+'a';
				lienfiche = lienfiche.replace(searchstring, '');
				$('#sheet_create').attr('href',lienfiche);
			}
		}
	});

	/**

	*Gestion clic impression de feuille d'aventure quand pas de checkbox

	*/
	$('body').on('click','#sheet_create',function() {
		if ($('input:checked').length == 0) {
			alert("Aucune réservation n'est sélectionnée");
		}
	});


	if((document.URL).search('admin') != -1){
	$.getScript("reservationadmin.js", function(){
	   alert("Script loaded but not necessarily executed.");
	});}
});
var fn_reservation = {
	add : function(){
		var civil = $('#civil option:selected').val();
		var nom = $('#nom').val();
		var prenom = $('#prenom').val();
		var email = $('#email').val();
		var tel = $('#tel').val();
		var jour = $('#jour_resa').val();
		var horaire = $('#horaire_resa').val();
		var salle = $('#salle-admin option:selected').val();
		var joueurs = $('#joueurs option:selected').val();
		var j1 = $('#joueur1').val();
		var j2 = $('#joueur2').val();
		var j3 = $('#joueur3').val();
		var j4 = $('#joueur4').val();
		var j5 = $('#joueur5').val();
		var voucher = $('#voucher').val();
		var reglement = $('input[name=reglement]:checked').val();
		var tarifstand = ($('input[name=tarifstand]:checked').val()=='1')?'1':'0';
		var tarif = (tarifstand != '1')?$('#tarif').val():'';
		var comment = (($('#comment').val().length)&&($('#comment').val()!='Écrivez un commentaire'))?$('#comment').val():'';
		var id_societe = $('#id_societe').val();
		var societe = $('input[name=societe]:checked').val()||'';
		var nom_societe = $('#nom_societe').val();
		var adresse_societe = $('#adresse_societe').val();
		var comp_adresse_societe = $('#comp_adresse_societe').val();
		var code_postal_societe = $('#code_postal_societe').val();
		var ville_societe = $('#ville_societe').val();
		var tel_societe = $('#tel_societe').val();
		var email_societe = $('#email_societe').val();
		var nom_contact_societe = $('#nom_contact_societe').val();
		var comment_societe = (($('#comment_societe').val().length))?$('#comment_societe').val():'';
		var envoimail = $('input[name=envoimail]:checked').val();
		console.log(salle);
		console.log('add');
		var datas = {"titre":"Ajout d'une réservation","civil":civil,"nom":nom,"prenom":prenom,"email":email,"jour":jour,"horaire":horaire,"salle":salle,"tel":tel,"joueurs":joueurs,"joueur1":j1,"joueur2":j2,"joueur3":j3,"joueur4":j4,"joueur5":j5,"voucher":voucher,"reglement":reglement,"comment":comment,"envoimail":envoimail,"id_societe":id_societe,"societe":societe,"nom_societe":nom_societe,"adresse_societe":adresse_societe,"comp_adresse_societe":comp_adresse_societe,"code_postal_societe":code_postal_societe,"ville_societe":ville_societe,"tel_societe":tel_societe,"email_societe":email_societe,"nom_contact_societe":nom_contact_societe,"comment_societe":comment_societe,"tarifstand":tarifstand,"tarif":tarif};
		_inPop.open('/reservation/admin/Reservationadmin/add',datas);
	},
	setIndispo : function(indispo){
		var datas = {'titre':'Indisponibilité','txt':'L\'indisponibilité a été créée avec succès','indispo':indispo,'salle':salle};
		_inPop.open('/reservation/admin/Reservationadmin/setIndispo',datas,'alerte');
	},
	del : function(id){
		var datas = {"titre":"Suppression reservation","txt":"La reservation à bien été supprimée","id":id};
		_inPop.open('/reservation/admin/Reservationadmin/delete', datas, 'alerte');
		$('#_tr'+id).slideUp(500);
	},
	delindispo : function(id){
		var datas = {"titre":"Suppression indisponibilité","txt":"L'indisponibilité à bien été supprimée","id":id};
		_inPop.open('/reservation/admin/Reservationadmin/deleteIndispo', datas, 'alerte');
		$('#_tr'+id).slideUp(500);
	},
	delFront : function(id){
		var datas = {"titre":"Suppression reservation","txt":"Votre réservation à bien été supprimée","id":id};
		_inPop.open('/reservation/admin/Reservationadmin/delete', datas, 'alerte');
	},

	cancel : function(id){
		var datas = {"titre":"Annulation reservation","txt":"Votre réservation à bien été annulée","id":id};
		_inPop.open('/reservation/admin/Reservationadmin/delete', datas, 'alerte');
	},
	cancelflo : function(id){
		var datas = {"titre":"Annulation reservation","txt":"Votre réservation à bien été annulée","id":id};
		_inPop.open('/reservation/admin/Reservationadmin/delete', datas, 'alerte');

		_Ajax.reload('/reservation/Reservation/index','_calendrier',{"salle":''});
		_Ajax.change_uri('/reservation/Reservation/changeUri', {"salle":''});
	},
	reload : function(id){
		var datas = {"id":id};
		_inPop.open('/reservation/reload', datas);
	},

	modifreload : function(){
		var jour = $('#jour_maintien_modif').val();
		var horaire = $('#heure_maintien_modif').val();
		var joueurs = $('#joueurs option:selected').val();
		var salle = $('#salle option:selected').val();
		var titre = 'Réservez votre aventure';
		var resaid = $('#id_resa_maintien_modif').val();
		_inPop.open('/reservation/Reservation/modif', {"titre":"Modification données de réservation","jour":jour,"horaire":horaire,"nbJoueurs":joueurs,"salle":salle,"id":resaid,"typemodif":"modif_cal"});
	},
	callback : function(data){
		data = JSON.parse(data);
		$('select#salle-admin').val(data.salle);
		$('select#joueurs').val(data.nbJoueurs);
		// $('#select_options').hide();
	},
	order : function(data){
		data = JSON.parse(data);
		$('#formOrder').html(data.form);
		$('#PaymentRequest').submit();
	},
};
function testRadio() {
	var bouton = document.getElementsByName('horaire');
	var Nbr = bouton.length;
	var ok = 0;     // Recup du nombre de radio bouton
	for (var i=0; i < Nbr; i++) {      // Parcours les elements
		if (bouton[i].checked === true)
		ok += 1;
	}
	if(ok === 0)
	return false;
	else
	return true;
}
function valideForm1(form){

	$('.error').each(function(){
		if($(this).is(':visible'))$(this).hide();
	});

	$('input[type=text]').each(function() {
		$(this).removeClass('bg_error');
	});

	$('input[type=date]').each(function() {
		$(this).removeClass('bg_error');
	});

	$('select').each(function() {
		$(this).removeClass('bg_error');
	});

	var erroranchor = '';


	var voucher = $('#voucher').val();

/* 	if(form.joueur1.value && !bonmail(form.joueur1.value)){
		$('#joueur1').addClass('bg_error');
		$('#error_mail_valid_joueur1').show();
		erroranchor = '#emailsJoueurs';
	}
	if(form.joueur2.value && !bonmail(form.joueur2.value)){
		$('#joueur2').addClass('bg_error');
		$('#error_mail_valid_joueur2').show();
		erroranchor = '#emailsJoueurs';
	}
	if(form.joueur3.value && !bonmail(form.joueur3.value)){
		$('#joueur3').addClass('bg_error');
		$('#error_mail_valid_joueur3').show();
		erroranchor = '#emailsJoueurs';
	}
	if(form.joueur4.value && !bonmail(form.joueur4.value)){
		$('#joueur4').addClass('bg_error');
		$('#error_mail_valid_joueur4').show();
		erroranchor = '#emailsJoueurs';
	}
	if(form.joueur5.value && !bonmail(form.joueur5.value)){
		$('#joueur5').addClass('bg_error');
		$('#error_mail_valid_joueur5').show();
		erroranchor = '#emailsJoueurs';
	} */

	if(!form.nom.value) {
		$('#nom').addClass('bg_error');
		$('#error_nom').show();
		erroranchor = '#coordonnees';
	}
	if(!form.prenom.value){
		$('#prenom').addClass('bg_error');
		$('#error_prenom').show();
		erroranchor = '#coordonnees';
	}
	if(!form.email.value){
		$('#email').addClass('bg_error');
		$('#error_mail').show();
		erroranchor = '#coordonnees';
	}
	if(!bonmail(form.email.value)){
		$('#email').addClass('bg_error');
		$('#error_mail_valid').show();
		erroranchor = '#coordonnees';
	}
	if(!form.tel.value){
		$('#tel').addClass('bg_error');
		$('#error_tel').show();
		erroranchor = '#coordonnees';
	}
	if(form.tel.value && !valider_numero(form.tel.value)){
		$('#tel').addClass('bg_error');
		$('#error_tel_valid').show();
		erroranchor = '#coordonnees';
	}

	if(!form.horaire.value) {
		$('#error_horaire').show();
		erroranchor = '#selectHoraire';
	}

	if(!form.jour.value) {
		$('#dateCalendarMobile').addClass('bg_error');
		$('#error_date').show();
		erroranchor = '#selectDate';
	}

	if(!form.joueurs.value) {
		$('#joueursMobile').addClass('bg_error');
		$('#error_nbjoueurs').show();
		erroranchor = '#selectNbjoueurs';
	}

	if(!form.salle.value) {
		$('#salle_mobile').addClass('bg_error');
		$('#error_scenario').show();
		erroranchor = '#selectSalle';
	}

	var salle = form.salle.value;

	if(erroranchor !== '') $('html, body').animate({scrollTop: $(erroranchor).offset().top}, 800);
	else {
		if (voucher.length > 0) {
			jQuery.ajax({
				type: 'POST',
				url: '/voucher/test',
				data: {
					'voucher': voucher,
					'salle': salle
				},
				success: function(data, textStatus, jqXHR) {
					erroranchor = '#voucherSelect';
					switch (data) {
						case '0':
						$('#voucher').addClass('bg_error');
						$('#error_voucher').show();
						$('html, body').animate({scrollTop: $(erroranchor).offset().top}, 800);
						break;
						case '1':
						$('#voucher').addClass('bg_error');
						$('#used_voucher').show();
						$('html, body').animate({scrollTop: $(erroranchor).offset().top}, 800);
						break;
						case '2':
						$('#voucher').addClass('bg_error');
						$('#passed_voucher').show();
						$('html, body').animate({scrollTop: $(erroranchor).offset().top}, 800);
						break;
						case '3':
						$('#voucher').addClass('bg_error');
						$('#notthisroom_voucher').show();
						$('html, body').animate({scrollTop: $(erroranchor).offset().top}, 800);
						break;
						case '4':
							form.submit();
						break;
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert("error");
				}
			});
		}
		else form.submit();
	}
}
function verifMobileCgv(form){
	if(document.getElementById('order_cgv').checked === true){
		form.submit();
	}
	else{
		alert('Vous devez accepter les conditions générales de vente');
	}
}
function bonmail(mailteste){
	var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
	if(reg.test(mailteste)){
		return(true);
	}
	else{
		return(false);
	}
}
function valider_numero(nombre) {
	var chiffres = nombre.toString();
	chiffres = chiffres.replace(/[^0-9]/g, '');
	compteur = chiffres.length;
	if (compteur!=10)
	return false;
	else
	return true;
}
function isEmpty( el ){
	return !$.trim(el.html());
}
function cancelDuplicates(fn, threshhold, scope) {
    if (typeof threshhold !== 'number') threshhold = 10;
    var last = 0;

    return function () {
        var now = +new Date;

        if (now >= last + threshhold) {
            last = now;
            fn.apply(scope || this, arguments);
        }
    };
}
