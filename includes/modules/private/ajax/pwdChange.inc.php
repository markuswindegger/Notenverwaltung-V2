<?php

if(!$_SESSION['benutzer']->getAuth() || !$_SESSION['benutzer']->getLogin())
    {
	$erg['error'] = -1;
	$erg['html'] = 'Fehler bei der Authentifizierung, melden sie sich bitte neu an';
	echo json_encode($erg);
	return;
    }
if(!isset($_REQUEST['oldPassword']) || !isset($_REQUEST['newPassword1']) || !isset($_REQUEST['newPassword2']))
    {
	$erg['error'] = -1;
	$erg['html'] = 'Bitte F&uuml;llen Sie alle Felder aus!';
	echo json_encode($erg);
	return;
    }

if(MyError::isError($ergebnis = $_SESSION['benutzer']->changePassword($_REQUEST['oldPassword'], $_REQUEST['newPassword1'], $_REQUEST['newPassword2'])))
    {
	$erg['error'] = -1;
	$erg['html'] = $ergebnis->getMessage();
	echo json_encode($erg);
	return;
    }
if(!$ergebnis)
    {
	$erg['error'] = -1;
	$erg['html'] = "Irgendein Fehler passierte, bitte admin kontaktieren!!!";
	echo json_encode($erg);
	return;
    }

$erg['error'] = -1;
$erg['html'] = "Das Passwort wurde erfolgreich ge&auml;ndert!";
echo json_encode($erg);
return;


?>