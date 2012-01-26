<?php

function randPasswd()
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


if(MyError::isError($benutzer = BenutzerListe::getById($_REQUEST['id'])))
    {
	$smarty->assign('message', $benutzer->getMessage()."<br/>".$benutzer->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }

$newpassword = randPasswd();
$newpassdcrf = hash('sha256', $newpassword);
$benutzer->setPassword($newpassdcrf);

if(MyError::isError($ergebnis = $benutzer->update()))
    {
	$smarty->assign('message', $benutzer->getMessage()."<br/>".$benutzer->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }


$smarty->assign('newpassword', $newpassword);


$smarty->assign('autor', $benutzer);

$smarty->addTemplate('content', '/private/passwdreset.tpl');

?>