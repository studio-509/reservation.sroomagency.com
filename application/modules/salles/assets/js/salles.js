$(document).on('ready',function() {
	/**
	* Gestion onglets
	*/
	$(document).on('click','._tab_drop',function(){
		var tab = '#bloc_' + $(this).attr('id');
		$('._tab_bloc').addClass('hidden');
		$('._tab_drop').removeClass('button_active');
		$(this).addClass('button_active');
		$(tab).removeClass('hidden');
		$(tab).show();
	});
		
	/**
	* Update nbmax salles réservables en parallèlre
	*/
	$(document).on('click','._paral_save',function(){
		var nbmax = $('#nb_salle_resa_max option:selected').val();
		var nbmaxweek = $('#nb_salle_resa_max_week option:selected').val();
		var nbmaxperiod = $('#nb_salle_resa_max_period option:selected').val();
		var weekdays='';
		$("input[type='checkbox']:checked").each(
          function() {
           var weekdaytemp = $(this).attr('id').substr(7,1);
		   weekdays += weekdaytemp+',';
          });          
		weekdays = weekdays.substr(0,weekdays.length-1);
		var datestart = $('#date_start').val();
		var dateend = $('#date_end').val();
		var datas = {"nb_resa_max":nbmax,"nb_resa_max_week":nbmaxweek,"nb_resa_max_period":nbmaxperiod,"weekdays":weekdays,"datestart":datestart,"dateend":dateend};
		_Ajax.send('/salles/admin/Sallesadmin/update_nb_resa_max', datas);
		$('#nb_salles_resa').trigger('click');

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
	* jump salles admin
	*/
	$('#salle-admin').change(function(){
		$('#checkall').html('');
		$('._valid_indispo').hide();
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
	* Clic date indispo
	*/
	$(document).on('click', '._admin_resa', function(e){
		$('#checkcheckall').remove();
        if((document.URL).search('admin') == -1){
            return;
        }
        if($('#info_resa').html() == '' ){
			e.preventDefault();
			e.stopPropagation();
			return;
		}
		if (addIndispo == 1) {
			$('html, body').animate({ scrollTop: 0 }, 'fast');
			var jour = $(this).attr('data-day');
			var jour_fr = new Date(jour);
			var horaire = $(this).attr('data-hour');
			$('#indisSel').html('le '+ jour_fr.toLocaleDateString('fr-FR') + ' à ' +horaire);
			if(!$('._valid_indispo').length){
				$('<div id="validbuttonarea" class="mt32 text-center"><button class="_valid_indispo button ">Valider</button></div>').appendTo('#info_resa');
			}
			$('._valid_indispo').show();
			var regHoraireA = new RegExp('[h]', 'g');
			horaire = horaire.replace(regHoraireA, ':');
			if (horaire.length == 4) {
				horaire = '0'+horaire;
			}
			indispo = jour +' '+horaire;
		}
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
		$('._valid_indispo').show();
		indispo = jour;
	});
	
	/**
	* Gestion bouton validation création indispo
	*/
	$('body').on('click','._valid_indispo',function(){
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		var txt = '<strong>'+$('#indisSel').html()+'</strong>';
		if($('#allRoom').is(':checked')){
			txt += ' sur <strong>toutes les salles</strong> ';
			salle = 'all';
		} else {
			txt += ' sur la salle <strong>'+$('#salle-admin option:selected').html()+'</strong>';
			salle = $('#salle-admin option:selected').val();
		}
		var datas = {'indispo':indispo,"titre":"Indisponibilité","txt":"Voulez vous rendre indisponible "+txt+" ?"};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_salle.setIndispo("'+indispo+'","'+salle+'")');
	});
	
	/**
	* suppression indispo
	*/
	$('body').on('click', '._reservation_delete', function() {
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		var id = $(this).attr('data-id');

		var datas = {"titre":"Suppression indisponibilité","txt":"Voulez vous vraiment supprimer cette indisponibilité ?"};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_salle.delindispo('+id+')');
		
	});
	
	/**
	* suppression salle
	*/

	$(document).on('click', '._salle_delete', function() {
		$('._popin_box').removeClass('error');
		var id = $(this).attr('data-id');
		var datas = {"titre":"Suppression salle","txt":"Voulez vous vraiment supprimer cette salle ?"};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_salle.del('+id+')');
	});

	/**
	* affichage formulaire modification salle
	*/
	$(document).on('click', '._salle_update', function() {
		$('._popin_box').removeClass('error');
		var id = $(this).attr('data-id');
		var datas = {"titre":"Modification salle","id":id};
		_inPop.open('/salles/admin/Sallesadmin/infos', datas, 'alerte', 'fn_salle.update()');
	});

	/**
	* affichage horaires
	*/
	$(document).on('click','._salle_horaires',function(){
		var id= $(this).attr('data-id');
		var datas = {"titre":"Horaires "+$(this).parents('tr').find('.first').html(),"id":id};
		_inPop.open('/salles/admin/Sallesadmin/infos_horaires',datas,'','fn_salle.update_horaire');
	});
	/**
	* affichage formulaire ajout salle
	*/
	$(document).on('click', '._salle_add', function() {
		$('._popin_box').removeClass('error');
		var datas = {"titre":"Ajout salle"};
		_inPop.open('/salles/admin/Sallesadmin/infos', datas, 'alerte', 'fn_salle.update()');
	});

	/**
	* update salle
	*/
	$(document).on('click', '#_submit_salle_admin_form', function(){
		$('div[id^=error_]').hide();
		var id = $('#salle_id').val();
		var active = $('input[name=active]:checked').val();
		var scenario = $('#scenario').val();
		var nbmin =$('#nbmin').val();
		var nbmax =$('#nbmax').val();
		var caract=$('#caract').val();
		var duration = $('#duration').val();
		var required = _tools.required('salle_form');
		if(nbmin == '0' && nbmin !== ''){
			$('#error_z').show();
			return;
		}
		if(nbmin > nbmax && nbmax !== ''){
			$('#error_joueurs').show();
			return;
		}
		if(required == 0){
			var datas = {"titre":"Modification salle","id":id,"nom":$('#nom').val(),"active":active,"scenario":scenario,"nbmin":nbmin,"nbmax":nbmax,"caract":caract,"duration":duration};
			_Ajax.send('/salles/admin/Sallesadmin/update', datas);
		}
	});

	/**
	* tarif update
	*/
	$(document).on('click','ul li a._horaire_update',function(e){
		if($('input[type=text]:enabled:visible').length != 0){
			return;
		}
		var html = $('#hor_'+$(this).attr("data-id")).html();
		localStorage.setItem("oldValue",html);
		localStorage.setItem("oldId",$(this).attr("data-id"));
		$('._horaire_update,._horaire_delete,._horaire_add').addClass('hidden');
		var days = $(this).parents('tr').children().children('.td-day');
		// days.removeClass('hidden');
		$(this).parents('tr').find('input[type=checkbox]').prop('disabled', false);
		var input = $('<input size="4" type="text" name="horaire" class="_required" id="hor_input'+$(this).attr("data-id")+'" data-id="'+$(this).attr("data-id")+'">');
		input.val(html);
		// $('#hor_input'+$(this).attr("data-id")).val(html);
		//
		// $(this).parents('tr').children().children().children()
		$('#hor_'+$(this).attr("data-id")).html(input);
		$(this).parents('tr').find('._horaire_validate,._horaire_cancel').removeClass('hidden');
	});

	/**
	 * Annulation édition tarif
	 */
	$(document).on('click','._horaire_cancel',function(e){
		e.preventDefault();
		$('.invalid-hor').remove();
		$('#hor_'+localStorage.getItem("oldId")).html(localStorage.getItem("oldValue"));
		// $('.td-day').addClass('hidden');
		$('._horaire_update,._horaire_delete,._horaire_add').removeClass('hidden');
		$('._horaire_validate,._horaire_cancel').addClass('hidden');
		$('input[type=checkbox]:enabled').prop('disabled',true);
		localStorage.removeItem("oldValue");
		localStorage.removeItem("oldId");
	});
	/**
	 * Validation nouvel horaire
	 */
	$(document).on('click','._horaire_validate',function(e){
		e.preventDefault();
		var that = $(this);
		console.log(that);
		$('.invalid-hor').remove();
		var fd = new FormData();
		var horaire = $('input[name=horaire]:visible').val();
		var horId = $('input[name=horaire]:visible').attr('data-id');
		var regex = /^([01]?[0-9]|2[0-3])h[0-5][0-9]$/;
		if(!horaire.match(regex)){
			// $('<span class="error invalid-hor" style="position: absolute;left:10px;top:2px;">Format invalide :<br /> requis 13h30</span>') .prependTo('#hor_'+horId);
			$('<span class="error invalid-hor">Format invalide :<br /> requis 13h30</span>').prependTo(that.parent().parent().parent());
			return;
		}
		var days = [];
		$('input[type=checkbox]:enabled:checked').each(function() {
			var day = $(this).attr('id').replace(horId+'_','');
			days.push(day);
		});
		if(days.length == 7 ){
			days = 'all';
		} else {
			days = days.toString();
		}
		fd.append("horaire" , horaire);
		fd.append("hor_id" ,horId);
		fd.append("days",days);
		// console.log(fd);
		$.ajax({
			url : '/salles/admin/Sallesadmin/update_horaire',
			type : 'POST',
			data: fd,
			processData: false,
			contentType: false,
			success: function(data){
				// alert('success');
				if(JSON.parse(data).status == 'success'){
					// $('#hor_'+localStorage.getItem("oldId")).html(localStorage.getItem("oldValue"));
					$('#hor_'+ horId).html(JSON.parse(data).horaire);
					$('._horaire_update,._horaire_delete').removeClass('hidden');
					$('._horaire_validate,._horaire_cancel').addClass('hidden');
					$('#hor_input'+horId).remove();
					$('input[type=checkbox]:enabled').prop('disabled', true);
					localStorage.removeItem("oldValue");
					localStorage.removeItem("oldId");
				} else {
					// TODO
					// REPORTING ERROR
				}
			},
			error: function(){
				alert('error');
			}
		});
	});

	/**
	 * Ajout horaire : affichage formulaire
	 */
	$(document).on('click','._horaire_add',function(e){
		if($('input[type=text]:enabled:visible').length != 0 || $('._delete_horaire_validate:visible').length != 0){
			return;
		}
		e.preventDefault();
		// console.log($(this).parent().siblings());
		$('._horaire_update,._horaire_delete,._set_date_update').addClass('hidden');
		$(this).parent().siblings('li').removeClass('hidden');
		$(this).parent().addClass('hidden');
	});
	/**
	 * Annulation ajout horaire
	 */
	$(document).on('click', '._horaire_add_cancel', function(e) {
		e.preventDefault();
		$('.invalid-hor').remove();
		$(this).parents('ul').find('li').addClass('hidden');
		$(this).parents('ul').find('li:first').removeClass('hidden');
		$('._horaire_update,._horaire_delete,._set_date_update').removeClass('hidden');

		$(this).parents('ul').find('input').val('');
	});

	/**
	* Ajout horaire : Validation
	*/
	$(document).on('click', '._horaire_add_validate', function(e) {
		e.preventDefault();
		$('.invalid-hor').remove();
		var fd = new FormData();
		var horaire = $('input[name=horaire]:visible').val();
		var regex = /^([01]?[0-9]|2[0-3])h[0-5][0-9]$/;
		if(!horaire.match(regex)){
			$('<span class="error invalid-hor" style="text-align:center;display:inline;">Format invalide : requis 13h30</span>').appendTo($(this).parents('table').parent());
			return;
		}
		if (horaire.length == 4) {
			horaire = '0'+horaire;
		}
		var horSetId = $('input[name=horaire]:visible').attr('data-id');
		fd.append('hor_start',horaire);
		fd.append('set_id',horSetId);
		$.ajax({
			url : '/salles/admin/Sallesadmin/add_horaire',
			type : 'POST',
			data: fd,
			processData: false,
			contentType: false,
			success: function(data){
				// alert('success');
				if(JSON.parse(data).status == 'success'){
					var slide = false;
					// console.log('ok');
					if(!$('._popin_body table:visible').hasClass('.first')){
						slide = $('._popin_body table:visible').attr('id');
					}
					var id=  $('input[name=salle_id]').val();
					// var setId = ;
					var datas = {"reload":true,"id":id};


					$.ajax({
		  				type: 'POST',
		  				url: '/salles/admin/Sallesadmin/infos_horaires',
			  			data: {
				  			datas
			  			},
			  			success: function(data, textStatus, jqXHR) {
			         		$('._popin_body').html(data);
							if(slide != false){
								console.log('#table_'+slide.replace('set',''));
								console.log($('._popin_body .table_wrapper:visible'));
								$('._popin_body .table_wrapper:visible').hide();
								$('#table_'+slide.replace('set','')).show();
							}

			            },
			  			error: function(jqXHR, textStatus, errorThrown) {
				  			alert("error");
				  		}
					});
					// _Ajax.reload('/salles/admin/Sallesadmin/infos_horaires','_popin_body',datas);


					// $('#hor_'+localStorage.getItem("oldId")).html(localStorage.getItem("oldValue"));
					// $('#hor_'+ horId).html(JSON.parse(data).horaire);
					// $('._horaire_update,._horaire_delete').removeClass('hidden');
					// $('._horaire_validate,._horaire_cancel').addClass('hidden');
					// $('#hor_input'+horId).remove();
					// $('input[type=checkbox]:enabled').prop('disabled', true);
					// localStorage.removeItem("oldValue");
					// localStorage.removeItem("oldId");
				} else {
					// TODO
					// REPORTING ERROR
				}
			},
			error: function(){
				alert('error');
			}
		});
	});

	/**
	* Suppression horaire
	*/
	$(document).on('click','._horaire_delete',function(e){
		if($('input[type=text]:enabled:visible').length != 0){
			return;
		}
		e.preventDefault();
		var hor_id = $(this).attr('data-id');
		localStorage.setItem('oldHtml',$(this).parent().parent().html());
		$(this).parent().parent().html('<li>Confirmez la suppression</li><li><a class="_delete_horaire_validate" attr-id="'+hor_id+'">OUI</a></li><li><a class="_delete_horaire_cancel">NON</a></li>');
	});

	/**
	 * Horaire Suppression Confirmation
	 */
	$(document).on('click','._delete_horaire_validate',function(e){
		e.preventDefault();
		var fd = new FormData(),
		hor_id = $(this).attr('attr-id');
		fd.append("hor_id",hor_id);
		$.ajax({
			url : '/salles/admin/Sallesadmin/delete_horaire',
			type : 'POST',
			data: fd,
			processData: false,
			contentType: false,
			success: function(data){
				// alert('success');
				if(JSON.parse(data).status == 'success'){
					$('#hor_'+hor_id).parent().slideUp(400,function(){
						$(this).remove()
					});
				} else {
					// TODO
					// REPORTING ERROR
				}
			},
			error: function(){
				alert('error');
			}
		});
	});

	/**
	* Annulation Suppression horaire
	*/
	$(document).on('click','._delete_horaire_cancel',function(e){
		var html = localStorage.getItem("oldHtml");
		$(this).parent().parent().html(html);
		localStorage.removeItem("oldHtml");
	});

	/**
	* Reload après fermeture popin
	*/
	$(document).on('click','.closePopin',function(e){		
		if ($('#_popin_title').text() == 'Mise à jour du nombre max de salles réservables') {
			var datas = {'onglet':'nb_max_resa'};
			_Ajax.reload('/salles/admin/Sallesadmin/listing','admin_content',datas);
		}
		else {
		_Ajax.reload('/salles/admin/Sallesadmin/listing','admin_content');
		}
		
	});

	$(document).on('click', '._set_date_update', function(e) {
		e.preventDefault();
		$('.wrapper_date_btn,._select_date').removeClass('hidden');
		$(this).addClass('hidden');
	});

	$(document).on('click', '._set_date_validate', function(e) {
		e.preventDefault();
		var fd = new FormData();
		var date = $('._select_date').val();
		var regexDate = /^20\d\d-[0-1]\d-[0-3]\d$/;
		if( date === "" || !regexDate.test(date) ) {
			return;
		}
		fd.append('set_date_begin',date);
		fd.append('set_id',$(this).attr('attr-id'));
		$.ajax({
			url : '/salles/admin/Sallesadmin/update_set',
			type : 'POST',
			data: fd,
			processData: false,
			contentType: false,
			success: function(data){
				// alert('success');
				if(JSON.parse(data).status == 'success'){
					$('.date_set ._date_info').html(JSON.parse(data).data);
					$('._set_date_update').removeClass('hidden');
					$('.wrapper_date_btn,._select_date').addClass('hidden');
				} else {
					// TODO
					// REPORTING ERROR
					alert('error');
				}
			},
			error: function(){
				alert('error');
			}
		});

	});

	$(document).on('click', '._set_date_cancel', function(e) {
		e.preventDefault();
		$('._set_date_update').removeClass('hidden');
		$('.wrapper_date_btn,._select_date').addClass('hidden');

	});
	/*
	* Navigation Set horaire
	 */
	$(document).on('click','.next_set',function(e){
		if($('input[type=text]:enabled:visible').length != 0 || $('._delete_horaire_validate:visible').length != 0){
			return;
		}
		var that = $(this).parents('.table_wrapper');
		that.hide();
		that.next('.table_wrapper').show();
	});
	$(document).on('click','.prev_set',function(e){
		if($('input[type=text]:enabled:visible').length != 0 || $('._delete_horaire_validate:visible').length != 0){
			return;
		}
		var that = $(this).parents('.table_wrapper');
		that.prev('.table_wrapper').show();
		that.hide();
	});
});

var fn_salle = {
	del : function(id){
		var datas = {"titre":"Suppression salle","txt":"Le salle à bien été supprimée","id":id};
		_inPop.open('/salles/admin/Sallesadmin/delete', datas, 'alerte');
		$('#_tr'+id).slideUp(500);
	},
	setIndispo : function(indispo){
		var datas = {'titre':'Indisponibilité','txt':'L\'indisponibilité a été créée avec succès','indispo':indispo,'salle':salle};
		_inPop.open('/reservation/admin/Reservationadmin/setIndispo',datas,'alerte');
	},
	delindispo : function(id){
		var datas = {"titre":"Suppression indisponibilité","txt":"L'indisponibilité à bien été supprimée","id":id};
		_inPop.open('/salles/admin/Sallesadmin/deleteIndispo', datas, 'alerte');
		$('#_tr'+id).slideUp(500);
	}
};
