$(document).ready(function() {

    $('body').on('click','a.closePopin', function(){
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
        if((document.URL).search('admin') == -1){
            return;
        }
        if($('#info_resa').html() == '' ){
			e.preventDefault();
			e.stopPropagation();
			return;
		}
		if($('#id_reservation').val() !='')

		{
			var jour = $(this).attr('data-day');
			var jour_fr = new Date(jour);
			var horaire = $(this).attr('data-hour');
			$('#jour_resa').val(jour);
			$('#horaire_resa').val(horaire);
			$('#date_resa').html('<strong>'+jour_fr.toLocaleDateString('fr-FR')+' à '+horaire+'</strong>');
			$('#date_resa').addClass('text-danger');
		} else if(typeof addIndispo == 'undefined' || addIndispo == 0) {
			$('.error').each(function(){
				if($(this).is(':visible'))$(this).hide();
			});
			$('.bg_error').each(function(){
				$(this).removeClass('bg_error');
			});
			var required = _tools.required('resa_admin_form');
			var format_email = _tools.format_email('resa_admin_form');
			if(required == 0 && format_email == 0)
			{
				var jour = $(this).attr('data-day');
				var jour_fr = new Date(jour);
				$('#jour_resa').val(jour);
				var horaire = $(this).attr('data-hour');
				$('#horaire_resa').val(horaire);
				var tel = $('#tel').val();
				var titre = 'Confirmation de la date selectionnée';
				var txt =' Vous avez choisi de créer une nouvelle réservation pour le '+jour_fr.toLocaleDateString('fr-FR')+' à '+horaire+'. Validez ce choix pour la création';
				var datas = {'titre':titre,'jour':jour,'horaire':horaire,'txt':txt};
				_inPop.open('/popin/valid',datas,'','fn_reservation.add()');
			}
		} else if (addIndispo == 1) {
			var jour = $(this).attr('data-day');
			var jour_fr = new Date(jour);
			var horaire = $(this).attr('data-hour');
			$('#indisSel').html('le '+ jour_fr.toLocaleDateString('fr-FR') + ' à ' +horaire + 'h');
			if(!$('._valid_indispo').length){
				$('<div class="col-md-3 col-md-offset-3 text-center"><button class="_valid_indispo button ">Valider</button></div>').appendTo('#info_resa');
			}
			indispo = jour + ' '+horaire;
		}
	});
});
