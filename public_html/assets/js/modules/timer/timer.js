
$('body').ready(function() {
    /**
     * onglets
     */
    $('._tab_drop').click(function(){
        var tab = '#bloc_' + $(this).attr('id');
        $('._tab_bloc').hide();
        $(tab).show();
    });

    /**
     * demarrage jeu
     */
    $('body').on('click', '._timer_start', function(){
        $(this).removeClass('_timer_start');
        $('#_timer_btn_pause').addClass('_timer_pause');
        var id = $(this).attr('data-id');
        var datas = {"id":id};
		_Ajax.reload('/timer/admin/Timeradmin/startTimer', 'bloc_timer_' + id, datas);
    });

    /**
     * reset jeu
     */
    $('._timer_reset').click(function(){
        var id = $(this).attr('data-id');
        var datas = {"titre":"Reset partie","txt":"Voulez vous vraiment remettre cette partie à 0 ?"};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_timer.del('+id+')');
    });

    /**
     * pause jeu
     */
    $('body').on('click', '._timer_pause', function(){
        var id = $(this).attr('data-id');
        var datas = {"titre":"Pause partie","txt":"Voulez vous vraiment mettre cette partie en pause ?"};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_timer.pause('+id+')');
    });

    /**
     * reprise jeu
     */
    $('body').on('click', '._timer_restart', function(){
        var id = $(this).attr('data-id');
        var datas = {"titre":"Reprise partie","txt":"Voulez vous vraiment reprendre cette partie ?"};
		_inPop.open('/popin/confirm', datas, 'alerte', 'fn_timer.restart('+id+')');
    });

    /**
     * message joueurs
     */
     $('._mess_submit').click(function(){
         var id = $(this).attr('data-id');
         var txt = $('#text_' + id).val();
         var datas = {"id":id,'message':txt};
 		_Ajax.reload('/timer/admin/Timeradmin/message', '_bloc_mess_' + id, datas);
        $('#text_' + id).val('');
     });

// end of jquery part
});

var fn_timer = {

	del : function(id){
		_inPop.close();
        var datas = {'id':id,'time':3600};
		_Ajax.reload('/timer/admin/Timeradmin/resetTimer', 'bloc_timer_' + id, datas);
        $('._timer_restart').addClass('_timer_pause');
        $('._timer_restart').removeClass('_timer_restart');
        $('._timer_pause').html('Pause');
        $('#_timer_btn_start').addClass('_timer_start');
        $('#_bloc_mess_' + id).html();
	},

    pause : function(id){
		_inPop.close();
        var datas = {'id':id};
		_Ajax.reload('/timer/admin/Timeradmin/pauseTimer', 'bloc_timer_' + id, datas);
        $('._timer_pause').addClass('_timer_restart');
        $('._timer_pause').removeClass('_timer_pause');
        $('._timer_restart').html('Reprendre');
	},

    restart : function(id){
		_inPop.close();
        var datas = {'id':id};
		_Ajax.reload('/timer/admin/Timeradmin/restartTimer', 'bloc_timer_' + id, datas);
        $('._timer_restart').addClass('_timer_pause');
        $('._timer_restart').removeClass('_timer_restart');
        $('._timer_pause').html('Pause');
	},

};
