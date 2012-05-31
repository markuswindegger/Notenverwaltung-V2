<div class="post">
  <h2 class="title"><a href="#">Betragen/Verhalten</a></h2>
  <div class="entry">
    {if isset($fehlermsg) && $fehlermsg != NULL}
    <p style="color: red" align="center">
      {$fehlermsg}
    </p>
    {/if}
    {if isset($message) && $message != NULL}
    <p align="center">
      {$message}
    </p>
    {/if}
    <form action="#" method="post">
      <table width="100%" border="0">
	<tr>
	  <td>
	    Klasse aussuchen:
	  </td>
	  <td>
	    <select name="vorstandnummer" onchange="schuelerrequest()">
	      <option value="-1" selected="selected">Bitte Klasse ausw&auml;hlen</option>
	      {foreach $vorstandliste as $vorstand}
	      <option value="{$vorstand->getIdentNumber()}">{$klassenliste[$vorstand->getKlassennummer()]->getStufe()}. {$klassenliste[$vorstand->getKlassennummer()]->getFachrichtung()} {$klassenliste[$vorstand->getKlassennummer()]->getZug()}</option>
	      {/foreach}
	    </select>
	  </td>
	</tr>
      </table>
      <p class="error" style="color: red">	
      </p>
    </form>
    <div class="schueler">
    </div>
  </div>
</div>
