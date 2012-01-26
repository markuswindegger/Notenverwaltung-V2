<?php /* Smarty version Smarty3-RC3, created on 2011-05-07 09:44:48
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/print_betragen.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6354680464dc4f87093ef48-14784278%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1485ffe6b53b6fda4e1ce080e09eb8c0a352bb5d' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/print_betragen.tpl',
      1 => 1304754283,
    ),
  ),
  'nocache_hash' => '6354680464dc4f87093ef48-14784278',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/function.cycle.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Notenveraltung GOB Bozen</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="styleprint.css" type="text/css" media="screen" /> 
  </head>
  <body>

<table width="60%" border="1" align="center">
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
    <td align="center"
      <?php if (isset($_smarty_tpl->getVariable('betragenliste')->value[$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()])){?>
      <?php if ($_smarty_tpl->getVariable('betragenliste')->value[$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()]<6){?>
      style="color: red"
      <?php }?>
      >
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
      <a href="javascript:window.print()">Diese Ansicht drucken</a> | <a href="javascript:window.close()">Zur&uuml;ck</a>
    </p>

</body>
</html>
