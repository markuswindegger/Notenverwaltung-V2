<div class="post">
  <h2 class="title"><a href="#">Willkommen im NVS 2.2</a></h2>
  <div class="entry">
    {if $user->getLogin() == FALSE}
    {if $loginerror}
    <p class='error'>Zugangsdaten ung&uuml;ltig!</p>
    {/if}
    <form action='index.php?page=doLogin' method="post">
      <p style='padding-left:2em;padding-right:2em'>Benutzername<br />
	<input type='text' name='username' style='width:100%' />
      </p>
      <p style='padding-left:2em;padding-right:2em'>
	Passwort<br />
	<input type='password' name='password' style='width:100%' />
      </p>
      <p style='text-align:center'><button type='submit' name='login'>Login</button></p>
    </form>
    {else}
    <p>
      Sie haben sich soeben in das Notenverwaltungssystem der GOB Bozen eingeloggt.<br />
      Hier k&ouml;nnen Sie die Noten Ihrer Sch&uuml;ler eingeben, sie sich ausdrucken. Sofern Sie einer Klasse vorstehen, ist es Ihnen auch m&ouml;glich, die Betragensnoten und die unentschuldigten Absenzen einzutragen. 
    </p>
    {/if}
  </div>
</div>
