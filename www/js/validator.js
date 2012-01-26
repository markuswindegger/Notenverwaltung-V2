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
			   url: 'index.php?page=ajax.usertest', 
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
    if(!$('input[name="email"]').val())
    {
	++error;
	$('#email_error').html("Bitte eine gültige Email-Adresse eingeben");
    }
    if($('textarea[name="beschreibung"]').val() == "")
    {
	++error;
	$('#beschreibung_error').html("Bitte gültige Beschreibung eingeben");
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
			   url: 'index.php?page=ajax.usertest', 
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

function kommentarvalidate()
{
    $(".input_error").empty();
    var error = 0;
    if($('textarea[name="kommentar"]').val() == "")
    {
	++error;
	$('#kommentar_error').html("Bitte gültigen Kommentar eingeben");
    }
    if(error == 0)
    {
	return true;
    }
    return false;
}


function datevalid(date)
{
    var jetzt = new Date();
    if(parseInt(date) > 1900 && parseInt(date) < jetzt.getYear())
    {
	return true;
    }
    return false;
}


function passwdvalidate()
{
    $(".input_error").empty();
    var error = 0;
    if($('input[name="benutzername"]').val() == "")
    {
	++error;
	$('#benutzername_error').html("Bitte gültigen Benutzernamen eingeben");
    }
    if($('input[name="email"]').val() == "")
    {
	++error;
	$('#email_error').html("Bitte gültige Email eingeben");
    }
    if(error == 0)
    {
	return true;
    }
    return false;

}