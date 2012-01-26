<?php /* Smarty version Smarty3-RC3, created on 2012-01-24 22:08:36
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/semesterliste.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19893701734de75a88476a90-11275113%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '496e531dd740b0d681c33641880dea12e0cf7eac' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/semesterliste.tpl',
      1 => 1309268812,
    ),
  ),
  'nocache_hash' => '19893701734de75a88476a90-11275113',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/function.cycle.php';
if (!is_callable('smarty_modifier_escape')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/modifier.escape.php';
?><div class="post">
  <h2 class="title"><a href="#">Semesterliste</a></h2>
  <div class="entry">
    <?php if (isset($_smarty_tpl->getVariable('fehlermsg')->value)){?>
    <p style="color: red;text-align: center">
      <?php echo $_smarty_tpl->getVariable('fehlermsg')->value;?>

    </p>
    <?php }?>
    <table border='0' align="center">
      <tr>
	<th>Semester</th>
	<th>Schuljahr</th>
	<th>Freigabe</th>
	<th>Sperrung</th>
	<th>L&ouml;schen</th>
	<th>Bearbeiten</th>
      </tr>
      <?php  $_smarty_tpl->tpl_vars['semester'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('semesterliste')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['semester']->key => $_smarty_tpl->tpl_vars['semester']->value){
?>
      <tr class='<?php echo smarty_function_cycle(array('values'=>"odd,even"),$_smarty_tpl->smarty,$_smarty_tpl);?>
'>
      	<td align="center"><?php echo $_smarty_tpl->getVariable('semester')->value->getSemester();?>
</td>
	<td><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('semester')->value->getSchuljahr(),'html');?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('semester')->value->getFreidatum()->format('d.m.Y');?>
</td>
	<td><?php echo $_smarty_tpl->getVariable('semester')->value->getSperrdatum()->format('d.m.Y');?>
</td>
	<td align="center">
	  <a href="?page=private.semesterliste&id=<?php echo $_smarty_tpl->getVariable('semester')->value->getIdentNumber();?>
">
	    <img src="./images/delete.png" alt="L&ouml;schen" />
	  </a>
	</td>
	<td align="center">
	  <a href="?page=private.modify_semester&id=<?php echo $_smarty_tpl->getVariable('semester')->value->getIdentNumber();?>
">
	    <img src="./images/pencil.png" alt="Bearbeiten" />
	  </a>
	</td>
      </tr>
      <?php }} else { ?>
      <tr>
	<td colspan="4" align="center">
	  Keine Semester vorhanden!!
	</td>
      </tr>
      <?php } ?>
    </table>
  </div>
</div>

<div class="post">
  <h3 class="title"><a href="#">Semester hinzuf&uuml;gen</a></h3>
  <div class="entry">
    <form action="?page=private.insertSemester" method="post">
      <table align="center" border="0" width="100%">
	<tr>
	  <td>
	    Semester:
	  </td>
	  <td>
	    <select name="semester">
	      <option value="1">1</option>
	      <option value="2">2</option>
	    </select>
	  </td>
	</tr>
	<tr>
	  <td>
	    Schuljahr:
	  </td>
	  <td>
	    <input type="text" name="schuljahr" />
	  </td>
	</tr>
	<tr>
	  <td>
	    Freigabedatum:
	  </td>
	  <td>
	    <input type="text" name="freidatum" onchange="setSperre()" />
	  </td>
	</tr>
	<tr>
	  <td>
	    Sperrdatumdatum:
	  </td>
	  <td>
	    <input type="text" name="sperrdatum" />
	  </td>
	</tr>
	<tr>
	  <td colspan="2" align="center">
	    <input type="submit" name="senden" value="Hinzuf&uuml;gen" onclick="freigeben()"/>
	  </td>
	</tr>
      </table>
    </form>
  </div>
</div>
