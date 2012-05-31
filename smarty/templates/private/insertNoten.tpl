<div class="post">
  <h2 class="title"><a href="#">Notenblatt</a></h2>
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
	    <select name="klassennummer" onchange="notenfachrequest()">
	      <option value="-1" selected="selected">Bitte Klasse ausw&auml;hlen</option>
	      {foreach $klassenliste as $klasse}
	      <option value="{$klasse->getIdentNumber()}">{$klasse->getStufe()}. {$klasse->getFachrichtung()} {$klasse->getZug()}</option>
	      {/foreach}
	    </select>
	  </td>
	</tr>
	<tr class="fachselect">
	</tr>
      </table>
      <p class="error" style="color: red">	
      </p>
    </form>
    <div class="schueler">
    </div>
  </div>
</div>
