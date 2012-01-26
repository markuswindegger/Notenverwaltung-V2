<div class="post">
  {if $benutzer != null}
  <h2 class="title"><a href="#">Benutzer ändern</a></h2>
  {else}
  <h2 class="title"><a href="#">Benutzer eintragen</a></h2>
  {/if}
  <div class="entry">
    {if isset($errormsg)}
    <p style="color: red;">
      {$errormsg}    
    </p>
    {/if}
    <form action="index.php?page=private.insertUser" method="post">
    <p>
      Vorname:<br />
      <input type="text" name="name" style="width:100%" 
	     {if $benutzer != null}
	     value="{$benutzer->getName()|escape:html}"
	     {/if}
	     />
      <p class="input_error" id="name_error" style="color:red"></p>
    </p>
    <p>
      Nachname:<br />
      <input type="text" name="nachname" style="width:100%"
	     {if $benutzer != null}
	     value="{$benutzer->getNachname()|escape:html}"
	     {/if}
	     />
    <p class="input_error" id="nachname_error" style="color:red"></p>
    </p>
    <p>
      Benutzername:<br />
      <input type="text"  name="benutzername" style="width:100%"
	     {if $benutzer != null}
	     value="{$benutzer->getUser()|escape:html}"
	     disabled="disabled"
	     {/if}
	     onChange="benutzerval()"/>
    <p class="input_error" id="benutzername_error" style="color:red"></p>
    <p>
      Rolle:<br />
      <select name="rolle">
	<option value="-1">Bitte Rolle w&auml;hlen</option>
	{foreach key=nummer item=rolle from=$rollenliste}
	<option value="{$nummer}"
	  {if $benutzer != null}
	      {if $nummer == $benutzer->getRolle()}
	      selected="selected"
	      {/if}
          {/if}
		>
	  {$rolle}
	</option>
	{/foreach}
      </select>
    <p class="input_error" id="rolle_error" style="color:red"></p>

    </p>
    <p style="text-align:center">
      {if $benutzer != null}
      <input type="hidden" name="id" value="{$benutzer->getIdentNumber()}" />
      {/if}
      {if $benutzer != null}
      <input type="submit" onClick="return benutzervalidate()" value="Ändern"/>
      {else}
      <input type="submit" onClick="return benutzervalidate()" value="Eintragen" disabled="disabled"/>
      {/if}
    </p>
    </form>
  </div>
</div>
