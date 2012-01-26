<?php

if($_SESSION['benutzer']->getRolle() != 1)
    {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
    }

$smarty->mergeInto('js_scripts', 'jquery.js');

$smarty->mergeInto('js_scripts', 'private/benutzer.js');

if(isset($_REQUEST['id']) && intval($_REQUEST['id']) > 0)
  {
    if(MyError::isError($benutzer = BenutzerListe::getById($_REQUEST['id'])))
      {
	$smarty->assign('message', $benutzer->getMessage()."<br/>".$benutzer->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
      }
    $smarty->assign("benutzer", $benutzer);
  }



$rollen[1] = "Administrator";
$rollen[2] = "Lehrer";
$rollen[3] = "Klassenvorstand";
$rollen[4] = "Verwalter";

$smarty->assign("rollenliste", $rollen);

$smarty->addTemplate('content', 'private/newUser.tpl');

?>