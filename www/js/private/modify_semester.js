$().ready(function() 
	  {
	      $('input[name="freidatum"]').datepicker(
		  {
		      dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
		      monthNames: ['Jänner', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
		      dateFormat: "dd.mm.yy",
		      showOn: "button",
		      buttonImage: "../../images/data.png",
		      buttonImageOnly: true
		  }
		  
	      );
	      $('input[name="sperrdatum"]').attr("disabled", "disabled");
	      $('input[name="freidatum"]').attr("disabled", "disabled");
	      var array = $('input[name="freidatum"]').val().split(".");
	      var tag = array[0];
	      var monat = array[1];
	      var jahr = array[2];
	      $('input[name="sperrdatum"]').datepicker(
		  {
		      dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
		      monthNames: ['Jänner', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
		      dateFormat: "dd.mm.yy",
		      showOn: "button",
		      buttonImage: "../../images/data.png",
		      buttonImageOnly: true,
		      minDate: new Date(jahr, monat-1, tag)
		  }		  
	      );
	  }
	 );

function setSperre()
{
    var array = $('input[name="freidatum"]').val().split(".");
    var tag = array[0];
    var monat = array[1];
    var jahr = array[2];
    $('input[name="sperrdatum"]').datepicker("destroy");
    $('input[name="sperrdatum"]').val("");
    $('input[name="sperrdatum"]').datepicker(
	{
	    dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
	    monthNames: ['Jänner', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
	    dateFormat: "dd.mm.yy",
	    showOn: "button",
	    buttonImage: "../../images/data.png",
	    buttonImageOnly: true,
	    minDate: new Date(jahr, monat-1, tag)
	}
	
    );
    return;
}

function freigeben()
{
    $('input[name="sperrdatum"]').removeAttr("disabled");
    $('input[name="freidatum"]').removeAttr("disabled");
    return true;
}
