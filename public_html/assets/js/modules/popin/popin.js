$.ajaxSetup({ cache:false});

var _inPop = {
    open : function(link, datas, css_class, fn_callback, fn_callback2) {
		message = JSON.stringify(datas);
        jQuery('#_popin_loader').addClass('load1');
        jQuery.ajax({
  			type: 'POST',
  			url: link,
			cache:false,
  			data:{
	  			'message':message
				}
  			,
  			success: function(data, textStatus, jqXHR) {
				/* var  intElemScrollTop = element.scrollTop; 
				alert (intElemScrollTop);*/
	  			data = JSON.parse(data);
				if (data.resacreamodif) {
					var retourlistingresa = data.retourlistingresa;
				}
	  			jQuery('._popin_body').html(data.rPop);
                jQuery('#_popin_title').html(data.rPopTitle);
                if(css_class != '')
                	jQuery('._popin_box').addClass(css_class);
				/* jQuery('._popin_box').css({
					top: intElemScrollTop
				}); */
                if(fn_callback != '')
                	jQuery('#_popin_done').attr('onClick',fn_callback);
                if(fn_callback2 != '')
                	jQuery('#_popin_abort').attr('onClick',fn_callback2);
                jQuery('#_popin_loader').removeClass('load1');
                jQuery('#_popin').fadeIn(500);
  				},
  			error: function(jqXHR, textStatus, errorThrown) {
	  			jQuery('#_popin_loader').removeClass('load1');
	  			alert("error");
	  			}
		});
    },
    close : function(selector) {
		if (retourlistingresa = 'ok') {
			$('#resa_liste').trigger('click');
			jQuery('#_popin').fadeOut(500);
		}
        else if($('._order_process').length){
            $('._reset_resa').trigger('click');
        }
        else
            jQuery('#_popin').fadeOut(500);
    },
};
var _Ajax = {
	send : function(link, datas, css_class) {
		message = JSON.stringify(datas);
		jQuery('#_popin_loader').addClass('load1');
		jQuery.ajax({
  			type: 'POST',
  			url: link,
  			data: {
	  			'message':message
  			},
  			success: function(data, textStatus, jqXHR) {
	  			data = JSON.parse(data);
	  			jQuery('._popin_body').html(data.rPop);
                jQuery('#_popin_title').html(data.rPopTitle);
                if(data.rPopClass != '')
                	jQuery('._popin_box').addClass(data.rPopClass);
                if(jQuery('#_popin').not(':visible')){
	                jQuery('#_popin_loader').removeClass('load1');
                	jQuery('#_popin').fadeIn(500);
                	}
  				},
  			error: function(jqXHR, textStatus, errorThrown) {
	  			alert("error");
	  			}
		});
	},
	reload : function(link, div, datas) {
		message = JSON.stringify(datas);
		jQuery.ajax({
  			type: 'POST',
  			url: link,
  			data: {
	  			'message':message
  			},
  			success: function(data, textStatus, jqXHR) {
                    $('#' + div).html(data);
            },
  			error: function(jqXHR, textStatus, errorThrown) {
	  			alert("error");
	  		}
		});
	},
	callback : function(link, datas, fn_callback) {
		message = JSON.stringify(datas);
		jQuery.ajax({
  			type: 'POST',
  			url: link,
  			data: {
	  			'message':message
  			},
  			success: function(data, textStatus, jqXHR) {
	  			eval(fn_callback).callback(data);
  				},
  			error: function(jqXHR, textStatus, errorThrown) {
	  			alert("error");
	  			}
		});
	},
    order : function(link, datas, fn_callback) {
		message = JSON.stringify(datas);
		jQuery.ajax({
  			type: 'POST',
  			url: link,
  			data: {
	  			'message':message
  			},
  			success: function(data, textStatus, jqXHR) {
	  			eval(fn_callback).order(data);
  				},
  			error: function(jqXHR, textStatus, errorThrown) {
	  			alert("error");
	  			}
		});
	},
  change_uri : function(link, datas){
	  message = JSON.stringify(datas);
    jQuery.ajax({
  			type: 'POST',
  			url: link,
  			data: {
	  			'message':message
  			},
  			success: function(data, textStatus, jqXHR) {
          data = JSON.parse(data);
	  			window.history.pushState({foo:data.title},data.title, data.url);
  				},
  			error: function(jqXHR, textStatus, errorThrown) {
	  			alert("error");
	  			}
		});
	},
};
jQuery(document).on('click','#_popin_abort',function(){
	jQuery('#_popin').fadeOut(500).removeClass('alerte').removeClass('success').removeClass('notice');
	return false;
});
