<?php

if(!isset($_SESSION['benutzer']) || ($_SESSION['benutzer']->getRolle() != 2 && $_SESSION['benutzer']->getRolle() != 3))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler bei der Authentifizierung, melden sie sich bitte neu an';
    echo json_encode($erg);
    return;
  }
if(!isset($_REQUEST['klassennummer']))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Bitte f&uuml;llen Sie alle Felder aus!';
    echo json_encode($erg);
    return;
  }

if(MyError::isError($klasse = KlassenListe::getById($_REQUEST['klassennummer'])))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage'.$klasse->getMessage()."<br />".$klasse->getAdditionalInfo();
    echo json_encode($erg);
    return;
  }

if($klasse == NULL)
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage';
    echo json_encode($erg);
    return;
  }

if(MyError::isError($fachliste = FachListe::getByLehrerKlasse($_SESSION['benutzer']->getIdentNumber(), $klasse->getIdentNumber(), $_SESSION['zeitraum']->getIdentNumber(), 1)))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage'.$fachliste->getMessage()."<br />".$fachliste->getAdditionalInfo();
    echo json_encode($erg);
    return;
  }

$smarty->assign('fachliste', $fachliste);

$html = $smarty->fetch('private/ajax/fachrequest.tpl');

$erg['error'] = 0;
$erg['html'] = $html;

echo json_encode($erg);

return;


?>