<?php

if($_SESSION['benutzer']->getRolle() != 1)
    {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
    }

if(isset($_REQUEST['id']) && $_REQUEST['id'])
  {
    if(MyError::isError($semester = ZeitraumListe::getById($_REQUEST['id'])))
    {
	$smarty->assign('message', $semester->getMessage()."<br/>".$semester->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }
    if(MyError::isError($error = $semester->delete()))
    {
	$smarty->assign('message', $error->getMessage()."<br/>".$error->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }
    

  }

$smarty->mergeInto('js_scripts', 'jquery.js');

$smarty->mergeInto('js_scripts', 'ui/jquery-ui.min.js');

$smarty->mergeInto('stylesheets', 'css/redmond/redmond.css');

$smarty->mergeInto('js_scripts', 'private/semester.js');

if(MyError::isError($liste = ZeitraumListe::getList()))
    {
	$smarty->assign('message', $liste->getMessage()."<br/>".$liste->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }

$smarty->assign('semesterliste', $liste);

$smarty->addTemplate('content', 'private/semesterliste.tpl');

?>