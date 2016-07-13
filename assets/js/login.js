$("#btn-login").click(function() {
	if ($("#user_id").val() == "") {
		$("#user_id").focus();
		return;
	}
	if ($("#password").val() == "") {
		$("#password").focus();
		return;
	}
	
	$.post( "/user/checkuser", 
		{ 
			user_id: $("#user_id").val(), 
			password: $("#password").val() 
		}, 
		function( response ) {
			switch(response) {
				case "NOT_EXIST":
					alert('You are not registated.');
					$("#user_id").val("");
					$("#user_id").focus();
					break;
				case "NOT_PASSWORD":
					alert('Password incorrect.');
					$("#password").val("");
					$("#password").focus();
					break;
				case "NOT_ALLOWED":
					alert('You are not allowed.');
					$("#user_id").val("");
					$("#password").val("");
					$("#user_id").focus();
					break;
				case "SUCCEED":
				window.open("/home", "_self");
					break;
				default:
					break;
			}
	});
});
$("body").keypress(function(e){
	if(e.which == 13) 
		$("#btn-login").click();
});
$("#btn-signup").click(function() {
	window.open("/user/signup", "_self");
});