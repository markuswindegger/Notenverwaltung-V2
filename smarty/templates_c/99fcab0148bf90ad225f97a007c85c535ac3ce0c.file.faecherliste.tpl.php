<?php /* Smarty version Smarty3-RC3, created on 2012-01-25 22:00:41
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/faecherliste.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19223451784dc2dec3484682-17095201%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '99fcab0148bf90ad225f97a007c85c535ac3ce0c' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/faecherliste.tpl',
      1 => 1309268812,
    ),
  ),
  'nocache_hash' => '19223451784dc2dec3484682-17095201',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/function.cycle.php';
?><h3>F&auml;cher f&uuml;r <?php echo $_smarty_tpl->getVariable('semester')->value->getSemester();?>
. Semester <?php echo $_smarty_tpl->getVariable('semester')->value->getSchuljahr();?>
</h3>
<table align="center" border="0" width="100%">	
  <tr>
    <th>
      Klasse
    </th>
    <th>
      Fach
    </th>
    <th>
      Lehrer
    </th>
    <th>
      Fachtyp
    </th>
    <th>
     Absenzeneingabe
    </th>
    <th>
      &nbsp;
    </th>
  </tr>
  <?php  $_smarty_tpl->tpl_vars['fach'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('faecherliste')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['fach']->key => $_smarty_tpl->tpl_vars['fach']->value){
?>
  <tr class='<?php echo smarty_function_cycle(array('values'=>"odd,even"),$_smarty_tpl->smarty,$_smarty_tpl);?>
'>
    <td>
      <?php echo $_smarty_tpl->getVariable('klassenliste')->value[$_smarty_tpl->getVariable('fach')->value->getKlassennummer()]->getStufe();?>
 <?php echo $_smarty_tpl->getVariable('klassenliste')->value[$_smarty_tpl->getVariable('fach')->value->getKlassennummer()]->getFachrichtung();?>
 <?php echo $_smarty_tpl->getVariable('klassenliste')->value[$_smarty_tpl->getVariable('fach')->value->getKlassennummer()]->getZug();?>

    </td>
    <td>
      <?php echo $_smarty_tpl->getVariable('fach')->value->getName();?>

    </td>
    <td>
      <?php echo $_smarty_tpl->getVariable('lehrerliste')->value[$_smarty_tpl->getVariable('fach')->value->getLehrernummer()]->getName();?>
 <?php echo $_smarty_tpl->getVariable('lehrerliste')->value[$_smarty_tpl->getVariable('fach')->value->getLehrernummer()]->getNachname();?>

    </td>
    <td>
      <?php echo $_smarty_tpl->getVariable('fachtypliste')->value[$_smarty_tpl->getVariable('fach')->value->getFachtypnummer()];?>

    </td>
    <td>
      <?php if ($_smarty_tpl->getVariable('fach')->value->getAbsenzen()==1){?>
      Ja
      <?php }else{ ?>
      Nein
      <?php }?>
    </td>
    <td>
      <a href="?page=private.faecherliste&fach=<?php echo $_smarty_tpl->getVariable('fach')->value->getIdentNumber();?>
"><img style="border:none" src="images/delete.png" alt="Fach l&ouml;schen" /></a>
    </td>
  </tr>
  <?php }} else { ?>
  <tr>
    <th colspan="6">
      Es wurden keine F&auml;cher diesem Semester zugeteilt!!!!
    </th>
  </tr>
  <?php } ?>
</table>
