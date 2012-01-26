<table width="100%" border="0">
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
    <td align="center">
      {if isset($notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()])}
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
<a href="?page=private.getNotenspiegel&fachnummer={$fachnummer}" target="_blank">Die Notenansicht drucken</a>
</p>


