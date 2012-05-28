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
    <th>
      Betragen
    </th>
    <th>
      Unentschuldigte Absenzen
    </th>
  </tr>
  {foreach $schuelerliste as $schueler}
  <tr class='{cycle values="odd,even"}'>
    <td>
      {$schueler->getNachname()} {$schueler->getName()}
    </td>
    <td align="center"
      {if isset($betragenliste[$schueler->getIdentNumber()])}
      {if $betragenliste[$schueler->getIdentNumber()] < 6}
      style="color: red"
      {/if}
      >
      {$betragenliste[$schueler->getIdentNumber()]->getBetragen()}
      {/if}
    </td>
    <td align="center">
      {if isset($betragenliste[$schueler->getIdentNumber()])}
      {$betragenliste[$schueler->getIdentNumber()]->getAbsenzen()}
      {/if}
    </td>
  </tr>
  {/foreach}
</table>
    <p align="center">
      <a href="javascript:window.print()">Diese Ansicht drucken</a> | <a href="javascript:window.close()">Zur&uuml;ck</a>
    </p>

</body>
</html>
