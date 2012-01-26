<?php /* Smarty version Smarty3-RC3, created on 2012-01-24 23:38:42
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/klassenliste.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4190495204f1f32f204fff5-35536140%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '52ebdafd6f0360ca3da81682983d741d71814dce' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/klassenliste.tpl',
      1 => 1327444653,
    ),
  ),
  'nocache_hash' => '4190495204f1f32f204fff5-35536140',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/modifier.escape.php';
?><option value="-1">
  Bitte Klasse ausw&auml;hlen...
</option>
<?php  $_smarty_tpl->tpl_vars['klasse'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('klassenliste')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['klasse']->key => $_smarty_tpl->tpl_vars['klasse']->value){
?>
<option value="<?php echo $_smarty_tpl->getVariable('klasse')->value->getIdentNumber();?>
">
  <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('klasse')->value->getStufe(),'html');?>
.   <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('klasse')->value->getFachrichtung(),'html');?>
   <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('klasse')->value->getZug(),'html');?>

</option>
<?php }} ?>
