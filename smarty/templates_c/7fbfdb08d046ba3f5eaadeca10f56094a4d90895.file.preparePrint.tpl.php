<?php /* Smarty version Smarty3-RC3, created on 2011-05-06 17:54:36
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/preparePrint.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1780677944dc419bc502f91-64018975%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7fbfdb08d046ba3f5eaadeca10f56094a4d90895' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/preparePrint.tpl',
      1 => 1304697182,
    ),
  ),
  'nocache_hash' => '1780677944dc419bc502f91-64018975',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="post">
  <h2 class="title"><a href="#">Noten eingeben</a></h2>
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
	    <select name="klassennummer" onchange="notenfachrequest()">
	      <option value="-1" selected="selected">Bitte Klasse ausw&auml;hlen</option>
	      <?php  $_smarty_tpl->tpl_vars['klasse'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('klassenliste')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['klasse']->key => $_smarty_tpl->tpl_vars['klasse']->value){
?>
	      <option value="<?php echo $_smarty_tpl->getVariable('klasse')->value->getIdentNumber();?>
"><?php echo $_smarty_tpl->getVariable('klasse')->value->getStufe();?>
. <?php echo $_smarty_tpl->getVariable('klasse')->value->getFachrichtung();?>
 <?php echo $_smarty_tpl->getVariable('klasse')->value->getZug();?>
</option>
	      <?php }} ?>
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
