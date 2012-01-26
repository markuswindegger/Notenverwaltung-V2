<?php

if(!isset($_SESSION['benutzer']) || $_SESSION['benutzer']->getRolle() != 1)
    {
	$erg['error'] = -1;
	$erg['html'] = 'Fehler bei der Authentifizierung, melden sie sich bitte neu an';
	echo json_encode($erg);
	return;
    }
if(!isset($_REQUEST['zeitraumnummer']))
    {
	$erg['error'] = -1;
	$erg['html'] = 'Bitte f&uuml;llen Sie alle Felder aus!';
	echo json_encode($erg);
	return;
    }

if(MyError::isError($klassenliste = KlassenListe::getByZeitraumnummer($_REQUEST['zeitraumnummer'])))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Die Abfrage konnte nicht ausgef&uuml;hrt werden!<br />'.$klassenliste->getMessage()."<br />".$klassenliste->getAdditionalInfo();
    echo json_encode($erg);
    return;    
  }
if($klassenliste == NULL)
  {
    $erg['error'] = -1;
    $erg['html'] = 'Es wurden keine Klassen gefunden';
    echo json_encode($erg);
    return;

  }

$smarty->assign('klassenliste',$klassenliste);

$html = $smarty->fetch('private/ajax/klassenliste.tpl');

$erg['error'] = 0;
$erg['html'] = $html;

echo json_encode($erg);

return;


?>