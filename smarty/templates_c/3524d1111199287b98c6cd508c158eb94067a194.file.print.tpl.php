<?php /* Smarty version Smarty3-RC3, created on 2011-05-06 18:56:52
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/print.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14975133734dc428545e3338-63558639%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3524d1111199287b98c6cd508c158eb94067a194' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/print.tpl',
      1 => 1304700965,
    ),
  ),
  'nocache_hash' => '14975133734dc428545e3338-63558639',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/function.cycle.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Notenveraltung GOB Bozen</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="styleprint.css" type="text/css" media="screen" /> 
  </head>
  <body>
    <table width="60%" border="1" align="center">
      <tr>
	<th>
	  Name
	</th>
	<?php  $_smarty_tpl->tpl_vars['fach'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('fachliste')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['fach']->key => $_smarty_tpl->tpl_vars['fach']->value){
?>
	<th>
	  <?php echo $_smarty_tpl->getVariable('fach')->value->getName();?>
 <?php echo $_smarty_tpl->getVariable('fachtypliste')->value[$_smarty_tpl->getVariable('fach')->value->getFachtypnummer()];?>

	</th>
	<?php }} ?>
	<?php if ($_smarty_tpl->getVariable('absenzen')->value==1){?>
	<th>
	  Absenzen
	</th>
	<?php }?>
      </tr>
      <?php  $_smarty_tpl->tpl_vars['schueler'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('schuelerliste')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['schueler']->key => $_smarty_tpl->tpl_vars['schueler']->value){
?>
      <tr class='<?php echo smarty_function_cycle(array('values'=>"odd,even"),$_smarty_tpl->smarty,$_smarty_tpl);?>
'>
	<td>
	  <?php echo $_smarty_tpl->getVariable('schueler')->value->getNachname();?>
 <?php echo $_smarty_tpl->getVariable('schueler')->value->getName();?>

	</td>
	<?php  $_smarty_tpl->tpl_vars['fach'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('fachliste')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['fach']->key => $_smarty_tpl->tpl_vars['fach']->value){
?>
	<td align="center"
	  <?php if (isset($_smarty_tpl->getVariable('notenliste')->value[$_smarty_tpl->getVariable('fach')->value->getIdentNumber()][$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()])){?>
	  <?php if ($_smarty_tpl->getVariable('notenliste')->value[$_smarty_tpl->getVariable('fach')->value->getIdentNumber()][$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()]->getNote()<6&&$_smarty_tpl->getVariable('notenliste')->value[$_smarty_tpl->getVariable('fach')->value->getIdentNumber()][$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()]->getNote()!="?"&&$_smarty_tpl->getVariable('notenliste')->value[$_smarty_tpl->getVariable('fach')->value->getIdentNumber()][$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()]->getNote()!="n.k."){?>
		style="color: red"
	  <?php }?>
	  >
	  <?php echo $_smarty_tpl->getVariable('notenliste')->value[$_smarty_tpl->getVariable('fach')->value->getIdentNumber()][$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()]->getNote();?>

	  <?php }?>
	</td>
	<?php }} ?>
	<?php if ($_smarty_tpl->getVariable('absenzen')->value==1){?>
	<td align="center">
	  <?php if (isset($_smarty_tpl->getVariable('absenzliste')->value[$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()])){?>
	    <?php echo $_smarty_tpl->getVariable('absenzliste')->value[$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()]->getAbsenzen();?>

	  <?php }?>
	</td>
	<?php }?>
      </tr>
      <?php }} ?>
    </table>
    <p align="center">
      <a href="javascript:window.print()">Die Notenansicht drucken</a> | <a href="javascript:window.close()">Zur&uuml;ck</a>
    </p>
  </body>
</html>

