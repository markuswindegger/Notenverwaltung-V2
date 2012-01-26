<?php

if(!$_SESSION['benutzer']->getLogin() || $_SESSION['benutzer']->getRolle() != 3)
    {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
    }

$smarty->mergeInto('js_scripts', 'jquery.js');

$smarty->mergeInto('js_scripts', 'ui/jquery-ui.min.js');

$smarty->mergeInto('stylesheets', 'css/redmond/redmond.css');

$smarty->mergeInto('js_scripts', 'private/betragenupload.js');

if(MyError::isError($vorstandliste = VorstandListe::getByLehrernummer($_SESSION['benutzer']->getIdentNumber(), $_SESSION['zeitraum']->getIdentNumber())))
    {
	$smarty->assign('message', $vorstandliste->getMessage()."<br/>".$vorstandliste->getAdditionalInfo());
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

$smarty->assign('vorstandliste', $vorstandliste);

$smarty->addTemplate('content', 'private/insertBetragen.tpl');

?>