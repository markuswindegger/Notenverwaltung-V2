<?php /* Smarty version Smarty3-RC3, created on 2011-04-15 17:25:40
         compiled from "/srv/www/notenverwaltung2_1/smarty//templates/private/pwdChange.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4647979874da86374f402c2-52853224%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '500099872ed973c66330d34519290736fb0ae29d' => 
    array (
      0 => '/srv/www/notenverwaltung2_1/smarty//templates/private/pwdChange.tpl',
      1 => 1302881012,
    ),
  ),
  'nocache_hash' => '4647979874da86374f402c2-52853224',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class='post'>
  <h2 class='title'><a href='#'>Passwort &auml;ndern</a></h2>
  <div class='entry'>
    <p class='result' style='text-align:center'></p>
    <form name='passwort'>
      <fieldset>
	<legend>Passwort &auml;ndern</legend>
	<table align='center'>
	  <tr>
	    <td>
	      <label >Altes Passwort:</label>
	    </td>
	    <td>
	      <input type='password' name='oldPassword' />
	    </td>
	  </tr>
	  <tr>
	    <td>
	      <label >Neues Passwort:</label>
	    </td>
	    <td>
	      <input type='password' name='newPassword1'/>
	    </td>
	  </tr>
	  <tr>
	    <td>
	      <label >Neues Passwort wiederholen:</label>
	    </td>
	    <td>
	      <input type='password' name='newPassword2'/>
	    </td>
	  </tr>
	  <tr>
	    <td colspan='2' align='center'>
	      <button type='button' onclick='passwd()'>&Auml;ndern</button>
	    </td>
	  </tr>
	</table>
      </fieldset>
    </form>
  </div>
</div>
