function schuelerrequest()
{
    $('.schueler').empty();
    $('.error').empty();
    if($('select[name="vorstandnummer"]').val() == -1)
    {
	return 0;
    }
    data = $('select[name="vorstandnummer"]').serialize();
    $.ajax({
	       type: "post",
	       url: "./index.php?page=private.ajax.printBetragen_Schueler",
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