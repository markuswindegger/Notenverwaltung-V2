<?php

if($_SESSION['benutzer']->getRolle() != 1)
    {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
    }

if(isset($_REQUEST['id']) && $_REQUEST['id'] != 1)
  {
    if(MyError::isError($benutzer = BenutzerListe::getById($_REQUEST['id'])))
      {
	$smarty->assign('message', $liste->getMessage()."<br/>".$liste->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
      }
    if($benutzer == NULL)
      {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
      }
    if(MyError::isError($error = $benutzer->delete()))
      {
	$smarty->assign('message', $error->getMessage()."<br/>".$error->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
      }
  }


if(MyError::isError($liste = BenutzerListe::getList()))
    {
	$smarty->assign('message', $liste->getMessage()."<br/>".$liste->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }




$rollen[1] = "Administrator";
$rollen[2] = "Lehrer";
$rollen[3] = "Klassenvorstand";
$rollen[4] = "Verwalter";

$smarty->assign('benutzerliste', $liste);

$smarty->assign('rollenliste', $rollen);

$smarty->addTemplate('content', 'private/benutzerliste.tpl');

?>