$('body').ready(function() {

	/**
     * affichage formulaire modification email
     */
    $('body').on('click', '._email_update', function() {
		
		var id = $(this).attr('data-id');
		var datas = {"titre":"Modification message","id":id};
		_inPop.open('/emails/admin/Emailsadmin/infos', datas);
    });

    /**
     * update email
     */
    $('body').on('click', '#_submit_email_admin_form', function(){
	    var id = $('#email_id').val();

		var datas = {"titre":"Modification message","id":$('#email_id').val(),"sujet":$('#sujet').val(),"message":$('#message').val()};
	    _Ajax.send('/emails/admin/Emailsadmin/update', datas);
    });

});
