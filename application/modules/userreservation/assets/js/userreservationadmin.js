$(document).ready(function() {

    $('body').on('click','a.closePopin', function(){
		if((document.URL).search('reservation') != 1){
			if ($('#_popin_title').html() == "Récapitulatif de votre réservation") {
				var id = $('#modif_resa_calendar').attr('data-id');
				var datas = {"titre":"Annulation reservation","txt":"Voulez-vous vraiment annuler votre réservation ?","id":id};
				_inPop.open('/popin/confirm', datas, 'alerte', 'fn_reservation.cancelflo("'+id+'")', 'fn_reservation.reload('+id+')');
				
			}
			else if (($('#_popin_title').html() == "Modification de vos coordonnées")||($('#_popin_title').html() == "Code promo / Carte cadeau")||($('#_popin_title').html() == "Modification de votre réservation")) {
				var id = $('#reservation_id').val();
				fn_reservation.reload(id);
			}
        }
        if((document.URL).search('admin') == -1){
            return;
        }
		
        _Ajax.reload('/reservation/admin/Reservationadmin/listing','bloc_resa_liste');
        _Ajax.reload('/reservation/admin/Reservationadmin/calendar','calendar',{'start':$('.calday:first').attr('data-day'),salle:$('#salle-admin option:selected').val()});
        if(typeof addIndispo != 'undefined' && addIndispo == 1){
            $('._add_indispo').removeClass('hidden');
            $('._add_resa').removeClass('hidden');
            $('#info_resa').html('');
            addIndispo = 0;
        }
    });

    /**
	* formulaire réservation admin
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
			var regHoraireA = new RegExp('[h]', 'g');
			horaire = horaire.replace(regHoraireA, ':');
			if (horaire.length == 4) {
				horaire = '0'+horaire;
			}
			indispo = jour +' '+horaire;
		}
		else if($('#id_reservation').val() !='')
		{
			
			$('html, body').animate({ scrollTop: $('#formrow').offset().top-80 }, 'fast');
			
			var jour = $(this).attr('data-day');
			var jour_fr = new Date(jour);
			var horaire = $(this).attr('data-hour');
			$('#jour_resa').val(jour);
			$('#horaire_resa').val(horaire);
			$('#date_resa').html('<strong>'+jour_fr.toLocaleDateString('fr-FR')+' à '+horaire+'</strong>');
			$('#date_resa').addClass('text-danger');			
		}
		else if(typeof addIndispo == 'undefined' || addIndispo == 0) {
			var jour = $(this).attr('data-day');
			var jour_fr = new Date(jour);
			var horaire = $(this).attr('data-hour');
			var salle = $('#salle-admin option:selected').val();
			var joueurs = $('#joueurs option:selected').val();
			$('#formrow').removeClass('hidden');
			$('html, body').animate({ scrollTop: $('#formrow').offset().top-80 }, 'fast');
			$('#jour_resa').val(jour);
			$('#horaire_resa').val(horaire);
			$('#date_resa').html('<strong>'+jour_fr.toLocaleDateString('fr-FR')+' à '+horaire+'</strong>');
			$('#jour_heure_resa').show();
			$('#date_resa').addClass('text-danger');
			
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
			
			
			
			
			
			/* $('html, body').animate({ scrollTop: 0 }, 'fast');
			$('.error').each(function(){
				if($(this).is(':visible'))$(this).hide();
			});
			$('.bg_error').each(function(){
				$(this).removeClass('bg_error');
			});
			var comment = ($('#comment').val().length)?$('#comment').val():'';
			var tarifstand = ($('input[name=tarifstand]:checked').val()=='1')?'1':'0';
			var tarif = (tarifstand != '1')?$('#tarif').val():'';
			var envoimail = $('input[name=envoimail]:checked').val()||'';
			var societe = $('input[name=societe]:checked').val()||'';
			var required = _tools.required('resa_admin_form');
			var format_email = _tools.format_email('resa_admin_form');
			var joueurs = $('#joueurs option:selected').val();
			if(required == 0 && format_email == 0 && envoimail != '' && joueurs !=0)
			{
				var nomsalle = $('#salle-admin option:selected').html();
				var jour = $(this).attr('data-day');
				var jour_fr = new Date(jour);
				$('#jour_resa').val(jour);
				var horaire = $(this).attr('data-hour');
				$('#horaire_resa').val(horaire);
				var tel = $('#tel').val();
				var titre = 'Confirmation de la date selectionnée';
				var txt =' Vous avez choisi de créer une nouvelle réservation pour '+nomsalle+' pour le '+jour_fr.toLocaleDateString('fr-FR')+' à '+horaire+'. Validez ce choix pour la création';
				var datas = {'titre':titre,'jour':jour,'horaire':horaire,'txt':txt,"comment":comment,"envoimail":envoimail,"societe":societe,"tarifstand":tarifstand,"tarif":tarif};
				_inPop.open('/popin/valid',datas,'','fn_reservation.add()');
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
			} */
		} 
	});
	
});
