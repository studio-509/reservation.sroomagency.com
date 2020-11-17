$('body').ready(function() {
		
	/**
	 * validation settings
	 */
	 $(document).on('click', '._settings_validate', function() {
		var creneau = $(this).attr('data-id');
		var startDay = $('.settings_form[data-id="'+creneau+'"] select[name=start-day] option:selected').val();
		var startDayString = $('.settings_form[data-id="'+creneau+'"] select[name=start-day] option:selected').html();
		var startHour = $('.settings_form[data-id="'+creneau+'"] input[name=start-hour]').val();
		var endDay = $('.settings_form[data-id="'+creneau+'"] select[name=end-day] option:selected').val();
		var endDayString = $('.settings_form[data-id="'+creneau+'"] select[name=end-day] option:selected').html();
		var endHour = $('.settings_form[data-id="'+creneau+'"] input[name=end-hour]').val();
		var tseId = $('.settings_form[data-id="'+creneau+'"] input[name=tseid]').val();
		var tse_start = startDay +'|'+ startHour;
		var tse_end = endDay +'|'+ endHour;
		var tse_id = tseId;
		var datas = {'tse_start':tse_start,'tse_end':tse_end,'tse_id':tse_id};
		_inPop.open('/tarifs/admin/Tarifsadmin/update_settings', datas, 'alerte');

		
	 });
	/**
	* suppression tarif
	*/
	$('body').on('click', '._tarif_delete', function() {
		var id = $(this).attr('data-id');
		var datas = {"titre":"Suppression tarif","txt":"Voulez vous vraiment supprimer ce tarif ?"};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_tarif.del('+id+')');
	});

	/**
	 * affichage formulaire création tarif
	 */
	 $('body').on('click', '._tarif_add', function() {
	 	var datas = {"titre":"Ajout tarif","salle":$('#salle-admin').val()};
	 	_inPop.open('/tarifs/admin/Tarifsadmin/infos', datas, 'alerte', 'fn_tarif.update()');
	 });

	/**
	* affichage formulaire modification tarif
	*/
	$('body').on('click', '._tarif_update', function() {
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		var id = $(this).attr('data-id');
		var datas = {"titre":"Modification tarif","id":id};
		_inPop.open('/tarifs/admin/Tarifsadmin/infos', datas, 'alerte', 'fn_tarif.update()');
	});

	$(document).on('click','input[name=type]',function(e){
		$('select[name^=empty-').addClass('hidden');
		$('select[name=empty-'+$(this).val()+']').removeClass('hidden');
	});

	/**
	* update/add tarif
	*/
	$(document).on('click', '#_submit_tarif_admin_form', function(){
		$('#error_tarif').addClass('masque2');
		var id = $('#tarif_id').val();
		var tarif = $('#tarif').val();
		if( tarif == 0){
			$('#error_tarif').removeClass('masque2');

			// $('<span class="error">Tarif nul impossible</span>').prependTo('#tarif_form input[type=text]');
			return false;
		}
		var titre = (id !== '')?'Modification tarif':'Ajout tarif';
		var salle = $('#salle-admin').val();
		var type = $('input[name=type]:checked').val();
		var joueurs = $('select[name="empty-' + $('input[name=type]:checked').val() + '"] option:selected').val();
		var datas = {"titre":titre,"id":id,"tarif":tarif,'type':type,'joueurs': joueurs,'salle_id':salle};
		var required = _tools.required('tarif_form');
		if(required == 0){
			_Ajax.send('/tarifs/admin/Tarifsadmin/update', datas);
			// _Ajax.reload('/tarifs/admin/Tarifsadmin/getTarifSalle' , 'table-annonces' , {'salle':$('#salle-admin').val()});
		}
	});
	/**
	*  Suppression Plage tarif réduit
	*/
	$(document).on('click','._setting_delete', function(){
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		var id = $(this).attr('data-id');
		var datas = {"titre":"Suppression Plage de Tarif Réduit","txt":"Voulez vous vraiment supprimer cette plage de tarif réduit ?","id":id};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_tarif.delsetting('+id+')');
	});
	/**
	*  Suppression Tarif
	*/
	$(document).on('click','._tarif_delete', function(){
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		var id = $(this).attr('data-id');
		var datas = {"titre":"Suppression Tarif","txt":"Voulez vous vraiment supprimer ce tarif ?","id":id};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_tarif.del('+id+')');
	});
	/**
	*  Suppression Promo
	*/
	$(document).on('click','._promo_delete', function(){
		var id = $(this).attr('data-id');
		console.log(id);
		var datas = {"titre":"Suppression Promotion","txt":"Voulez vous vraiment supprimer cette promotion ?","id":id};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_tarif.delpromo('+id+')');
	});
	/**
	* affichage formulaire creation promos
	*/
	$('body').on('click', '._promo_add', function() {
		var datas = {"titre":"Création promotion"};
		_inPop.open('/tarifs/admin/Tarifsadmin/infos_promo', datas, 'alerte', 'fn_tarif.update()');
	});
	/**
	* affichage formulaire update promos
	*/

	$('body').on('click', '._promo_update', function() {
		var id = $(this).attr('data-id');
		var datas = {"titre":"Mise à jour promotion","id":id};
		_inPop.open('/tarifs/admin/Tarifsadmin/infos_promo', datas, 'alerte', 'fn_tarif.update()');
	});
	/**
	* Vérification et soumission formulaire creation/update promo
	**/
	$('body').on('click','#_submit_promo_admin_form',function(){
		$('[id^=error]').hide();
		var required = _tools.required('form_promo');
		if(required == 0){
			var salles = [];
			$.each($('input[name=salle]:checked'), function(){
				salles.push($(this).val());
			});
			if (salles.length == 0)
			{
				$('#error_salle').show();
			} else {
				var titre_promo = $('#titre_promo').val();
				var taux_promo = $('#taux_promo').val();
				var type_promo = $('#type_promo').val();
				var start = $('#date_start').val();
				var end = $('#date_end').val();
				var code = $('#code_promo').val();
				var id_promo = $('[name=id_promo]').val();
				if (id_promo == ''){
					var titre = 'Creation promotion';
				} else {
					var titre = 'Modification promotion';
				}
				var datas={"titre":titre,"id":id_promo,"titre_promo":titre_promo,"taux_promo":taux_promo,"type_promo":type_promo,"start":start,"end":end,"salles":salles,'code':code};
				_inPop.open('/tarifs/admin/Tarifsadmin/update_promo',datas,'alerte','fn_tarif.update()');
			}
		}
	});
	/**
	* Gestion Onglets
	**/
	$('._tab_drop').click(function(){
		var tab = '#bloc_' + $(this).attr('id');
		$('._tab_bloc').hide();
		$('._tab_drop').removeClass('button_active');
		$(this).addClass('button_active');
		$(tab).show();
	});

	$(document).on('click', '._settings_update', function(e) {
		e.preventDefault();
		var creneau = $(this).attr('data-id');
		$('.settings[data-id="'+creneau+'"]').addClass('hidden');
		$('._settings_update[data-id="'+creneau+'"]').addClass('hidden');
		$('.settings_form[data-id="'+creneau+'"],._settings_cancel[data-id="'+creneau+'"],._settings_validate[data-id="'+creneau+'"]').removeClass('hidden');
	});
	$(document).on('click', '._settings_cancel', function(e) {
		e.preventDefault();
		var creneau = $(this).attr('data-id');
		$('.settings[data-id="'+creneau+'"]').removeClass('hidden');
		$('._settings_update[data-id="'+creneau+'"]').removeClass('hidden');
		$('.settings_form[data-id="'+creneau+'"],._settings_cancel[data-id="'+creneau+'"],._settings_validate[data-id="'+creneau+'"]').addClass('hidden');
	});

	/**
	 * Changement salle
	 */
	$(document).on('change',"#salle-admin",function(e){
		_Ajax.reload('/tarifs/admin/Tarifsadmin/getTarifSalle' , 'bloc_tarif' , {'salle':$('#salle-admin').val()});
	});

	$(document).on('click','.closePopin',function(e){
		_Ajax.reload('/tarifs/admin/Tarifsadmin/getTarifSalle' , 'bloc_tarif' , {'salle':$('#salle-admin').val()});
		_Ajax.reload('/tarifs/admin/Tarifsadmin/get_list_promo' , 'bloc_promo' );
		_Ajax.reload('/tarifs/admin/Tarifsadmin/getSettingsTarifs' , 'bloc_settings_list' );

	});
});


var fn_tarif = {
	del : function(id){
		var datas = {"titre":"Suppression tarif","txt":"Le tarif à bien été supprimé","id":id};
		_inPop.open('/tarifs/admin/Tarifsadmin/delete', datas, 'alerte');
		$('#_tr'+id).slideUp(500);
	},
	delpromo : function(id){
		var datas = {"titre":"Suppression Promotion","txt":"La Promotion à bien été supprimée","id":id};
		_inPop.open('/tarifs/admin/Tarifsadmin/delete_promo', datas, 'alerte');
		$('#_tr'+id).slideUp(500);
	},
	delsetting : function(id){
		var datas = {"titre":"Suppression Plage de Tarif Réduit","txt":"La Plage de tarif réduit à bien été supprimée","id":id};
		_inPop.open('/tarifs/admin/Tarifsadmin/delete_setting', datas, 'alerte');
		$('#_tr'+id).slideUp(500);
	},
	addsetting : function(){
		var datas = {"titre":"Ajout de Plage de Tarif Réduit","txt":"La Plage de tarif réduit à bien été ajoutée"};
		_inPop.open('/tarifs/admin/Tarifsadmin/add_setting', datas, 'alerte');
		$('#_tr'+id).slideUp(500);
	}
};
