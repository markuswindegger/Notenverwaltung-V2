<?php /* Smarty version Smarty3-RC3, created on 2012-01-25 16:01:22
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/newUser.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1142710854de77fd63b7b83-62938462%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd214d9ab4041e7322aa9e6eefbce879e3291066d' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/newUser.tpl',
      1 => 1309268812,
    ),
  ),
  'nocache_hash' => '1142710854de77fd63b7b83-62938462',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/srv/www/notenverwaltung2_1/lib/smarty3/plugins/modifier.escape.php';
?><div class="post">
  <?php if ($_smarty_tpl->getVariable('benutzer')->value!=null){?>
  <h2 class="title"><a href="#">Benutzer ändern</a></h2>
  <?php }else{ ?>
  <h2 class="title"><a href="#">Benutzer eintragen</a></h2>
  <?php }?>
  <div class="entry">
    <?php if (isset($_smarty_tpl->getVariable('errormsg')->value)){?>
    <p style="color: red;">
      <?php echo $_smarty_tpl->getVariable('errormsg')->value;?>
    
    </p>
    <?php }?>
    <form action="index.php?page=private.insertUser" method="post">
    <p>
      Vorname:<br />
      <input type="text" name="name" style="width:100%" 
	     <?php if ($_smarty_tpl->getVariable('benutzer')->value!=null){?>
	     value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('benutzer')->value->getName(),'html');?>
"
	     <?php }?>
	     />
      <p class="input_error" id="name_error" style="color:red"></p>
    </p>
    <p>
      Nachname:<br />
      <input type="text" name="nachname" style="width:100%"
	     <?php if ($_smarty_tpl->getVariable('benutzer')->value!=null){?>
	     value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('benutzer')->value->getNachname(),'html');?>
"
	     <?php }?>
	     />
    <p class="input_error" id="nachname_error" style="color:red"></p>
    </p>
    <p>
      Benutzername:<br />
      <input type="text"  name="benutzername" style="width:100%"
	     <?php if ($_smarty_tpl->getVariable('benutzer')->value!=null){?>
	     value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('benutzer')->value->getUser(),'html');?>
"
	     disabled="disabled"
	     <?php }?>
	     onChange="benutzerval()"/>
    <p class="input_error" id="benutzername_error" style="color:red"></p>
    <p>
      Rolle:<br />
      <select name="rolle">
	<option value="-1">Bitte Rolle w&auml;hlen</option>
	<?php  $_smarty_tpl->tpl_vars['rolle'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['nummer'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('rollenliste')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['rolle']->key => $_smarty_tpl->tpl_vars['rolle']->value){
 $_smarty_tpl->tpl_vars['nummer']->value = $_smarty_tpl->tpl_vars['rolle']->key;
?>
	<option value="<?php echo $_smarty_tpl->tpl_vars['nummer']->value;?>
"
	  <?php if ($_smarty_tpl->getVariable('benutzer')->value!=null){?>
	      <?php if ($_smarty_tpl->tpl_vars['nummer']->value==$_smarty_tpl->getVariable('benutzer')->value->getRolle()){?>
	      selected="selected"
	      <?php }?>
          <?php }?>
		>
	  <?php echo $_smarty_tpl->tpl_vars['rolle']->value;?>

	</option>
	<?php }} ?>
      </select>
    <p class="input_error" id="rolle_error" style="color:red"></p>

    </p>
    <p style="text-align:center">
      <?php if ($_smarty_tpl->getVariable('benutzer')->value!=null){?>
      <input type="hidden" name="id" value="<?php echo $_smarty_tpl->getVariable('benutzer')->value->getIdentNumber();?>
" />
      <?php }?>
      <?php if ($_smarty_tpl->getVariable('benutzer')->value!=null){?>
      <input type="submit" onClick="return benutzervalidate()" value="Ändern"/>
      <?php }else{ ?>
      <input type="submit" onClick="return benutzervalidate()" value="Eintragen" disabled="disabled"/>
      <?php }?>
    </p>
    </form>
  </div>
</div>
