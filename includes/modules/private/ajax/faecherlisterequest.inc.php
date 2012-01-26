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


if(MyError::isError($semester = ZeitraumListe::getById($_REQUEST['zeitraumnummer'])))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage '.$semester->getMessage()."<br />".$semester->getAdditionalInfo();
    echo json_encode($erg);
    return;
  }


if(MyError::isError($faecherliste = FachListe::getOrderByKlasses($semester->getIdentNumber())))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage '.$faecherliste->getMessage()."<br />".$faecherliste->getAdditionalInfo();
    echo json_encode($erg);
    return;
  }

if(MyError::isError($lehrerliste = BenutzerListe::getList()))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage '.$lehrerliste->getMessage()."<br />".$lehrerliste->getAdditionalInfo();
    echo json_encode($erg);
    return;
  }

if(MyError::isError($klassenliste = KlassenListe::getList()))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage '.$klassenliste->getMessage()."<br />".$klassenliste->getAdditionalInfo();
    echo json_encode($erg);
    return;
  }


$fachtypliste=array();
$fachtypliste[1] = "schriftlich";
$fachtypliste[2] = "m&uuml;ndlich";
$fachtypliste[3] = "praktisch";

$smarty->assign("semester", $semester);

$smarty->assign("faecherliste", $faecherliste);

$smarty->assign("lehrerliste", $lehrerliste);

$smarty->assign("fachtypliste", $fachtypliste);

$smarty->assign("klassenliste", $klassenliste);

$html = $smarty->fetch('private/ajax/faecherliste.tpl');

$erg['error'] = 0;
$erg['html'] = $html;

echo json_encode($erg);

return;


?>