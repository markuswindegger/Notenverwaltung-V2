<?php /* Smarty version Smarty3-RC3, created on 2012-01-24 23:25:13
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/schuelerliste.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12599880444f1f2fc9cc37e9-87625270%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '131d434ad739c656a3a886f8a398d8b8b14a7aa3' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/schuelerliste.tpl',
      1 => 1327443879,
    ),
  ),
  'nocache_hash' => '12599880444f1f2fc9cc37e9-87625270',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="post">
  <h2 class="title"><a href="#">Sch&uuml;lerliste</a></h2>
  <div id="ajaxspace" class="entry">
    <form action="#" method="post">
      <table width="100%" border="0">
	<tr>
	  <td>
	    Semester aussuchen:
	  </td>
	  <td>
	    <select name="zeitraumnummer" onchange="klassenrequest()">
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
	    <select name="klassennummer" onchange="schuelerrequest()">
	      <option value="-1" selected="selected">Bitte Klasse ausw&auml;hlen</option>
	    </select>
	  </td>
	</tr>
	<tr>
	  <td colspan="2" align="center">
	    <input type="button" name="Zeige" value="Zeige Sch&uuml;ler" onclick="schuelerrequest()"/>
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
