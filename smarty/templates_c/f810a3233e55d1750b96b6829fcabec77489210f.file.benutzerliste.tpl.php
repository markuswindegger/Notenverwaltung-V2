<?php /* Smarty version Smarty3-RC3, created on 2012-01-25 15:50:56
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/benutzerliste.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6267814054de77d2a6678c3-99385467%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f810a3233e55d1750b96b6829fcabec77489210f' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/benutzerliste.tpl',
      1 => 1309268812,
    ),
  ),
  'nocache_hash' => '6267814054de77d2a6678c3-99385467',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/function.cycle.php';
if (!is_callable('smarty_modifier_escape')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/modifier.escape.php';
?><div class="post">
  <h2 class="title"><a href="#">Benutzerliste</a></h2>
  <div class="entry">
    <?php if (isset($_smarty_tpl->getVariable('anzahlpersonen')->value)){?>
    <p align="center">
      Es wurden <?php echo $_smarty_tpl->getVariable('anzahlpersonen')->value;?>
 Personen erfolgreich in die Datenbank eingetragen!
    </p>
    <?php }?>
    <table border='0' align="center">
      <tr>
	<th>Name</th>
	<th>Username</th>
	<th>Rolle</th>
	<th>Pwd Reset</th>
	<th>L&ouml;schen</th>
	<th>Bearbeiten</th>
      </tr>
      <?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('benutzerliste')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
?>
      <tr class='<?php echo smarty_function_cycle(array('values'=>"odd,even"),$_smarty_tpl->smarty,$_smarty_tpl);?>
'>
      	<td>
	  <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->getName(),'html');?>
 <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->getNachname(),'html');?>

	</td>
	<td>
	  <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->getUser(),'html');?>

	</td>
	<td>
	  <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('rollenliste')->value[$_smarty_tpl->getVariable('user')->value->getRolle()],'html');?>

	</td>
	<?php if ($_smarty_tpl->getVariable('user')->value->getUser()=="admin"){?>
	<td align="center">
	  <a href="index.php?page=private.resetPasswd&id=<?php echo $_smarty_tpl->getVariable('user')->value->getIdentNumber();?>
">
	    <img style="border:none" src="images/arrow_refresh.png" alt="Passwort reset" />
	  </a>
	</td>
	<td>
	</td>
	<td align="center">
	  <a href="index.php?page=private.newUser&id=<?php echo $_smarty_tpl->getVariable('user')->value->getIdentNumber();?>
">
	    <img style="border:none" src="images/pencil.png" alt="Bearbeiten" />
	  </a>
	</td>
	<?php }else{ ?>
	<td align="center">
	  <a href="index.php?page=private.resetPasswd&id=<?php echo $_smarty_tpl->getVariable('user')->value->getIdentNumber();?>
">
	    <img style="border:none" src="images/arrow_refresh.png" alt="Passwort reset" />
	  </a>
	</td>
	<td align="center">
	  <a href="index.php?page=private.benutzerliste&id=<?php echo $_smarty_tpl->getVariable('user')->value->getIdentNumber();?>
">
	    <img style="border:none" src="images/delete.png" alt="L&ouml;schen" />
	  </a>
	</td>
	<td align="center">
	  <a href="index.php?page=private.newUser&id=<?php echo $_smarty_tpl->getVariable('user')->value->getIdentNumber();?>
">
	    <img style="border:none" src="images/pencil.png" alt="Bearbeiten" />
	  </a>
	</td>
	<?php }?>
      </tr>
      <?php }} ?>
    </table>
    <p align="center"><a href="index.php?page=private.newUser">Neuen Benutzer erstellen</a></p>
  </div>
</div>
