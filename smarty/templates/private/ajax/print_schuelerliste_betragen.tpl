<table width="100%" border="0">
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
    <td align="center">
      {if isset($betragenliste[$schueler->getIdentNumber()])}
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
<a href="?page=private.getBetragenPrint&vorstandnummer={$vorstandnummer}" target="_blank">Diese Ansicht drucken</a>
</p>

