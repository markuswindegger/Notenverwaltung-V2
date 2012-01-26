<?php /* Smarty version Smarty3-RC3, created on 2011-05-07 11:25:12
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/prepare_export.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19682836344dc50ff81b0369-08110333%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '82809d40e9cf2cf3f1861012b945d1f579662ed0' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/prepare_export.tpl',
      1 => 1304760197,
    ),
  ),
  'nocache_hash' => '19682836344dc50ff81b0369-08110333',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="post">
  <h2 class="title"><a href="#">Export von Klassen</a></h2>
  <div id="ajaxspace" class="entry">
    <form action="#" method="post">
      <table width="100%" border="0">
	<tr>
	  <td>
	    Semester aussuchen:
	  </td>
	  <td>
	    <select name="zeitraumnummer">
	      <option value="-1" selected="selected">Bitte Semester ausw&auml;hlen</option>
	      <?php  $_smarty_tpl->tpl_vars['semester'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('semesterliste')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['semester']->key => $_smarty_tpl->tpl_vars['semester']->value){
?>
	      <option value="<?php echo $_smarty_tpl->getVariable('semester')->value->getIdentNumber();?>
"><?php echo $_smarty_tpl->getVariable('semester')->value->getSemester();?>
. Semester <?php echo $_smarty_tpl->getVariable('semester')->value->getSchuljahr();?>
</option>
	      <?php }} ?>
	    </select>
	  </td>
	</tr>
	<tr>
	  <td>
	    Klasse aussuchen:
	  </td>
	  <td>
	    <select name="klassennummer">
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
	<tr>
	  <td colspan="2" align="center">
	    <input type="button" name="Zeige" value="Zeige Sch&uuml;ler" onclick="schuelerrequest()"/>
	  </td>
	</tr>
      </table>
    </form>
  </div>
</div>
