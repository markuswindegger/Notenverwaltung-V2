function benutzervalidate()
{

    $(".input_error").empty();
    var error = 0;
    if(!$('input[name="name"]').val())
    {
	++error;
	$('#name_error').html("Bitte einen gültigen Namen eingeben");
    }
    if(!$('input[name="nachname"]').val())
    {
	++error;
	$('#nachname_error').html("Bitte einen gültigen Nachnamen eingeben");
    }
    if(!$('input[name="benutzername"]').val())
    {
	++error;
	$('#benutzername_error').html("Bitte einen gültigen Benutzernamen eingeben");
    }
    else
    {
	if(!$('input[name="id"]').val())
	    {
		$.ajax({
			   url: 'index.php?page=private.ajax.usertest', 
			   data: 'username='+$('input[name="benutzername"]').val(), 
			   success: function(data) {
			       if(data == "gefunden")
			       {
				   ++error;
				   $('#benutzername_error').html("Dieser Benutzername wird schon von einem anderem Benutzer verwendet!");
			       }
			   },
			   dataType: "html",
			   type: "POST"
		      });
	    }
    }
    if($('select[name="rolle"]').val() == -1)
    {
	++error;
	$('#rolle_error').html("Bitte w&auml;hlen Sie eine Rolle aus!");
    }

    if(error == 0)
    {
	$('input[name="benutzername"]').removeAttr("disabled");
	return true;
    }
    return false;
}


function benutzerval()
{
		$.ajax({
			   url: 'index.php?page=private.ajax.usertest', 
			   data: 'username='+$('input[name="benutzername"]').val(), 
			   success: function(data) {
			       if(data == "gefunden")
			       {
				   $('#benutzername_error').html("Dieser Benutzername wird schon von einem anderem Benutzer verwendet!");
				   $('input[type="submit"]').attr("disabled", "disabled");
			       }
			       else
			       {
				   $('#benutzername_error').html("");
				   $('input[type="submit"]').removeAttr("disabled");
			       }
			   },
			   dataType: "html",
			   type: "POST"
		      });  


}
