<?php /* Smarty version Smarty3-RC3, created on 2012-01-25 13:58:00
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20757964574f1ffc580a6d78-59371027%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0af84a69a6ca1ddab94350529df97257cd53f1e5' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/home.tpl',
      1 => 1327445244,
    ),
  ),
  'nocache_hash' => '20757964574f1ffc580a6d78-59371027',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="post">
  <h2 class="title"><a href="#">Willkommen im NVS 2.2</a></h2>
  <div class="entry">
    <?php if ($_smarty_tpl->getVariable('user')->value->getLogin()==false){?>
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
    <?php }else{ ?>
    <p>
      Sie haben sich soeben in das Notenverwaltungssystem der GOB Bozen eingeloggt.<br />
      Hier k&ouml;nnen Sie die Noten Ihrer Sch&uuml;ler eingeben, sie sich ausdrucken. Sofern Sie einer Klasse vorstehen, ist es Ihnen auch m&ouml;glich, die Betragensnoten und die unentschuldigten Absenzen einzutragen. 
    </p>
    <?php }?>
  </div>
</div>
