<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Notenveraltung GOB Bozen</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="styleprint.css" type="text/css" media="screen" /> 
  </head>
  <body>
    <table width="60%" border="1" align="center">
      <tr>
	<th>
	  Name
	</th>
	{foreach $fachliste as $fach}
	<th>
	  {$fach->getName()} {$fachtypliste[$fach->getFachtypnummer()]}
	</th>
	{/foreach}
	{if $absenzen == 1}
	<th>
	  Absenzen
	</th>
	{/if}
      </tr>
      {foreach $schuelerliste as $schueler}
      <tr class='{cycle values="odd,even"}'>
	<td>
	  {$schueler->getNachname()} {$schueler->getName()}
	</td>
	{foreach $fachliste as $fach}
	<td align="center"
	  {if isset($notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()])}
	  {if $notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()]->getNote() < 6 && $notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()]->getNote() != "?" && $notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()]->getNote() != "n.k."}
		style="color: red"
	  {/if}
	  >
	  {$notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()]->getNote()}
	  {/if}
	</td>
	{/foreach}
	{if $absenzen == 1}
	<td align="center">
	  {if isset($absenzliste[$schueler->getIdentNumber()])}
	    {$absenzliste[$schueler->getIdentNumber()]->getAbsenzen()}
	  {/if}
	</td>
	{/if}
      </tr>
      {/foreach}
    </table>
    <p align="center">
      <a href="javascript:window.print()">Die Notenansicht drucken</a> | <a href="javascript:window.close()">Zur&uuml;ck</a>
    </p>
  </body>
</html>

