function passwd()
{
    $('.result').empty();
    data = $('form[name="passwort"]').serialize();
    $.ajax({
	type: "post",
	url: "./index.php?page=private.ajax.pwdChange",
	data: data,
	dataType: "json",
	cache: false,
	success: function(msg){
	    if (msg.error == -1)
	    {
		$('.result').html(msg.html);
	    }
	    else
	    {
		$('.result').html(msg.html);
		$('input[name="oldPassword"]').value("");
		$('input[name="newPassword1"]').value("");
		$('input[name="newPassword2"]').value("");
	    }
	}

    });
    return 0;
}