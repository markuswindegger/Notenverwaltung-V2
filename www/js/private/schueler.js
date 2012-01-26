function schuelerrequest()
{
    $('.schueler').empty();
    $('.error').empty();
    if($('select[name="klassennummer"]').val() == -1 || $('select[name="zeitraumnummer"]').val() == -1)
    {
	return 0;
    }
    data = $('select[name="klassennummer"]').serialize()+"&"+$('select[name="zeitraumnummer"]').serialize();
    $.ajax({
	       type: "post",
	       url: "./index.php?page=private.ajax.schuelerrequest",
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

function klassenrequest()
{
    $('.schueler').empty();
    $('.error').empty();
    if($('select[name="zeitraumnummer"]').val() == -1)
    {	
        return 0;
    }
    data = $('select[name="zeitraumnummer"]').serialize();
    $.ajax({
               type: "post",
               url: "./index.php?page=private.ajax.klassenrequest",
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
                       $('select[name="klassennummer"]').html(msg.html);
                   }
               }

           });
    return 0;
}