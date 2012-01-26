<?php

if($_SESSION['benutzer']->getRolle() != 1)
    {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
    }

$smarty->addTemplate('content', 'private/uploadLehrer.tpl');

?>