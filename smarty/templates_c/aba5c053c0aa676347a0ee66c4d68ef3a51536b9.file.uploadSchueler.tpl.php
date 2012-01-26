<?php /* Smarty version Smarty3-RC3, created on 2012-01-25 15:51:24
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/uploadSchueler.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16168446964f2016ec98d0b4-05133677%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aba5c053c0aa676347a0ee66c4d68ef3a51536b9' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/uploadSchueler.tpl',
      1 => 1309268812,
    ),
  ),
  'nocache_hash' => '16168446964f2016ec98d0b4-05133677',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="post">
  <h2 class="title"><a href="#">Sch&uuml;lerliste</a></h2>
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
	    Semester aussuchen:
	  </td>
	  <td>
	    <select name="zeitraumnummer" onchange="schuelerrequest()">
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
	  <td colspan="2" align="center">
	    <input type="button" name="Zeige" value="Weiter" onclick="schuelerrequest()"/>
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
