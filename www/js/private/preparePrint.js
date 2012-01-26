function notenfachrequest()
{
    $('.schueler').empty();
    $('.fachselect').empty();
    $('.error').empty();
    if($('select[name="klassennummer"]').val() == -1)
    {
	return 0;
    }
    data = $('select[name="klassennummer"]').serialize();
    $.ajax({
	       type: "post",
	       url: "./index.php?page=private.ajax.uploadNoten_Fach",
	       data: data,
	       dataType: "json",
	       cache: false,
	       success: function(msg){
		   if (msg.error == -1)
		   {
		       $('.error').html(msg.html);
		   }
		   else
		   {
		       $('.fachselect').html(msg.html);
		   }
	       }
	       
	   });
    return 0;
}


function schuelerrequest()
{
    $('.schueler').empty();
    $('.error').empty();
    if($('select[name="klassennummer"]').val() == -1 || $('select[name="fachnummer"]').val() == -1 )
    {
	return 0;
    }
    data = $('select[name="fachnummer"]').serialize();
    $.ajax({
	       type: "post",
	       url: "./index.php?page=private.ajax.preparePrint_Schueler",
	       data: data,
	       dataType: "json",
	       cache: false,
	       success: function(msg){
		   if (msg.error == -1)
		   {
		       $('.error').html(msg.html);
		   }
		   else
		   {
		       $('.schueler').html(msg.html);
		   }
	       }
	       
	   });
    return 0;
}