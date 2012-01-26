<?php /* Smarty version Smarty3-RC3, created on 2011-05-07 09:34:07
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/print_schuelerliste_betragen.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21335860014dc4f5ef90d9b2-64003593%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '91b4da4c7131905c476bc10bf47510e4b642257a' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/print_schuelerliste_betragen.tpl',
      1 => 1304753620,
    ),
  ),
  'nocache_hash' => '21335860014dc4f5ef90d9b2-64003593',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/function.cycle.php';
?><table width="100%" border="0">
  <tr>
    <th>
      Name
    </th>
    <th>
      Betragen
    </th>
    <th>
      Unentschuldigte Absenzen
    </th>
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
    <td align="center">
      <?php if (isset($_smarty_tpl->getVariable('betragenliste')->value[$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()])){?>
      <?php echo $_smarty_tpl->getVariable('betragenliste')->value[$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()]->getBetragen();?>

      <?php }?>
    </td>
    <td align="center">
      <?php if (isset($_smarty_tpl->getVariable('betragenliste')->value[$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()])){?>
      <?php echo $_smarty_tpl->getVariable('betragenliste')->value[$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()]->getAbsenzen();?>

      <?php }?>
    </td>
  </tr>
  <?php }} ?>
</table>
<p align="center">
<a href="?page=private.getBetragenPrint&vorstandnummer=<?php echo $_smarty_tpl->getVariable('vorstandnummer')->value;?>
" target="_blank">Diese Ansicht drucken</a>
</p>

