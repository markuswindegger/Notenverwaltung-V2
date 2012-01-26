<?php /* Smarty version Smarty3-RC3, created on 2012-01-25 15:50:41
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/uploadLehrer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10126476904da9669297d8e7-35435478%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b8cd5dc2b38448ab52e6890ad64c941238290a57' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/uploadLehrer.tpl',
      1 => 1309268812,
    ),
  ),
  'nocache_hash' => '10126476904da9669297d8e7-35435478',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="post">
  <h2 class="title"><a href="#">Lehrer eintragen</a></h2>
  <div class="entry">
    <?php if (isset($_smarty_tpl->getVariable('fehlermsg')->value)){?>
    <p style="color: red;text-align: center">
      <?php echo $_smarty_tpl->getVariable('fehlermsg')->value;?>

    </p>
    <?php }?>
    <form action="?page=private.doUploadLehrer" method="post" enctype="multipart/form-data">
      <table align="center" border="0" width="100%">	
	<tr>
	  <td width="30%">
	    Datei:
	  </td>
	  <td width="*">
	    <input name="datei" type="file" maxlength="100000" accept="text/*" />
	  </td>
	</tr>
	<tr>
	  <td width="30%">
	    Trennzeichen:
	  </td>
	  <td width="*">
	    <input name="trennzeichen" type="text" />
	  </td>
	</tr>
	<tr>
	  <td width="*" align="center" colspan="2">
	    <input type="submit" value="Hochladen" name="upload" />
	  </td>
	</tr>
      </table>
    </form>
  </div>
</div>
