<?php /* Smarty version Smarty3-RC3, created on 2012-01-24 22:52:13
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/schuelerliste.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17658776274dac46b8eaedb9-10188679%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '76105cdc79268a4d3b17b7f83582ebeb6b6d6840' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/schuelerliste.tpl',
      1 => 1309268812,
    ),
  ),
  'nocache_hash' => '17658776274dac46b8eaedb9-10188679',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/function.cycle.php';
if (!is_callable('smarty_modifier_escape')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/modifier.escape.php';
?><h3><?php echo $_smarty_tpl->getVariable('klasse')->value->getStufe();?>
. <?php echo $_smarty_tpl->getVariable('klasse')->value->getFachrichtung();?>
 <?php echo $_smarty_tpl->getVariable('klasse')->value->getZug();?>
</h3>
<table border='0' align="center">
  <tr>
    <th>Nachname</th>
    <th>Name</th>
  </tr>
  <?php  $_smarty_tpl->tpl_vars['schueler'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('schuelerliste')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['schueler']->key => $_smarty_tpl->tpl_vars['schueler']->value){
?>
  <tr class='<?php echo smarty_function_cycle(array('values'=>"odd,even"),$_smarty_tpl->smarty,$_smarty_tpl);?>
'>
    <td><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('schueler')->value->getNachname(),'html');?>
</td>
    <td><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('schueler')->value->getName(),'html');?>
</td>
  </tr>
  <?php }} ?>
</table>
