
var _Ajaxflo = {

	reload : function(link, div, datas) {
		alert(div);
		jQuery.ajax({
  			type: 'POST',
  			url: link,
  			data: {
	  			datas
  			},
  			success: function(data, textStatus, jqXHR) {
                    $('#' + div).html(data);
            },
  			error: function(jqXHR, textStatus, errorThrown) {
	  			alert("error");
	  		}
		});
	}

};
