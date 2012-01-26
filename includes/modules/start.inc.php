<?php


if(MyError::isError($benutzerliste = BenutzerListe::getList()))
    {
	$smarty->assign('message', $textliste->getMessage()."<br/>".$textliste->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }

$smarty->assign('autorenliste', $benutzerliste);


$smarty->addTemplate('content', 'start.tpl');


?>