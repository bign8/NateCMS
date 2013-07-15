setInterval('loginupdate()',30000);

function loginupdate() {
	$.ajax({
		url:'/user.php',
		data:'action=checkLogged',
		success:function(a) {
			if(a != '1') setTimeout("window.location.reload()", 1);
		}
	});
}