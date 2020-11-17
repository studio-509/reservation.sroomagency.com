$(document).ready(function(){
    /**
    * vérification formulaire front
    **/
    $('#_submit_voucher_front_form').on('click touchend',cancelDuplicates(function(event){
		$('html, body').animate({ scrollTop: 0 }, 'fast');
        $('.error').each(function(){
            if($(this).is(':visible'))$(this).hide();
        });
        $('.bg_error').each(function(){
            $(this).removeClass('bg_error');
        });		
        var required = _tools.required('resa_front_voucher_form');
        var format_email = _tools.format_email('resa_front_voucher_form');
        if(required == 0 && format_email == 0){
            v_id = $('input[name=voucher]:checked').val();
			var civil_acheteur = $('#civil').val();
			var nom_acheteur = $('#nom').val();
			var prenom_acheteur = $('#prenom').val();
			var civil_benef = $('#civil_d').val();
			var nom_benef = $('#nom_d').val();
			var prenom_benef = $('#prenom_d').val();
            if(v_id == null){
                $('#error_v').show();
            } else {			
                var datas = {'id':v_id,'civil':civil_acheteur,'nom':nom_acheteur,'prenom':prenom_acheteur,'civil_d':civil_benef,'nom_d':nom_benef,'prenom_d':prenom_benef};
                _inPop.open('/voucher/Voucher/recapitulatif', datas);
				
            }
        }
    }));
    /**
    * Vérification formulaire admin et envoi si ok
    **/
    $('body').on('touchend click','#_submit_voucher_item_form',function(e){
        e.preventDefault();
        $('.error').each(function(){
            if($(this).is(':visible'))$(this).hide();
        });
        $('.bg_error').each(function(){
            $(this).removeClass('bg_error');
        });
        var required = _tools.required('resa_admin_voucher_form');
        var format_email = _tools.format_email('resa_admin_voucher_form');
        var voucher = $('input:radio[name=voucher]:checked').val();
        if (voucher == null){
            $('#error_v').show();
        }
        if(required == 0 && format_email == 0 && voucher != null){
            // Récupération data client :
            var civil = $('select[name=civil]').val();
            var nom = $('input[name=nom]').val();
            var prenom = $('input[name=prenom]').val();
            var email = $('input[name=email]').val();
            var tel = $('input[name=tel]').val();
            //if ( $('input[name=creation]').prop('checked') == true){
                var creation = 1;
            //} else {
               // var creation = 0;
            //}
            // Récupération data destinataire
            var civil_d = $('select[name=civil_d]').val();
            var nom_d = $('input[name=nom_d]').val();
            var prenom_d = $('input[name=prenom_d]').val();
            var email_d = $('input[name=email_d]').val();
            var tel_d = $('input[name=tel_d]').val();
            //if ( $('input[name=creation_d]').prop('checked') == true){
                var creation_d = 1;
            //} else {
                //var creation_d = 0;
            //}
            // Récupération type de Carte Cadeau
            var voucher_code = $('input[name=voucher_code]').val();
            var valide = $('input[name=active]:checked').val();
			// Récupération commentaires
			var comment = (($('#comment').val().length)&&($('#comment').val()!='Écrivez un commentaire'))?$('#comment').val():'';
            // Récupération des ids initiales pour modifi
            var cl_id = $('input[name=cl_id]').val();
            var voucher_id = $('input[name=voucher_id]').val();
            var dest_id = $('input[name=dest_id]').val();
            datas = {'civil':civil,'nom':nom,'prenom':prenom,'email':email,'tel':tel,'creation':creation,'civil_d':civil_d,'nom_d':nom_d,'prenom_d':prenom_d,'email_d':email_d,'tel_d':tel_d,'creation_d':creation_d,'voucher':voucher,'voucher_id':voucher_id,'cl_id':cl_id,'dest_id':dest_id,'voucher_code':voucher_code,'valide':valide,'comment':comment};
            _Ajax.send('/voucher/admin/Voucheradmin/update_item', datas);
        }
    });
    /**
    * Génération code
    **/
    $('body').on('click','#_gen_code_voucher',function(){
        $.ajax({
            url : '/voucher/generate_voucher',
            type : 'POST',
            success: function(data){
                $('input[name=voucher_code]').val(data);
            }
        });
    });
    /**
    * validation CGV
    */
    $('body').on('click', '._order_voucher_process', function(){
        $('#error_cgv').hide();
        if($('#order_cgv').prop('checked') === false){
            $('#error_cgv').show();
        }
        else{
            $("#_submit_voucher_go").trigger("click");
        }
    });
	
/**
	* Boîte de dialogue création de pdf
	
	$('body').on('click','#createpdf', function(){	
		var datas = {'titre':'Création de carte cadeau','txt':'<img src="http://dev.secretroomagency.com/assets/img/attente_rubiks.gif" style="float:left;margin-right:2em;margin-left:2em;"/><p>Veuillez patienter quelques instants pendant que la carte cadeau est générée...</p>'};
		_inPop.open('/voucher/admin/Voucheradmin/create_pdf_alert', datas,'alerte','fn_totosurunpont');
		//$('._popin_body').html('<img src="http://dev.secretroomagency.com/assets/img/loading_apple.gif" />');
		var voucherid = $(this).attr('data-id');
		//var printedvoucher ='init';
 		jQuery.ajax({
			type: 'POST',
			url: '/voucher/pdf2',
			data: {
				'voucher':voucherid
			},
			success: function(data, textStatus, jqXHR) {
				var carteurl = '../assets/cartescadeau/Secret-Room-Agency-carte-cadeau-'+voucherid+'.pdf';
				//var printedvoucher = carteurl;
				$('._popin_body').html('<p>Votre carte cadeau a été créée : <a href="../assets/cartescadeau/Secret-Room-Agency-carte-cadeau-'+voucherid+'.pdf" target="_blank">Carte cadeau</a></p>');
				
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("erreur dans la création de carte cadeau");
			}
		});
	}); */
	
    /**
    * Activation/desactivation Voucher Item
    **/
    $('body').on('click','._voucher_set_inactive', function(){
		$('html, body').animate({ scrollTop: 0 }, 'fast');
        var id = $(this).attr('data-id');
        var datas = {'titre':'Desactivation Carte Cadeau','txt':'Voulez vous désaciver cette carte cadeau ?'};
        _inPop.open('/popin/confirm',datas,'alerte','fn_voucher.active('+id+',0)');
    });
    $('body').on('click','._voucher_set_active', function(){
		$('html, body').animate({ scrollTop: 0 }, 'fast');
        var id = $(this).attr('data-id');
        var datas = {'titre':'Activation Carte Cadeau','txt':'Voulez vous activer cette carte cadeau ?'};
        _inPop.open('/popin/confirm',datas,'alerte','fn_voucher.active('+id+',1)');
    });
    /**
    * Suppression Voucher Item
    **/
    $('body').on('click','._voucher_item_delete',function(){
		$('html, body').animate({ scrollTop: 0 }, 'fast');
        var id = $(this).attr('data-id');
		var code = $('._code_voucher'+id).html();
		var client = $('._client_voucher'+id).html();
		var date = $('._dateachat_voucher'+id).html();
        var datas = {"titre":"Suppression de la carte cadeau","txt":"Voulez vous vraiment supprimer la carte cadeau "+code+", achetée par "+client+", le "+date+" ? (opération irréversible)"};
        _inPop.open('/popin/confirm', datas, 'alerte', 'fn_voucher.del_item('+id+')');
    });
    /**
    * Update Voucher Item : Ouverture Popin
    **/
    $('body').on('click', '._voucher_item_update', function() {
		$('html, body').animate({ scrollTop: 0 }, 'fast');
        var id = $(this).attr('data-id');
        var datas = {"titre":"Modification carte cadeau","id":id};
        _inPop.open('/voucher/admin/Voucheradmin/infos_item', datas, 'alerte', '');
    });
    /**
    * Creation Voucher Item : Ouverture Popin
    **/
    $('body').on('click', '._voucher_item_add', function() {
		$('html, body').animate({ scrollTop: 0 }, 'fast');
        var datas = {"titre":"Creation carte cadeau"};
        _inPop.open('/voucher/admin/Voucheradmin/infos_item', datas, 'alerte', '');
    });
    /**
    * Suppression Voucher type
    **/
    $('body').on('click', '._voucher_delete', function() {
		$('html, body').animate({ scrollTop: 0 }, 'fast');
        var id = $(this).attr('data-id');
        var datas = {"titre":"Suppression type de carte cadeau","txt":"Voulez vous vraiment supprimer ce type de carte cadeau ?(opération irréversible)"};
        _inPop.open('/popin/confirm', datas, 'alerte', 'fn_voucher.del_type('+id+')');
    });
    /**
    * Update Voucher type : Ouverture Popin
    **/
    $('body').on('click', '._voucher_update', function() {
		$('html, body').animate({ scrollTop: 0 }, 'fast');
        var id = $(this).attr('data-id');
        var datas = {"titre":"Modification Type de carte cadeau","id":id};
        _inPop.open('/voucher/admin/Voucheradmin/infos_type', datas, 'alerte', 'fn_voucher.update()');
    });
    /**
    * Update Voucher type : Submit formulaire
    **/
    $('body').on('click', '#_submit_voucher_admin_form', function(){
        var id = $('#voucher_id').val();
        var active = $('input[name=active]:checked').val();
		var visible = $('input[name=visible]:checked').val();
        var description = $('#description').val();
        var prix =$('#prix').val();
        var datas = {"titre":"Modification voucher","id":id,"titre":$('#titre').val(),"active":active,"visible":visible,"description":description,"prix":prix};
        _Ajax.send('/voucher/admin/Voucheradmin/update', datas);
    });
    /**
    * Update Voucher CGV : Ouverture Popin
    **/
    $('body').on('click', '._cgv_update', function() {
		$('html, body').animate({ scrollTop: 0 }, 'fast');
        var datas = {"titre":"Modification CGV"};
        _inPop.open('/voucher/admin/Voucheradmin/infos_cgv', datas, 'alerte', 'fn_voucher.update()');
    });
    /**
    * Update Voucher CGV : Submit formulaire
    **/
    $('body').on('click', '#_submit_cgv_admin_form', function(){
        var id = $('#cgv_id').val();
        var datas = {"txt":$('textarea[name=cgv]').val(),'id':id};
        _Ajax.send('/voucher/admin/Voucheradmin/update_cgv', datas);
    });
    /**
    * Update Voucher Descriptif : Ouverture Popin
    **/
    $('body').on('click', '._desc_update', function() {
		$('html, body').animate({ scrollTop: 0 }, 'fast');
        var datas = {"titre":"Modification descriptif cartes cadeaux"};
        _inPop.open('/voucher/admin/Voucheradmin/infos_desc', datas, 'alerte', 'fn_voucher.update()');
    });
    /**
    * Reload après fermeture popin
    **/
    $('body').on('click','a.closePopin', function(){
        _Ajax.reload('/voucher/admin/Voucheradmin/listing','bloc_voucher_list');
        _Ajax.reload('/voucher/admin/Voucheradmin/listing_cgv','bloc_voucher_mng');
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
    $('body').on('change','._pag_setup', function(){
        var datas = {'pag':$(this).val()};
        _Ajax.reload('/voucher/admin/Voucheradmin/listing','bloc_voucher_list',datas);
    });
	
});
var fn_voucher = {
    del_type : function(id){
        var datas = {"titre":"Suppression type de carte cadeau","txt":"Le type de carte cadeau à bien été supprimé","id":id};
        _inPop.open('/voucher/admin/Voucheradmin/delete_type', datas, 'alerte');
        $('#_tr'+id).slideUp(500);
    },
    del_item : function(id){
        var datas = {"titre":"Suppression carte cadeau","txt":"La carte cadeau à bien été supprimée","id":id};
        _inPop.open('/voucher/admin/Voucheradmin/delete_item',datas,'alerte');
        $('#_tr'+id).slideUp(500);
    },
    active : function(id,active){
        if(active == 0 ){
            var titre = 'Désactivation';
        } else {
            var titre = 'Activation';
        }
        var datas= {'titre': titre+' de la carte cadeau','txt':'La carte cadeau a bien été mise à jour','id':id,'active':active};
        _inPop.open('/voucher/admin/Voucheradmin/activate',datas,'alerte');
    }
};

function cancelDuplicates(fn, threshhold, scope) {
    if (typeof threshhold !== 'number') threshhold = 100;
    var last = 0;

    return function () {
        var now = +new Date;

        if (now >= last + threshhold) {
            last = now;
            fn.apply(scope || this, arguments);
        }
    };
}
