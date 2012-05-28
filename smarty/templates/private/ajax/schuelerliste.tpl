<h3>{$klasse->getStufe()}. {$klasse->getFachrichtung()} {$klasse->getZug()}</h3>
<table border='0' align="center">
  <tr>
    <th>Nachname</th>
    <th>Name</th>
  </tr>
  {foreach $schuelerliste as $schueler}
  <tr class='{cycle values="odd,even"}'>
    <td>{$schueler->getNachname()|escape:html}</td>
    <td>{$schueler->getName()|escape:html}</td>
  </tr>
  {/foreach}
</table>
