<?php /* Smarty version Smarty3-RC3, created on 2012-01-24 22:09:12
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/schuelerupload.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3058914474dae8c9be7f568-86380732%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6924c279e7522955a5a0dc15e0341d4f24977d1f' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/schuelerupload.tpl',
      1 => 1309268812,
    ),
  ),
  'nocache_hash' => '3058914474dae8c9be7f568-86380732',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h3>Sch&uuml;ler f&uuml;r <?php echo $_smarty_tpl->getVariable('semester')->value->getSemester();?>
. Semester <?php echo $_smarty_tpl->getVariable('semester')->value->getSchuljahr();?>
</h3>
<form action="?page=private.doUploadSchueler" method="post" enctype="multipart/form-data">
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
	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('semester')->value->getIdentNumber();?>
" name="zeitraumnummer" />
	<input type="submit" value="Hochladen" name="upload" />
      </td>
    </tr>
  </table>
</form>
