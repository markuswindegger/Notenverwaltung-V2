<form action="index.php?page=private.doUploadBetragen" method="post">
  <table width="100%" border="0">
    <tr>
      <th>
	Name
      </th>
      <th>
	Betragen*
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
	<input type="text" name="betr_{$schueler->getIdentNumber()}" size="10%" 
	{if isset($betragenliste[$schueler->getIdentNumber()])}
	value="{$betragenliste[$schueler->getIdentNumber()]->getBetragen()}"
	{/if}
	 />
      </td>
      <td align="center">
	<input type="text" name="abs_{$schueler->getIdentNumber()}" size="10%" 
	{if isset($betragenliste[$schueler->getIdentNumber()])}
	value="{$betragenliste[$schueler->getIdentNumber()]->getAbsenzen()}"
	{/if}
	/>	
      </td>
    </tr>
    {/foreach}
  </table>
  <input type="hidden" name="vorstandnummer" value="{$vorstandnummer}" />
  <input type="submit" name="Noten eintragen" value="Betragen eintragen" align="center"/>
</form>

<p style="margin-top: 3em">
* Geben Sie bitte hier nur <u>GANZE</u> Noten von <b>1 bis 10</b> ein.
</p>
