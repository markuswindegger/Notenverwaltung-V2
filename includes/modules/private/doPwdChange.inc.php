<?php

$smarty->mergeInto('js_scripts', 'jquery.js');

$smarty->mergeInto('js_scripts', 'private/script.js');

if(!$_SESSION['benutzer']->getAuth() || !$_SESSION['benutzer']->getLogin())
    {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
    }

$smarty->addTemplate('content', 'private/pwdChange.tpl');

?>