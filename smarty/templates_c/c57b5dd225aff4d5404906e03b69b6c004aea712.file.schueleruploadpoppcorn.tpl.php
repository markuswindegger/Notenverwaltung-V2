<?php /* Smarty version Smarty3-RC3, created on 2012-01-24 22:57:21
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/schueleruploadpoppcorn.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1851060264f1f29416a5ab9-48374917%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c57b5dd225aff4d5404906e03b69b6c004aea712' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/schueleruploadpoppcorn.tpl',
      1 => 1327441871,
    ),
  ),
  'nocache_hash' => '1851060264f1f29416a5ab9-48374917',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h3>Sch&uuml;ler f&uuml;r <?php echo $_smarty_tpl->getVariable('semester')->value->getSemester();?>
. Semester <?php echo $_smarty_tpl->getVariable('semester')->value->getSchuljahr();?>
</h3>
<form action="?page=private.doUploadSchuelerPoppcorn" method="post" enctype="multipart/form-data">
  <table align="center" border="0" width="100%">	
    <tr>
      <td width="30%">
	Datei:
      </td>
      <td width="*">
	<input name="datei" type="file" maxlength="100000000" accept="text/*" />
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
	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('semester')->value->getIdentNumber();?>
" name="zeitraumnummer" />
	<input type="submit" value="Hochladen" name="upload" />
      </td>
    </tr>
  </table>
</form>
