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
    {assign var=tabindex value=1}
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
	tabindex="{$tabindex}"
	 />
      </td>
      {assign var=tabindex value=$tabindex+1}
      <td align="center">
	<input type="text" name="abs_{$schueler->getIdentNumber()}" size="10%" 
	{if isset($betragenliste[$schueler->getIdentNumber()])}
	value="{$betragenliste[$schueler->getIdentNumber()]->getAbsenzen()}"
	{/if}
	tabindex="{$tabindex}"
	/>	
      </td>
      {assign var=tabindex value=$tabindex+1}
    </tr>
    {/foreach}
  </table>
  <input type="hidden" name="vorstandnummer" value="{$vorstandnummer}" />
  <input type="submit" name="Verhalten und Absenzen speichern" value="Verhalten und Absenzen speichern" align="center"/>
</form>
<p style="margin-top: 3em">
* Geben Sie bitte hier nur <u>GANZE</u> Noten von <b>1 bis 10</b> ein.
</p>
<p style="margin-top: 3em">
  <b>WICHTIG!!</b> Zum Speichern unbedingt "Verhalten und Absenzen speichern" dr&uuml;cken!!
</p>
