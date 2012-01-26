<?php

if(!$_SESSION['benutzer']->getAuth() || !$_SESSION['benutzer']->getLogin())
    {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
    }


$smarty->addTemplate('content', 'private/home.tpl');

?>