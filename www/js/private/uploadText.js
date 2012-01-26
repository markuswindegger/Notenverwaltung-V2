$().ready(function() {
	      $('textarea.tinymce').tinymce({
						// Location of TinyMCE script
						script_url : 'js/tiny_mce/tiny_mce.js',
						
						// General options
						theme : "advanced",
						plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
						
						// Theme options
						theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,fortselect,fontselect,fontsizeselect",
						theme_advanced_buttons2 : "cut,copy,paste,|,blockquote,|,cleanup,code,|,insertdate,inserttime,preview",
						theme_advanced_buttons3 : "sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
						theme_advanced_buttons4 : "visualchars,nonbreaking",
						theme_advanced_toolbar_location : "top",
						theme_advanced_toolbar_align : "left",
						theme_advanced_statusbar_location : "bottom",
						theme_advanced_resizing : true,
						
						// Example content CSS (should be your site CSS)
						content_css : "style.css",
						
						// Drop lists for link/image/media/template dialogs
						template_external_list_url : "lists/template_list.js",
						external_link_list_url : "lists/link_list.js",
						external_image_list_url : "lists/image_list.js",
						media_external_list_url : "lists/media_list.js",
						
						// Replace values for the template plugin
						template_replace_values : {
						    username : "Some User",
						    staffid : "991234"
						}
					    });
	      $("#tinymce > body").addClass('text');
	      $('input[name="datum"]').datepicker(
		  {
		      dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
		      monthNames: ['Jänner', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
		      dateFormat: "dd.mm.yy",
		      showOn: "button",
		      buttonImage: "../../images/data.png",
		      buttonImageOnly: true
		  }
		  
	      );
	      $('input[name="datum"]').attr("disabled", "disabled");
	      
	      
	      
	  }
	 );


function validate()
{

    $(".input_error").empty();
    var error = 0;
    if(!$('input[name="titel"]').val())
    {
	++error;
	$('#titel_error').html("Bitte einen gültigen Titel eingeben");
    }
    if($('textarea[name="beschreibung"]').val() == "")
    {
	++error;
	$('#beschreibung_error').html("Bitte gültige Beschreibung eingeben");
    }
    if($('textarea[name="text"]').val() == "")
    {
	++error;
	$('#text_error').html("Bitte einen gültigen Text eingeben");
    }
    if(error == 0)
    {
	return true;
    }
    return false;
}

function validateNewsletter()
{
    $(".input_error").empty();
    var error = 0;
    if(!$('input[name="betreff"]').val())
    {
	++error;
	$('#betreff_error').html("Bitte einen gültigen Betreff eingeben");
    }
    if($('textarea[name="text"]').val() == "")
    {
	++error;
	$('#text_error').html("Bitte einen gültigen Newslettertext eingeben");
    }
    if(error == 0)
    {
	return true;
    }
    return false;
}


function validateNews()
{
    $(".input_error").empty();
    var error = 0;
    if($('textarea[name="beschreibung"]').val() == "")
    {
	++error;
	$('#beschreibung_error').html("Bitte gültige Beschreibung eingeben");
    }
    if(!$('input[name="zeit"]').val() || !zeitval($('input[name="zeit"]').val()))
    {
	++error;
	$('#zeit_error').html("Bitte eine gültige Uhrzeit eingeben");
    }
    if(!$('input[name="datum"]').val())
    {
	++error;
	$('#datum_error').html("Bitte ein gültiges Datum eingeben");
    }
    if(error == 0)
    {
	$('input[name="datum"]').removeAttr("disabled");
	return true;
    }
    return false;
}

function zeitval(zeittime)
{
    var zuig = zeittime.split(":");
    if(zuig.length == 2 && parseInt(zuig[0]) < 24 && parseInt(zuig[0]) >= 0 && parseInt(zuig[1]) < 59 && parseInt(zuig[1]) >= 0)
    {
	return true;
    }
    return false;
}
