<?php /* Smarty version Smarty3-RC3, created on 2011-04-16 09:48:18
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/errors/message.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18789366834da949c2cd1748-46756943%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f50741a1a7fd9b87c2deca6ab8daa308f9646703' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/errors/message.tpl',
      1 => 1302528837,
    ),
  ),
  'nocache_hash' => '18789366834da949c2cd1748-46756943',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<!-- Error/Info message -->

<?php if ($_smarty_tpl->getVariable('mess_type')->value=="info"){?>

<div class="info_message">
 <span class="info_message_title">Fehler</span>
<?php }elseif($_smarty_tpl->getVariable('mess_type')->value=="warning"){?>

<div class="warning_message">
 <span class="warning_message_title">Warnung</span>
<?php }elseif($_smarty_tpl->getVariable('mess_type')->value=="error"){?>

<div class="error_message">
 <span class="error_message_title">Fehler</span>
<?php }else{ ?>
<div class="error_message">
 <span class="error_message_title">Error</span>
<?php }?>
  <p class="message_text">
  <?php echo $_smarty_tpl->getVariable('message')->value;?>

  </p>
</div>

<!-- Error/Info message end -->
