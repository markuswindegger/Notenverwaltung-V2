<?php

if($_SESSION['benutzer']->getRolle() != 1)
    {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
    }

$smarty->mergeInto('js_scripts', 'jquery.js');

$smarty->mergeInto('js_scripts', 'private/schueler.js');

if(MyError::isError($liste = ZeitraumListe::getList()))
    {
	$smarty->assign('message', $liste->getMessage()."<br/>".$liste->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }


$smarty->assign('semesterliste', $liste);

$smarty->addTemplate('content', 'private/schuelerliste.tpl');

?>