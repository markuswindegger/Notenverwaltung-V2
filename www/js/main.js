function hide_zuig(string)
{
    if($("#"+string).css("display") == "none")
    {
	$("#"+string).css("display", "block");
    }
    else
    {
	$("#"+string).css("display", "none");
    }
    return false;
}