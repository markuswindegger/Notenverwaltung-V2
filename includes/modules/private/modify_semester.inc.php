<?php

if($_SESSION['benutzer']->getRolle() != 1)
    {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
    }

if(!isset($_REQUEST['id']))
  {
    $smarty->addTemplate("content", "keinen_zugriff.tpl");
    return;
  }


if(MyError::isError($semester = ZeitraumListe::getById($_REQUEST['id'])))
  {
    $smarty->assign('message', $semester->getMessage()."<br/>".$semester->getAdditionalInfo());
    $smarty->assign('err_type', 'error');
    $smarty->addTemplate('content', 'errors/message.tpl');
    return;
  }

$smarty->mergeInto('js_scripts', 'jquery.js');

$smarty->mergeInto('js_scripts', 'ui/jquery-ui.min.js');

$smarty->mergeInto('stylesheets', 'css/redmond/redmond.css');

$smarty->mergeInto('js_scripts', 'private/modify_semester.js');

$smarty->assign('semester', $semester);

$smarty->addTemplate('content', 'private/modify_semester.tpl');

?>