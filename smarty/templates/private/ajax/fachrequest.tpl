
<td>Fach:</td>
<td>
  <select name="fachnummer" onchange="schuelerrequest()">
    <option value="-1">Bitte Fach ausw&auml;hlen</option>
    {foreach $fachliste as $fach}
    <option value="{$fach->getIdentNumber()}">{$fach->getName()}</option>
    {/foreach}
    </select>
</td>

