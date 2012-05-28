function schuelerrequest()
{
    $('.schueler').empty();
    $('.error').empty();
    if($('select[name="klassennummer"]').val() == -1 || $('select[name="zeitraumnummer"]').val() == -1)
    {
	return 0;
    }
    data = $('select[name="klassennummer"]').serialize()+"&"+$('select[name="zeitraumnummer"]').serialize();
    window.open("./index.php?page=private.ajax.export&"+data);
    return 0;
}