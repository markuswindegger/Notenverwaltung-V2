<?php /* Smarty version Smarty3-RC3, created on 2012-01-25 22:05:27
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/schuelerliste_noten.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12769081974dc414ffba6f39-93428581%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0f3fbc59b1792e81bb1ac1dc2804319f3ad3794b' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/schuelerliste_noten.tpl',
      1 => 1309268812,
    ),
  ),
  'nocache_hash' => '12769081974dc414ffba6f39-93428581',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/function.cycle.php';
?><form action="index.php?page=private.doUploadNoten" method="post">
  <table width="100%" border="0">
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
*
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
	<input type="text" name="<?php echo $_smarty_tpl->getVariable('schueler')->value->getIdentNumber();?>
_<?php echo $_smarty_tpl->getVariable('fach')->value->getIdentNumber();?>
" size="10%" 
	<?php if (isset($_smarty_tpl->getVariable('notenliste')->value[$_smarty_tpl->getVariable('fach')->value->getIdentNumber()][$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()])){?>
	value="<?php echo $_smarty_tpl->getVariable('notenliste')->value[$_smarty_tpl->getVariable('fach')->value->getIdentNumber()][$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()]->getNote();?>
"
	<?php }?>
	/>
      </td>
      <?php }} ?>
      <?php if ($_smarty_tpl->getVariable('absenzen')->value==1){?>
      <td align="center">
	<input type="text" name="<?php echo $_smarty_tpl->getVariable('schueler')->value->getIdentNumber();?>
" size="10%" 
	<?php if (isset($_smarty_tpl->getVariable('absenzliste')->value[$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()])){?>
	value="<?php echo $_smarty_tpl->getVariable('absenzliste')->value[$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()]->getAbsenzen();?>
"
	<?php }?>
       />
      </td>
      <?php }?>
    </tr>
    <?php }} ?>
  </table>
  <?php  $_smarty_tpl->tpl_vars['fach'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('fachliste')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['fach']->key => $_smarty_tpl->tpl_vars['fach']->value){
?>
  <input type="hidden" name="fach[]" value="<?php echo $_smarty_tpl->getVariable('fach')->value->getIdentNumber();?>
" />
  <?php }} ?>
  <input type="hidden" name="klasse" value="<?php echo $_smarty_tpl->getVariable('klasse')->value->getIdentNumber();?>
" />
  <input type="submit" name="Noten eintragen" value="Noten eintragen" align="center"/>
</form>
<p style="margin-top: 3em">
* Geben Sie bitte hier nur <u>GANZE</u> Noten von <b>1 bis 10</b> ein. F&uuml;r nicht klassifiziert bitte ein <b>n.k.</b> eintragen. Auch ein <b>?</b> ist m&ouml;glich, falls Sie sich der Note noch nicht sicher sind.
</p>
