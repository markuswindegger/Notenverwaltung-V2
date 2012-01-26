<?php /* Smarty version Smarty3-RC3, created on 2012-01-25 22:05:25
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/fachrequest.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13087138234f206e9545bd78-02380515%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd63655247e152dc8bc37308e75b2b74a1ecf9301' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/fachrequest.tpl',
      1 => 1309268812,
    ),
  ),
  'nocache_hash' => '13087138234f206e9545bd78-02380515',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<td>Fach:</td>
<td>
  <select name="fachnummer" onchange="schuelerrequest()">
    <option value="-1">Bitte Fach ausw&auml;hlen</option>
    <?php  $_smarty_tpl->tpl_vars['fach'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('fachliste')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['fach']->key => $_smarty_tpl->tpl_vars['fach']->value){
?>
    <option value="<?php echo $_smarty_tpl->getVariable('fach')->value->getIdentNumber();?>
"><?php echo $_smarty_tpl->getVariable('fach')->value->getName();?>
</option>
    <?php }} ?>
    </select>
</td>

