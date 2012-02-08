//$(document).ready(function () {
	setInterval('loginupdate()',30000);
	//loginupdate();
//}); // for checking future logout ! code checks current permissions

function loginupdate() {
	$.ajax({
		url:'/user.php',
		data:'action=checkLogged',
		success:function(a) {
			//alert(a);
			if(a != '1') setTimeout("window.location.reload()", 1);
		}
	});
}
