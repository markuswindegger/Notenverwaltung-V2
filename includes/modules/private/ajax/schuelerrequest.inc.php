<?php

if(!isset($_SESSION['benutzer']) || $_SESSION['benutzer']->getRolle() != 1)
    {
	$erg['error'] = -1;
	$erg['html'] = 'Fehler bei der Authentifizierung, melden sie sich bitte neu an';
	echo json_encode($erg);
	return;
    }
if(!isset($_REQUEST['klassennummer']) || !isset($_REQUEST['zeitraumnummer']))
    {
	$erg['error'] = -1;
	$erg['html'] = 'Bitte f&uuml;llen Sie alle Felder aus!';
	echo json_encode($erg);
	return;
    }

if(MyError::isError($schuelerliste = SchuelerListe::getByKlassennummer($_REQUEST['klassennummer'], $_REQUEST['zeitraumnummer'])))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Die Abfrage konnte nicht ausgef&uuml;hrt werden!';
    echo json_encode($erg);
    return;    
  }
if($schuelerliste == NULL)
  {
    $erg['error'] = -1;
    $erg['html'] = 'Es wurden keine Sch&uuml;ler gefunden';
    echo json_encode($erg);
    return;

  }
if(MyError::isError($klasse = KlassenListe::getById($_REQUEST['klassennummer'])))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Die Abfrage konnte nicht ausgef&uuml;hrt werden!';
    echo json_encode($erg);
    return;
  }

$smarty->assign('schuelerliste',$schuelerliste);

$smarty->assign('klasse', $klasse);

$html = $smarty->fetch('private/ajax/schuelerliste.tpl');

$erg['error'] = 0;
$erg['html'] = $html;

echo json_encode($erg);

return;


?>