$(document).on('ready',function() {
	
	/**
	* Rechargement fermeture popin
	*/
	$('body').on('click','a.closePopin', function(){
		if (($('#_popin_title').html() == "Modification des données d'un collaborateur")||($('#_popin_title').html() == "Ajout d'un collaborateur")) {
			var datas = {};
			_Ajax.reload('/userplanning/admin/Userplanningadmin/get_list_personnel','bloc_staff_list',datas);
			
		}
		if (($('#_popin_title').html() == "Modification d'un planning")||($('#_popin_title').html() == "Ajout d'un planning")||($('#_popin_title').html() == "Suppression planning")) {
			var staffselected = $('#staff_select option:selected').val();
			var datas = {'staffselected':staffselected};
			_Ajax.reload('/userplanning/admin/Userplanningadmin/get_planning_list','bloc_staff_planning_list',datas);
			
			
		}
    });
	/**
	* Gestion onglets
	*/
	$(document).on('click','._tab_drop',function(){
		var tab = '#bloc_' + $(this).attr('id');
		$('._tab_bloc').addClass('hidden');
		$('._tab_drop').removeClass('button_active');
		$(this).addClass('button_active');
		$(tab).removeClass('hidden');
	});
	
	/**
	* affichage formulaire modification/ajout collaborateur
	*/
	$(document).on('click', '._staff_add_update', function() {
		$('._popin_box').removeClass('error');
		var id = $(this).attr('data-id');
		if (id == '') var titre = "Ajout d'un collaborateur";
		else var titre = "Modifications des données d'un collaborateur";		
		var datas = {"titre":titre,"id":id};
		_inPop.open('/userplanning/admin/Userplanningadmin/load_staff_form', datas, 'alerte', 'fn_staff.update()');
	});
	
	/**
	* gestion checkboxes gm form collaborateur
	*/
	$(document).on('click', '.gm_checkbox', function(){
		if ($(this).is(':checked')) {
			if($('.gm_prio_radio[class="gm_prio_radio hidden"]').length == $('.gm_prio_radio').length) $('.gm_prio_radio[value='+$(this).val()+']').prop('checked',true);
			$('#li_prio_master').removeClass('hidden');
			$('.gm_prio_radio[value='+$(this).val()+']').removeClass('hidden');
			$('#nomradiogm'+$(this).val()).removeClass('hidden');
		}
		else {
			if ($('.gm_prio_radio[value='+$(this).val()+']').is(':checked')) {
				$('.gm_prio_radio[class="gm_prio_radio"]').each(function() {
					$(this).prop('checked',true);
					return false;
				});
			}
			if ($('input:checked[name=gm]').length == 0) $('#li_prio_master').addClass('hidden');
			$('.gm_prio_radio[value='+$(this).val()+']').addClass('hidden');
			$('#nomradiogm'+$(this).val()).addClass('hidden');			
		}
	});
	
	/**
	* gestion checkboxes rst form collaborateur
	*/
	$(document).on('click', '.rst_checkbox', function(){
		if ($(this).is(':checked')) {
			if($('.rst_prio_radio[class="rst_prio_radio hidden"]').length == $('.rst_prio_radio').length) $('.rst_prio_radio[value='+$(this).val()+']').prop('checked',true);
			$('#li_prio_rst').removeClass('hidden');
			$('.rst_prio_radio[value='+$(this).val()+']').removeClass('hidden');
			$('#nomradiorst'+$(this).val()).removeClass('hidden');
		}
		else {
			if ($('.rst_prio_radio[value='+$(this).val()+']').is(':checked')) {
				$('.rst_prio_radio[class="rst_prio_radio"]').each(function() {
					$(this).prop('checked',true);
					return false;
				});
			}
			if ($('input:checked[name=rst]').length == 0) $('#li_prio_rst').addClass('hidden');
			$('.rst_prio_radio[value='+$(this).val()+']').addClass('hidden');
			$('#nomradiorst'+$(this).val()).addClass('hidden');			
		}
	});
	
	/**
	* update/add collaborateur
	*/
	$(document).on('click', '#_submit_staff_addmodif_form', function(){
		$('.error').each(function(){
			$(this).addClass('masque2');
		});	
		var id = $('#staff_id').val();
		var nom = $('#nom').val();
		var prenom = $('#prenom').val();
		var adresse = $('#adresse').val();
		var tel = $('#tel').val();
		var secu = $('#secu').val();
		var competences = $('#competences').val();
		var color = $('#color').val();
		var gm = '';
		$('.gm_checkbox').each(function() {
			if ($(this).is(':checked')) gm += $(this).val()+'|';
		});
		gm = (gm.length !=0)?gm.substr(0,gm.length-1):'';
		var gm_prio = '';
		$('.gm_prio_radio').each(function() {
			if ($(this).is(':checked')) gm_prio = $(this).val();
		});
		var rst = '';
		$('.rst_checkbox').each(function() {
			if ($(this).is(':checked')) rst += $(this).val()+'|';
		});
		rst = (rst.length !=0)?rst.substr(0,rst.length-1):'';
		var rst_prio = '';
		$('.rst_prio_radio').each(function() {
			if ($(this).is(':checked')) rst_prio = $(this).val();
		});
		var titre = (id !== '')?"Modification des données d'un collaborateur":"Ajout d'un collaborateur";	
		var datas = {"titre":titre,"id":id,"nom":nom,"prenom":prenom,"adresse":adresse,"tel":tel,"secu":secu,"competences":competences,"gm":gm,"gm_prio":gm_prio,"rst":rst,"rst_prio":rst_prio,"color":color};
		var required = _tools.required('staff_form');
		if(required == 0){
			_Ajax.send('/userplanning/admin/Userplanningadmin/update',datas);
		} 	
	});
	
	/**
	*  Suppression Collaborateur
	*/
	$(document).on('click','._staff_delete', function(){
		var id = $(this).attr('data-id');
		var datas = {"titre":"Suppression Collaborateur","txt":"Voulez vous vraiment supprimer ce collaborateur ?","id":id};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_rh.del('+id+')');
	});
	
	/**
	* Planning changement de collaborateur
	*/
	$(document).on('change','#staff_select',function(){
		var staffselected = $('#staff_select option:selected').val();
		var datas = {'staffselected':staffselected};
		_Ajax.reload('/userplanning/admin/Userplanningadmin/get_planning_list','bloc_staff_planning_list',datas);
	});
		
	/**
	* affichage formulaire modification/ajout planning
	*/
	$(document).on('click', '._staff_planning_add_update', function() {
		$('._popin_box').removeClass('error');
		var staffselected = $('#staff_select option:selected').val();
		var id = $(this).attr('data-id');
		if (id == '') var titre = "Ajout d'un planning";
		else var titre = "Modifications d'un planning";	
		var datas = {"titre":titre,"id":id,"staffselected":staffselected};
		_inPop.open('/userplanning/admin/Userplanningadmin/load_planning_form', datas, 'alerte', 'fn_staff.update()');
	});
	
	/**
	* Clicks cases none planning
	*/
	$(document).on('click','.hour_button_none',function(){
		$('.error').each(function() {
			$(this).hide();
		});
		if($('.hour_button_select').length == 1) {
			var jhstart = $('.hour_button_select').attr('data-id').split('|');
			var jhend = $(this).attr('data-id').split('|');
			var jourstart = jhstart[0];
			var jourend = jhend[0];
			var jourint = parseInt(jourstart,10);
			var hstart = parseInt(jhstart[1],10);
			var hend = parseInt(jhend[1],10)+1;
			if(jourstart != jourend) {
				$('#error_difdays').show();
				$('.hour_button_select').addClass('hour_button_none');
				$('.hour_button_select').removeClass('hour_button_select');
			}
			else if (hend < hstart) {
				$('#error_startafterend').show();
				$('.hour_button_select').addClass('hour_button_none');
				$('.hour_button_select').removeClass('hour_button_select');
			}
			else {
				$('.hour_button_select').addClass('hour_button_active');
				$('.hour_button_select').removeClass('hour_button_select');	
				$('._titre_col_plan[data-id="'+jourstart+'"]').addClass('_reset_planning_day');
				for (var i = hstart ; i< hend ; i++) {
					var val = jourstart+'|'+i;			
					$('.hour_button_none[data-id="'+val+'"]').addClass('hour_button_active');				
					$('.hour_button_none[data-id="'+val+'"]').removeClass('hour_button_none');
				}
			}
		}
		else {
			$(this).removeClass('hour_button_none');
			$(this).addClass('hour_button_select');
		}
	});
	
	/**
	* Clicks cases select planning
	*/
	$(document).on('click','.hour_button_select',function(){
		$(this).removeClass('hour_button_select');
		$(this).addClass('hour_button_active');
	});
	
	/**
	* Clicks cases active planning
	*/
	$(document).on('click','.hour_button_active',function(){
		$(this).removeClass('hour_button_active');
		$(this).addClass('hour_button_none');
		$('.hour_button_select').removeClass('hour_button_select');
		var day = $(this).attr('data-id').split('|');
		var dayoncount = 0;
		$('.hour_button').each(function() {
			var infos = $(this).attr('data-id').split('|');
			if (infos[0] == day[0] && $(this).hasClass('hour_button_active')) {
				dayoncount++;
			}
		});
		if (dayoncount == 0) $('._titre_col_plan[data-id="'+day[0]+'"]').removeClass('_reset_planning_day');		
	});
	
	/**
	* Clicks reset jour planning
	*/
	$(document).on('click','._reset_planning_day',function(){
		var day = $(this).attr('data-id');
		$('.hour_button').each(function() {
			var infos = $(this).attr('data-id').split('|');
			if (infos[0] == day) {
				$(this).removeClass('hour_button_active');
				$(this).removeClass('hour_button_select');
				$(this).addClass('hour_button_none');
			}
		});
		$(this).removeClass('_reset_planning_day');
	});
	
	/**
	* Affichage/Masquage parite formulaire planning
	*/
	$(document).on('change','#staff_planning_type_select',function(){
		var type = $(this).val();
		if (type == 'recur') $('#selectparite').removeClass('hidden');
		else $('#selectparite').addClass('hidden');
	});
	

	/**
	* Affichage semaine choix date formulaire planning
	*/
	$(document).on('change','#dateplanning',function(){
		var date = $(this).val();
		var datas = {'date':date};
		_Ajax.reload('/userplanning/admin/Userplanningadmin/get_week_number','numberofweek',datas);
	});
	
	/**
	* Update/add planning
	*/
	$(document).on('click','#_submit_planningset_addmodif_form',function(){
		$('.error').each(function() {
			$(this).hide();
		});
		var id = $('#planningset_id').val();
		var staffid = $('#planningstaff_id').val();
		var type = $('#staff_planning_type_select option:selected').val();
		var parite = $('input[name=parite]:checked').val();
		var date = $('#dateplanning').val();
		var startok = true;
		if (id == '') {
			jQuery.ajaxSetup({async: false});
			jQuery.ajax({
				type: 'POST',
				url: '/userplanning/admin/Userplanningadmin/testPlanAlreadyOn',
				data: {
					'id':staffid,
					'type':type,
					'date':date,
					'parite':parite
				},
				success: function(data, textStatus, jqXHR) {
					if (data == 'ko') 
					{
						startok = false;	
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert("error");
				}
			});
			jQuery.ajaxSetup({async: true});
		}
		var start = false;
		var infosplanning = '';
		for (var i=1;i<8;i++) {
			
			for (var j=0;j<32;j++) {
				var val = i+'|'+j;
				
				if($('.hour_button[data-id="'+val+'"]').hasClass('hour_button_active') && start == false) {		
					infosplanning += i + '|'+ $('.hour_button[data-id="'+val+'"]').html() + '|';
					if (j==31) infosplanning += '00h00||';
					start = true;
				}
				else if ($('.hour_button[data-id="'+val+'"]').hasClass('hour_button_none') && start == true) {
					infosplanning += $('.hour_button[data-id="'+val+'"]').html()+'||';
					start = false;
				}
				else if ($('.hour_button[data-id="'+val+'"]').hasClass('hour_button_active') && start == true && j == 31) {
					infosplanning += '00h00||';
					start = false;
				}
			}
		}
		var titre = (id !== '')?"Modification d'un planning":"Ajout d'un planning";
		var datas = {'titre':titre,'id':id,'type':type,'parite':parite,'date':date,'id_staff':staffid,'infosplanning':infosplanning};
		if(startok == true){
				
				_Ajax.send('/userplanning/admin/Userplanningadmin/updatePlanning',datas);
		}
		else {
			$('#error_type_date').show();
		}
	});
	
	/**
	*  Suppression ¨Planning
	*/
	$(document).on('click','._staff_planning_delete', function(){
		var id = $(this).attr('data-id');
		var datas = {"titre":"Suppression Planning","txt":"Voulez vous vraiment supprimer ce planning ?","id":id};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_rh.delplanning('+id+')');
	});
	
	
	/**
	* Congès/Périodes Off changement de collaborateur
	*/
	$(document).on('change','#staff_off_select',function(){
		var staffselected = $('#staff_off_select option:selected').val();
		var datas = {'staffselected':staffselected};
		_Ajax.reload('/userplanning/admin/Userplanningadmin/get_off_period','bloc_staff_off_period',datas);
	});
	
	/**
	* Extras changement de collaborateur
	*/
	$(document).on('change','#staff_extra_select',function(){
		var staffselected = $('#staff_extra_select option:selected').val();
		var datas = {'staffselected':staffselected};
		_Ajax.reload('/userplanning/admin/Userplanningadmin/get_extra_period','bloc_staff_extra_period',datas);
	});
	
	/**
	* jump semaines
	*/
	$('body').on('touchend click', '._cal_drop', function(){
		var time = $(this).attr('data-id');
		var origine = $(this).attr('data-orig');
		var datas = {"start":time};
		_Ajax.reload('/userplanning/admin/Userplanningadmin/get_global_planning', 'bloc_staff_global_planning', datas);
	});
	
	

});

var fn_rh = {
	del : function(id){
		var datas = {"titre":"Suppression collaborateur","txt":"Le collaborateur à bien été supprimé","id":id};
		_inPop.open('/userplanning/admin/Userplanningadmin/delete', datas, 'alerte');
		$('#_tr'+id).slideUp(500);
	},
	delplanning : function(id){
		var datas = {"titre":"Suppression planning","txt":"Le planning à bien été supprimé","id":id};
		_inPop.open('/userplanning/admin/Userplanningadmin/delete_planning', datas, 'alerte');
		$('#_tr'+id).slideUp(500);
	}
};


