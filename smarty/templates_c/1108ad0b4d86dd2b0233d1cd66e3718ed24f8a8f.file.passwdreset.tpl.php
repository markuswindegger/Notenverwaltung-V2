<?php /* Smarty version Smarty3-RC3, created on 2011-04-15 17:54:07
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates//private/passwdreset.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20597988874da86a1f5ce1e4-73114935%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1108ad0b4d86dd2b0233d1cd66e3718ed24f8a8f' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates//private/passwdreset.tpl',
      1 => 1302881738,
    ),
  ),
  'nocache_hash' => '20597988874da86a1f5ce1e4-73114935',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/modifier.escape.php';
?><div class='post'>
  <h2 class='title'><a href='#'>Passwort &auml;ndern</a></h2>
  <div class='entry'>
       Das Passwort von <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('autor')->value->getName(),'html');?>
 <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('autor')->value->getNachname(),'html');?>
 wurde ge&auml;ndert. Bitte geben Sie dieses sofort an den betreffenden Benutzer weiter.<br />
       Gesetzes Passwort: <?php echo $_smarty_tpl->getVariable('newpassword')->value;?>

  </div>
</div>
