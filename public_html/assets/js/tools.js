/**
 *
 * Générateur de mot de passe
 *
 **/
 function getRandomNum(lbound, ubound) {
	return (Math.floor(Math.random() * (ubound - lbound)) + lbound);
	}
function getRandomChar() {
	var numberChars = "0123456789";
	var lowerChars = "abcdefghijklmnopqrstuvwxyz";
	var upperChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var otherChars = "!@#$%&*-_=+:.?";
	var charSet = 20;
	charSet += numberChars;
	charSet += lowerChars;
	charSet += upperChars;
	charSet += otherChars;
	return charSet.charAt(getRandomNum(0, charSet.length));
	} 
 function is_email(email) {
	var re = /^(([^<>()[\]\\.,éàèùâêîôûäëïöüÿ;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
} 
var _tools = {
 	getPassword : function(length, extraChars) {
		if (typeof length == "undefined") var length = 10;
		if (typeof extraChars == "undefined") var extraChars = 20;
		var rc = "";
		if (length > 0)
			rc = rc + getRandomChar(extraChars);
		for (var idx = 1; idx < length; ++idx) {
			rc = rc + getRandomChar(extraChars);
			}
		return rc;
		}, 
	required : function(form){	
		 var error = 0;
		$('#' + form + ' input , #'+form+ ' textarea').each(function(){
			$(this).removeClass('bg_error');
			if($(this).hasClass('_required') && $(this).val() === ''){
				if($(this).attr('id') === 'password'){
					if($(this).val() === '' && $('#old_pass').val() === ''){
						var name = $(this).attr('id');
						$(this).addClass('bg_error');
						$('#error_' + name).show();
						error = 1;
						}
					}
				else{
					var name = $(this).attr('id');
					$(this).addClass('bg_error');					
					$('#error_' + name).show();
					error = 1;
					}
				}
			});
		if(error == 1)
			$('.error_form').show();
		return error; 
		},
 	format_email : function(form){
		var error = 0;
		$('#' + form + ' input').each(function(){
			if($(this).hasClass('_format_email') && $(this).val() !== '' && !is_email($(this).val())){
				$(this).addClass('bg_error');
				var name = $(this).attr('id');
				$('#error_format_' + name).show();
				error = 1;
				}
			});
		if(error == 1)
			$('.error_form').show();
		return error;
		}, 
	};
