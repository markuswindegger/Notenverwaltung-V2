<?php /* Smarty version Smarty3-RC3, created on 2011-06-02 11:33:35
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/modify_semester.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1766276894de758ef815af5-05191838%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cf941411636c79ae16efb9289fc356a41e3438ce' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/modify_semester.tpl',
      1 => 1307007182,
    ),
  ),
  'nocache_hash' => '1766276894de758ef815af5-05191838',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="post">
  <h3 class="title"><a href="#">Semester Bearbeiten</a></h3>
  <div class="entry">
    <?php if (isset($_smarty_tpl->getVariable('fehlermsg')->value)){?>
    <p style="color: red;text-align: center">
      <?php echo $_smarty_tpl->getVariable('fehlermsg')->value;?>

    </p>
    <?php }?>
    <form action="?page=private.insertSemester" method="post">
      <table align="center" border="0" width="100%">
	<tr>
	  <td>
	    Semester:
	  </td>
	  <td>
	    <select name="semester">
	      <option value="1"
              <?php if ($_smarty_tpl->getVariable('semester')->value->getSemester()==1){?>
		selected="selected"
              <?php }?>
              >1</option>
	      <option value="2"
	      <?php if ($_smarty_tpl->getVariable('semester')->value->getSemester()==1){?>
		selected="selected"
	      <?php }?>	
              >2</option>
	    </select>
	  </td>
	</tr>
	<tr>
	  <td>
	    Schuljahr:
	  </td>
	  <td>
	    <input type="text" name="schuljahr" value="<?php echo $_smarty_tpl->getVariable('semester')->value->getSchuljahr();?>
"/>
	  </td>
	</tr>
	<tr>
	  <td>
	    Freigabedatum:
	  </td>
	  <td>
	    <input type="text" name="freidatum" onchange="setSperre()" value='<?php echo $_smarty_tpl->getVariable('semester')->value->getFreidatum()->format("d.m.Y");?>
'/>
	  </td>
	</tr>
	<tr>
	  <td>
	    Sperrdatumdatum:
	  </td>
	  <td>
	    <input type="text" name="sperrdatum" value='<?php echo $_smarty_tpl->getVariable('semester')->value->getSperrdatum()->format("d.m.Y");?>
'/>
	  </td>
	</tr>
	<tr>
	  <td colspan="2" align="center">
	    <input type="hidden" name="id" value="<?php echo $_smarty_tpl->getVariable('semester')->value->getIdentNumber();?>
" />
	    <input type="submit" name="senden" value="&Auml;ndern" onclick="freigeben()"/>
	  </td>
	</tr>
      </table>
    </form>
  </div>
</div>
