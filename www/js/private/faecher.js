function faecherrequest()
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
	       url: "./index.php?page=private.ajax.faecherrequest",
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

function faecherlisterequest()
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
	       url: "./index.php?page=private.ajax.faecherlisterequest",
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