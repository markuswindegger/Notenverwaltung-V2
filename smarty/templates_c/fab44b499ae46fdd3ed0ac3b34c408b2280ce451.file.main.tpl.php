<?php /* Smarty version Smarty3-RC3, created on 2012-01-24 22:08:23
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10383690134f1f1dc7a58d53-20082607%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fab44b499ae46fdd3ed0ac3b34c408b2280ce451' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/main.tpl',
      1 => 1327439186,
    ),
  ),
  'nocache_hash' => '10383690134f1f1dc7a58d53-20082607',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
    
    <?php  $_smarty_tpl->tpl_vars['script'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('js_scripts')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['script']->key => $_smarty_tpl->tpl_vars['script']->value){
?>
    <script type="text/javascript" src="js/<?php echo $_smarty_tpl->tpl_vars['script']->value;?>
"></script>
    <?php }} ?>
    
    <?php  $_smarty_tpl->tpl_vars['style'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('stylesheets')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['style']->key => $_smarty_tpl->tpl_vars['style']->value){
?>
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
" type="text/css" media="screen" />
    <?php }} ?>
    
    
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
	<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('bl_errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
?>
	<?php echo $_smarty_tpl->tpl_vars['module']->value;?>

	<?php }} ?>
	<?php  $_smarty_tpl->tpl_vars['modulo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('bl_content')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['modulo']->key => $_smarty_tpl->tpl_vars['modulo']->value){
?>
	<?php echo $_smarty_tpl->tpl_vars['modulo']->value;?>

	<?php }} ?>
	
	
	<div class="post">
	  <div class="entry">
	    <blockquote>
	      <?php echo $_smarty_tpl->getVariable('zitat')->value['text'];?>

	    </blockquote>
	    <p style="text-align:center"><?php echo $_smarty_tpl->getVariable('zitat')->value['autor'];?>
</p>
	  </div>
	</div>
      </div>
      <!-- end #content -->
      <div id="sidebar">
	<ul>
	  <?php if ($_smarty_tpl->getVariable('user')->value->getLogin()){?> 
	  <li>
	    <h2>Infos</h2>
	    <p>Eingeloggt als <b><?php echo $_smarty_tpl->getVariable('user')->value->getName();?>
 <?php echo $_smarty_tpl->getVariable('user')->value->getNachname();?>
</b></p>
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
	  <?php if ($_smarty_tpl->getVariable('user')->value->getRolle()==1){?>
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
	  <?php }elseif($_smarty_tpl->getVariable('user')->value->getRolle()==2||$_smarty_tpl->getVariable('user')->value->getRolle()==3){?>
	  <?php if ($_smarty_tpl->getVariable('zeitraum')->value==null){?>
	  <li>
	    <h2>Noten verwalten</h2>
	    <ul>
	      <li>
		Momentan keine Eingabe m&ouml;glich.
	      </li>
	    </ul>
	  </li>
	  <?php }else{ ?>
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
	  <?php if ($_smarty_tpl->getVariable('user')->value->getRolle()==3){?>
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
	  <?php }?>
	  <?php }?>
	  <?php }elseif($_smarty_tpl->getVariable('user')->value->getRolle()==4){?>
	  <li>
	    <h2>Klassen exportieren</h2>
	    <ul>
	      <li>
		<a href="./index.php?page=private.prepareExport">Export Klassen</a>
	      </li>
	    </ul>
	  </li>
	  <?php }?>
	  <?php }else{ ?>
	  <li>
	    <h2>Login</h2>
	    <ul>
	      <?php if ($_smarty_tpl->getVariable('loginerror')->value){?>
	      <p class='error'>Zugangsdaten ung&uuml;ltig!</p>
	      <?php }?>
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
	  <?php }?>
	</ul>
      </div>
      <!-- end #sidebar -->
      <div style="clear: both;">&nbsp;</div>
    </div>
    <!-- end #page -->
    <div id="footer">
      <p>&copy; <?php echo smarty_modifier_date_format(time(),"%Y");?>
 <a href="http://www.mowiso.com">MoWiSo</a>. Design by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a> and modified by <a href="http://www.windegger.org">MaWi</a>.</p>
    </div>
    <!-- end #footer -->
  </body>
</html>
