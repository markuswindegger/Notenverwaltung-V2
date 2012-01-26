<?php /* Smarty version Smarty3-RC3, created on 2012-01-25 22:19:48
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/schuelerliste_betragen.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9174839444dc4f418b933d4-98244750%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f3fc16cf0d310ab0ac1ac184723c3579c9dfc7ac' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/ajax/schuelerliste_betragen.tpl',
      1 => 1309268812,
    ),
  ),
  'nocache_hash' => '9174839444dc4f418b933d4-98244750',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_cycle')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/function.cycle.php';
?><form action="index.php?page=private.doUploadBetragen" method="post">
  <table width="100%" border="0">
    <tr>
      <th>
	Name
      </th>
      <th>
	Betragen*
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
	<input type="text" name="betr_<?php echo $_smarty_tpl->getVariable('schueler')->value->getIdentNumber();?>
" size="10%" 
	<?php if (isset($_smarty_tpl->getVariable('betragenliste')->value[$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()])){?>
	value="<?php echo $_smarty_tpl->getVariable('betragenliste')->value[$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()]->getBetragen();?>
"
	<?php }?>
	 />
      </td>
      <td align="center">
	<input type="text" name="abs_<?php echo $_smarty_tpl->getVariable('schueler')->value->getIdentNumber();?>
" size="10%" 
	<?php if (isset($_smarty_tpl->getVariable('betragenliste')->value[$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()])){?>
	value="<?php echo $_smarty_tpl->getVariable('betragenliste')->value[$_smarty_tpl->getVariable('schueler')->value->getIdentNumber()]->getAbsenzen();?>
"
	<?php }?>
	/>	
      </td>
    </tr>
    <?php }} ?>
  </table>
  <input type="hidden" name="vorstandnummer" value="<?php echo $_smarty_tpl->getVariable('vorstandnummer')->value;?>
" />
  <input type="submit" name="Noten eintragen" value="Betragen eintragen" align="center"/>
</form>

<p style="margin-top: 3em">
* Geben Sie bitte hier nur <u>GANZE</u> Noten von <b>1 bis 10</b> ein.
</p>
