<?php /* Smarty version Smarty3-RC3, created on 2011-05-06 18:56:13
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/preparePrint.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10052840104dc4282d290e13-64963422%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '03f09c70608c4e242769c1e35b2d66ef9c7e32cf' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/preparePrint.tpl',
      1 => 1304700942,
    ),
  ),
  'nocache_hash' => '10052840104dc4282d290e13-64963422',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/function.cycle.php';
?><table width="100%" border="0">
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
    <td align="center">
      <?php if (isset($_smarty_tpl->getVariable('notenliste')->value[$_smarty_tpl->getVariable('fach')->value->getIdentNumber()][$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()])){?>
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
<a href="?page=private.getNotenspiegel&fachnummer=<?php echo $_smarty_tpl->getVariable('fachnummer')->value;?>
" target="_blank">Die Notenansicht drucken</a>
</p>


