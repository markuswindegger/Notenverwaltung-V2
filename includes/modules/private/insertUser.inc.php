<?php


if($_SESSION['benutzer']->getRolle() != 1)
  {
    $smarty->addTemplate("content", "keinen_zugriff.tpl");
    return;
  }



if(!isset($_REQUEST['name']))
  {
    $_REQUEST['name'] = null;
  }
if(!isset($_REQUEST['nachname']))
  {
    $_REQUEST['nachname'] = null;
  }
if(!isset($_REQUEST['benutzername']))
  {
    $_REQUEST['benutzername'] = null;
  }



if(isset($_REQUEST['id']))
  {
    if(MyError::isError($benutzer = BenutzerListe::getById($_REQUEST['id'])))
      {
	$smarty->assign('message', $error->getMessage()."<br />".$error->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
      }
    if($benutzer == NULL)
      {
	$smarty->assign('message', "Kein Benutzer mit dieser Identifikationsnummer in der Datenbank!");
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;	
      }
    $benutzer->setName($_REQUEST['name']);
    $benutzer->setNachname($_REQUEST['nachname']);
    $benutzer->setRolle($_REQUEST['rolle']);
	
	
    if(MyError::isError($error = $benutzer->update()))
      {
	$smarty->assign('message', $error->getMessage()."<br />".$error->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
      }
  }
else
  {
    $benutzer = new Benutzer();
	
    $benutzer->setName($_REQUEST['name']);
    $benutzer->setNachname($_REQUEST['nachname']);
    $benutzer->setUser($_REQUEST['benutzername']);
    $benutzer->setRolle($_REQUEST['rolle']);
    $passwd = "";
    $passwd = password_gen();
    $benutzer->setPassword(hash('sha256', $passwd));
	
    if(MyError::isError($error = $benutzer->validate()))
      {
	$smarty->assign('message', $error->getMessage()."<br />".$error->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
      }
	
    $selectquery = "SELECT U_Id FROM Benutzer WHERE benutzername = :user";

    if(!($stm = $con->prepare($selectquery)))
      {
	$smarty->assign('message',"Prepare_Error");
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
      }
	
    $stm->bindValue(":user", $_REQUEST['username']);
    if(!($stm->execute()))
      {

	$smarty->assign('message',"Execute_Error<br />".$stm->getErrorMsg());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
      }
    if($stm->fetch())
      {
	$smarty->assign('errormsg',"Der Benutzername ist schon in gebrauch, bitte suche dir einen anderen aus!<br /><a href=\"javascript:window.back()\">Zurück</a>");
	$smarty->addTemplate('content', 'private/newUser.tpl');
	return;
      }

    if(MyError::isError($error = $benutzer->insert()))
      {
	$smarty->assign('message', $error->getMessage()."<br />".$error->getAdditionalInfo());
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

return;





function password_gen()
{
  $possible = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $neues_passwort = "";
  for($i = 0; $i < 10; ++$i)
    {
      $charnr = rand(0,strlen($possible)-1);
      $neues_passwort .= $possible[$charnr];
    }
  return $neues_passwort;
}

?>