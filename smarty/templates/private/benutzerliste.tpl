<div class="post">
  <h2 class="title"><a href="#">Benutzerliste</a></h2>
  <div class="entry">
    {if isset($anzahlpersonen)}
    <p align="center">
      Es wurden {$anzahlpersonen} Personen erfolgreich in die Datenbank eingetragen!
    </p>
    {/if}
    <table border='0' align="center">
      <tr>
	<th>Name</th>
	<th>Username</th>
	<th>Rolle</th>
	<th>Pwd Reset</th>
	<th>L&ouml;schen</th>
	<th>Bearbeiten</th>
      </tr>
      {foreach $benutzerliste as $user}
      <tr class='{cycle values="odd,even"}'>
      	<td>
	  {$user->getName()|escape:html} {$user->getNachname()|escape:html}
	</td>
	<td>
	  {$user->getUser()|escape:html}
	</td>
	<td>
	  {$rollenliste[$user->getRolle()]|escape:html}
	</td>
	{if $user->getUser() == "admin"}
	<td align="center">
	  <a href="index.php?page=private.resetPasswd&id={$user->getIdentNumber()}">
	    <img style="border:none" src="images/arrow_refresh.png" alt="Passwort reset" />
	  </a>
	</td>
	<td>
	</td>
	<td align="center">
	  <a href="index.php?page=private.newUser&id={$user->getIdentNumber()}">
	    <img style="border:none" src="images/pencil.png" alt="Bearbeiten" />
	  </a>
	</td>
	{else}
	<td align="center">
	  <a href="index.php?page=private.resetPasswd&id={$user->getIdentNumber()}">
	    <img style="border:none" src="images/arrow_refresh.png" alt="Passwort reset" />
	  </a>
	</td>
	<td align="center">
	  <a href="index.php?page=private.benutzerliste&id={$user->getIdentNumber()}">
	    <img style="border:none" src="images/delete.png" alt="L&ouml;schen" />
	  </a>
	</td>
	<td align="center">
	  <a href="index.php?page=private.newUser&id={$user->getIdentNumber()}">
	    <img style="border:none" src="images/pencil.png" alt="Bearbeiten" />
	  </a>
	</td>
	{/if}
      </tr>
      {/foreach}
    </table>
    <p align="center"><a href="index.php?page=private.newUser">Neuen Benutzer erstellen</a></p>
  </div>
</div>
