<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : The Fences 
Description: A two-column, fixed-width design for 1024x768 screen resolutions.
Version    : 1.0
Released   : 20100308

-->
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Notenveraltung GOB Bozen</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    
    {foreach $js_scripts as $script}
    <script type="text/javascript" src="js/{$script}"></script>
    {/foreach}
    
    {foreach $stylesheets as $style}
    <link rel="stylesheet" href="{$style}" type="text/css" media="screen" />
    {/foreach}
    
    
  </head>
  <body>
    <div id="logo">
      <h1><a href="#">GOB Bozen</a></h1>
      <p></p>
    </div>
    <hr />
    <!-- end #logo -->
    <div id="header">
      <div id="menu">
	<ul>
	  <li><a href="index.php" class="first">Home</a></li>
	</ul>
      </div>
      <!-- end #menu -->
    </div>
    <!-- end #header -->
    <!-- end #header-wrapper -->
    <div id="page">
      <div id="content">
	{foreach $bl_errors as $module}
	{$module}
	{/foreach}
	{foreach $bl_content as $modulo}
	{$modulo}
	{/foreach}
	
	
	<div class="post">
	  <div class="entry">
	    <blockquote>
	      {$zitat['text']}
	    </blockquote>
	    <p style="text-align:center">{$zitat['autor']}</p>
	  </div>
	</div>
      </div>
      <!-- end #content -->
      <div id="sidebar">
	<ul>
	  {if $user->getLogin()} 
	  <li>
	    <h2>Infos</h2>
	    <p>Eingeloggt als <b>{$user->getName()} {$user->getNachname()}</b></p>
	    <ul>
	      <li>
		<a href="?page=private.home">Private Startseite</a>
	      </li>
	      <li>
		<a href="?page=private.doPwdChange">Passwort &auml;ndern</a>
	      </li>
	      <li>
		<a href="?page=private.doLogout">Logout</a>
	      </li>
	    </ul>
	  </li>
	  {if $user->getRolle() == 1}
	  <li>
	    <h2>System verwalten</h2>
	    <ul>
	      <li>
		<a href="./index.php?page=private.uploadLehrer">Lehrer importieren</a>
	      </li>
	      <li>
		<a href="./index.php?page=private.uploadFaecher">F&auml;cher importieren</a>
	      </li>
	      <li>
		<a href="./index.php?page=private.uploadSchueler">Sch&uuml;ler importieren</a>
	      </li>
	      <li>
		<a href="./index.php?page=private.uploadSchuelerPoppcorn">Sch&uuml;ler aus Poppcorndatei importieren</a>
	      </li>
	      <li>
		<a href="./index.php?page=private.prepareExport">Export Klassen</a>
	      </li>
	      <li>
		<a href="./index.php?page=private.benutzerliste">Benutzerverwaltung</a>
	      </li>
	      <li>
		<a href="./index.php?page=private.schuelerliste">Sch&uuml;lerliste</a>
	      </li>
	      <li>
		<a href="./index.php?page=private.faecherliste">F&auml;cherliste</a>
	      </li>
	      <li>
		<a href="./index.php?page=private.semesterliste">Semesterverwaltung</a>
	      </li>
	    </ul>
	  </li>
	  {else if $user->getRolle() == 2 || $user->getRolle() == 3}
	  {if $zeitraum == null}
	  <li>
	    <h2>Noten verwalten</h2>
	    <ul>
	      <li>
		Momentan keine Eingabe m&ouml;glich.
	      </li>
	    </ul>
	  </li>
	  {else}
	  <li>
	    <h2>Noten verwalten</h2>
	    <ul>
	      <li>
		<a href="./index.php?page=private.insertNoten">Noten eintragen</a>
	      </li>
	      <li>
		<a href="./index.php?page=private.preparePrint">Noten&uuml;bersicht ausdrucken</a>
	      </li>
	    </ul>
	  </li>
	  {if $user->getRolle() == 3}
	  <li>
	    <h2>Klassenvorstand</h2>
	    <ul>
	      <li>
		<a href="./index.php?page=private.insertBetragen">Betragen eintragen</a>
	      </li>
	      <li>
		<a href="./index.php?page=private.printBetragen">Betragen drucken</a>
	      </li>
	    </ul>
	  </li>
	  {/if}
	  {/if}
	  {elseif $user->getRolle() == 4}
	  <li>
	    <h2>Klassen exportieren</h2>
	    <ul>
	      <li>
		<a href="./index.php?page=private.prepareExport">Export Klassen</a>
	      </li>
	    </ul>
	  </li>
	  {/if}
	  {else}
	  <li>
	    <h2>Login</h2>
	    <ul>
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
	    </ul>
	  </li>
	  {/if}
	</ul>
      </div>
      <!-- end #sidebar -->
      <div style="clear: both;">&nbsp;</div>
    </div>
    <!-- end #page -->
    <div id="footer">
      <p>&copy; {$smarty.now|date_format:"%Y"} <a href="http://www.mowiso.com">MoWiSo</a>. Design by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a> and modified by <a href="http://www.windegger.org">MaWi</a>.</p>
    </div>
    <!-- end #footer -->
  </body>
</html>
