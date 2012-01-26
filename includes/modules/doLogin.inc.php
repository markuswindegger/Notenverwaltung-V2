<?php


if(!isset($_REQUEST['password']) || !isset($_REQUEST['username']))
    {
	$smarty->assign('loginerror', TRUE);
	$smarty->addTemplate('content', 'start.tpl');
	return;
    }
if(MyError::isError($_SESSION['benutzer']->auth($_REQUEST['username'], $_REQUEST['password'])))
    {
	$smarty->assign('loginerror', TRUE);
	$_SESSION['benutzer'] = new Benutzer();
	$smarty->addTemplate('content', 'start.tpl');
	return;
    }
if($_SESSION['benutzer']->getLogin() && $_SESSION['benutzer']->getAuth())
  {
    $zeitraum = null;
    if(MyError::isError($zeitraum = ZeitraumListe::getAktuellenZeitraum()))
      {
	$_SESSION['benutzer'] = new Benutzer();
	$smarty->assign('loginerror', TRUE);
	$smarty->addTemplate('content', 'start.tpl');
	return;
      }
    $_SESSION['zeitraum'] = $zeitraum;
    if($_SESSION['zeitraum'] == null)
      {
	$smarty->assign('zeitraum', $_SESSION['zeitraum']);
      }
    $smarty->addTemplate('content', 'private/home.tpl');
    return;
  }


?>