<form action="index.php?page=private.doUploadNoten" method="post">
  <table width="100%" border="0">
    <tr>
      <th>
	Name
      </th>
      {foreach $fachliste as $fach}
      <th>
	{$fach->getName()} {$fachtypliste[$fach->getFachtypnummer()]}*
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
	<input type="text" name="{$schueler->getIdentNumber()}_{$fach->getIdentNumber()}" size="10%" 
	{if isset($notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()])}
	value="{$notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()]->getNote()}"
	{/if}
	/>
      </td>
      {/foreach}
      {if $absenzen == 1}
      <td align="center">
	<input type="text" name="{$schueler->getIdentNumber()}" size="10%" 
	{if isset($absenzliste[$schueler->getIdentNumber()])}
	value="{$absenzliste[$schueler->getIdentNumber()]->getAbsenzen()}"
	{/if}
       />
      </td>
      {/if}
    </tr>
    {/foreach}
  </table>
  {foreach $fachliste as $fach}
  <input type="hidden" name="fach[]" value="{$fach->getIdentNumber()}" />
  {/foreach}
  <input type="hidden" name="klasse" value="{$klasse->getIdentNumber()}" />
  <input type="submit" name="Noten eintragen" value="Noten eintragen" align="center"/>
</form>
<p style="margin-top: 3em">
* Geben Sie bitte hier nur <u>GANZE</u> Noten von <b>1 bis 10</b> ein. F&uuml;r nicht klassifiziert bitte ein <b>n.k.</b> eintragen. Auch ein <b>?</b> ist m&ouml;glich, falls Sie sich der Note noch nicht sicher sind.
</p>