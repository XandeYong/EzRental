$(document).ready(function () {
  
	$(".btn-ban").click(function (e) { 
		var id = $(this).attr('account-id');
		$("#accountID").val(id);
	});

});