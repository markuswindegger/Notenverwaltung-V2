<?php

if($_SESSION['benutzer']->getRolle() != 1)
    {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
    }

if(isset($_REQUEST['fach']))
  {
    if(MyError::isError($fach = FachListe::getById($_REQUEST['fach'])))
      {
	$smarty->assign('message', $fach->getMessage()."<br/>".$fach->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
      }
    if(MyError::isError($error = $fach->delete()))
      {
	$smarty->assign('message', $error->getMessage()."<br/>".$error->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
      }
    $smarty->assign("message", "Das Fach wurde erfolgreich gel&ouml;scht");
  }


$smarty->mergeInto('js_scripts', 'jquery.js');

$smarty->mergeInto('js_scripts', 'private/faecher.js');

if(MyError::isError($liste = ZeitraumListe::getList()))
    {
	$smarty->assign('message', $liste->getMessage()."<br/>".$liste->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }


$smarty->assign('semesterliste', $liste);

$smarty->addTemplate('content', 'private/faecherliste.tpl');

?>