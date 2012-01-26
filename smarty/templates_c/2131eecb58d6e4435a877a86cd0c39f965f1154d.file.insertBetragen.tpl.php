<?php /* Smarty version Smarty3-RC3, created on 2012-01-25 22:19:46
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/insertBetragen.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17897445774dc43543624855-58518982%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2131eecb58d6e4435a877a86cd0c39f965f1154d' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/insertBetragen.tpl',
      1 => 1309268812,
    ),
  ),
  'nocache_hash' => '17897445774dc43543624855-58518982',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="post">
  <h2 class="title"><a href="#">Betragen eingeben</a></h2>
  <div class="entry">
    <?php if (isset($_smarty_tpl->getVariable('fehlermsg')->value)&&$_smarty_tpl->getVariable('fehlermsg')->value!=null){?>
    <p style="color: red" align="center">
      <?php echo $_smarty_tpl->getVariable('fehlermsg')->value;?>

    </p>
    <?php }?>
    <?php if (isset($_smarty_tpl->getVariable('message')->value)&&$_smarty_tpl->getVariable('message')->value!=null){?>
    <p align="center">
      <?php echo $_smarty_tpl->getVariable('message')->value;?>

    </p>
    <?php }?>
    <form action="#" method="post">
      <table width="100%" border="0">
	<tr>
	  <td>
	    Klasse aussuchen:
	  </td>
	  <td>
	    <select name="vorstandnummer" onchange="schuelerrequest()">
	      <option value="-1" selected="selected">Bitte Klasse ausw&auml;hlen</option>
	      <?php  $_smarty_tpl->tpl_vars['vorstand'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('vorstandliste')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vorstand']->key => $_smarty_tpl->tpl_vars['vorstand']->value){
?>
	      <option value="<?php echo $_smarty_tpl->getVariable('vorstand')->value->getIdentNumber();?>
"><?php echo $_smarty_tpl->getVariable('klassenliste')->value[$_smarty_tpl->getVariable('vorstand')->value->getKlassennummer()]->getStufe();?>
. <?php echo $_smarty_tpl->getVariable('klassenliste')->value[$_smarty_tpl->getVariable('vorstand')->value->getKlassennummer()]->getFachrichtung();?>
 <?php echo $_smarty_tpl->getVariable('klassenliste')->value[$_smarty_tpl->getVariable('vorstand')->value->getKlassennummer()]->getZug();?>
</option>
	      <?php }} ?>
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
