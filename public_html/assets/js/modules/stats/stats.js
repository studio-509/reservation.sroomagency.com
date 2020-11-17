$(document).on('ready',function() {
	
	/**
	* Gestion onglets
	*/
	$(document).on('click','._tab_drop',function(){
		var onglet = $(this).attr('id');
		var tab = '#bloc_' + $(this).attr('id');
		$('._tab_bloc').addClass('hidden');
		
		$('._tab_drop').removeClass('button_active');
		$(this).addClass('button_active');
		$(tab).removeClass('hidden');
		
		var datas = {};
		_Ajax.reload('/stats/admin/Statsadmin/get_'+onglet,'bloc_'+onglet,datas);
		//alert('/stats/admin/Statsadmin/get_'+onglet);
		
	});
});