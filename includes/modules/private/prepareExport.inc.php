<?php

if($_SESSION['benutzer']->getRolle() != 1 && $_SESSION['benutzer']->getRolle() != 4)
    {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
    }

$smarty->mergeInto('js_scripts', 'jquery.js');

$smarty->mergeInto('js_scripts', 'private/export.js');

if(MyError::isError($liste = ZeitraumListe::getList()))
    {
	$smarty->assign('message', $liste->getMessage()."<br/>".$liste->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }


if(MyError::isError($klassenliste = KlassenListe::getList()))
    {
	$smarty->assign('message', $klassenliste->getMessage()."<br/>".$klassenliste->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }

$smarty->assign('klassenliste', $klassenliste);

$smarty->assign('semesterliste', $liste);

$smarty->addTemplate('content', 'private/prepare_export.tpl');

?>