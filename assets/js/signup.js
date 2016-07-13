$("#btn-submit").click(function() {
	if ($("#user_id").val() == "") {
		$("#user_id").focus();
		return;
	}
	if ($("#password").val() == "") {
		$("#password").focus();
		return;
	}
	if ($("#repassword").val() == "") {
		$("#repassword").focus();
		return;
	}
	
	if ($("#password").val() === $("#repassword").val()) {
		$.post( "/user/register", 
			{ 
				user_id: $("#user_id").val(), 
				password: $("#password").val() 
			}, 
			function( response ) {
				switch(response) {
					case "EXISTED_NAME":
						alert('This user already registed in Pride-Admin.');
						break;
					case "FAILURE":
						alert('Cannot signup to Pride-Admin.');
						break;
					case "SUCCEED":
						window.open("/user/", "_self");
						break;
					default:
						break;
				}
		});
	} else {
		alert("The passwords you entered don't match. Try again!");
		$("#password").val("");
		$("#repassword").val("");
		$("#password").focus();
		return;					
	}
});
$("body").keypress(function(e){
	if(e.which == 13) 
		$("#btn-submit").click();
});