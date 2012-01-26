<h3>F&auml;cher f&uuml;r {$semester->getSemester()}. Semester {$semester->getSchuljahr()}</h3>
<table align="center" border="0" width="100%">	
  <tr>
    <th>
      Klasse
    </th>
    <th>
      Fach
    </th>
    <th>
      Lehrer
    </th>
    <th>
      Fachtyp
    </th>
    <th>
     Absenzeneingabe
    </th>
    <th>
      &nbsp;
    </th>
  </tr>
  {foreach $faecherliste as $fach}
  <tr class='{cycle values="odd,even"}'>
    <td>
      {$klassenliste[$fach->getKlassennummer()]->getStufe()} {$klassenliste[$fach->getKlassennummer()]->getFachrichtung()} {$klassenliste[$fach->getKlassennummer()]->getZug()}
    </td>
    <td>
      {$fach->getName()}
    </td>
    <td>
      {$lehrerliste[$fach->getLehrernummer()]->getName()} {$lehrerliste[$fach->getLehrernummer()]->getNachname()}
    </td>
    <td>
      {$fachtypliste[$fach->getFachtypnummer()]}
    </td>
    <td>
      {if $fach->getAbsenzen() == 1}
      Ja
      {else}
      Nein
      {/if}
    </td>
    <td>
      <a href="?page=private.faecherliste&fach={$fach->getIdentNumber()}"><img style="border:none" src="images/delete.png" alt="Fach l&ouml;schen" /></a>
    </td>
  </tr>
  {foreachelse}
  <tr>
    <th colspan="6">
      Es wurden keine F&auml;cher diesem Semester zugeteilt!!!!
    </th>
  </tr>
  {/foreach}
</table>
