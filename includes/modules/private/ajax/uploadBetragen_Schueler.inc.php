<?php

if(!isset($_SESSION['benutzer']) || ($_SESSION['benutzer']->getRolle() != 2 && $_SESSION['benutzer']->getRolle() != 3))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler bei der Authentifizierung, melden sie sich bitte neu an';
    echo json_encode($erg);
    return;
  }
if(!isset($_REQUEST['vorstandnummer']))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Bitte f&uuml;llen Sie alle Felder aus!';
    echo json_encode($erg);
    return;
  }
if(MyError::isError($vorstand = VorstandListe::getById($_REQUEST['vorstandnummer'])))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage '.$vorstand->getMessage()."<br />".$vorstand->getAdditionalInfo();
    echo json_encode($erg);
    return;
  }
if($vorstand == NULL)
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbank bei der Abfrage nach der Klasse!';
    echo json_encode($erg);
    return;
  }

if(MyError::isError($schuelerliste = SchuelerListe::getByKlassennummer($vorstand->getKlassennummer(), $_SESSION['zeitraum']->getIdentNumber())))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage '.$schuelerliste->getMessage()."<br />".$schuelerliste->getAdditionalInfo();
    echo json_encode($erg);
    return;
  }

if(MyError::isError($betragenliste = BetragenListe::getByVorstandnummerOrder($vorstand->getIdentNumber())))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage '.$betragenliste->getMessage()."<br />".$betragen->getAdditionalInfo();
    echo json_encode($erg);
    return;
  }

$smarty->assign('schuelerliste', $schuelerliste);

$smarty->assign('betragenliste', $betragenliste);

$smarty->assign('vorstandnummer', $_REQUEST['vorstandnummer']);



$html = $smarty->fetch('private/ajax/schuelerliste_betragen.tpl');

$erg['error'] = 0;
$erg['html'] = $html;

echo json_encode($erg);

return;


?>