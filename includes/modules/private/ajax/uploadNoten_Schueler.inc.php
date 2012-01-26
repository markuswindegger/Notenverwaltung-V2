<?php

if(!isset($_SESSION['benutzer']) || ($_SESSION['benutzer']->getRolle() != 2 && $_SESSION['benutzer']->getRolle() != 3))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler bei der Authentifizierung, melden sie sich bitte neu an';
    echo json_encode($erg);
    return;
  }
if(!isset($_REQUEST['fachnummer']))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Bitte f&uuml;llen Sie alle Felder aus!';
    echo json_encode($erg);
    return;
  }
if(MyError::isError($fach = FachListe::getById($_REQUEST['fachnummer'])))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage '.$Fach->getMessage()."<br />".$Fach->getAdditionalInfo();
    echo json_encode($erg);
    return;
  }
if($fach == NULL)
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbank bei der Abfrage nach der Klasse!';
    echo json_encode($erg);
    return;
  }
if(MyError::isError($klasse = KlassenListe::getById($fach->getKlassennummer())))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage'.$klasse->getMessage()."<br />".$klasse->getAdditionalInfo();
    echo json_encode($erg);
    return;
  }
if($klasse == NULL)
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage bei Abfrage auf Klasse';
    echo json_encode($erg);
    return;
  }
if(MyError::isError($fachliste = FachListe::getByKlassenNameLehrer($fach->getName(), $klasse->getIdentNumber(), $_SESSION['benutzer']->getIdentNumber(), $_SESSION['zeitraum']->getIdentNumber())))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage '.$fachliste->getMessage()."<br />".$fachliste->getAdditionalInfo();
    echo json_encode($erg);
    return;
  }
if(MyError::isError($schuelerliste = SchuelerListe::getByKlassennummer($klasse->getIdentNumber(), $_SESSION['zeitraum']->getIdentNumber())))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage '.$schuelerliste->getMessage()."<br />".$schuelerliste->getAdditionalInfo();
    echo json_encode($erg);
    return;
  }

$fachtypliste[1] = "schriftlich";
$fachtypliste[2] = "m&uuml;ndlich";
$fachtypliste[3] = "praktisch";

$absenzen = 0;

$notenliste = array();

$absenzenfach = current($fachliste)->getIdentNumber();

foreach($fachliste as $fach)
  {
    if(MyError::isError($notenlistefach = NotenListe::getByFachnummerSort($fach->getIdentNumber())))
      {
	$erg['error'] = -1;
	$erg['html'] = 'Fehler in der Datenbankabfrage '.$notenliste->getMessage()."<br />".$notenliste->getAdditionalInfo();
	echo json_encode($erg);
	return;
      }
    $notenliste[$fach->getIdentNumber()] = $notenlistefach;

    if ($fach->getAbsenzen() == 1)
      {
	$absenzen = 1;
      }
    if($absenzenfach > $fach->getIdentNumber())
      {
	$absenzenfach = $fach->getIdentNumber();
      }

  }

if(MyError::isError($absenzliste = AbsenzenListe::getByFachnummerSort($absenzenfach)))
      {
	$erg['error'] = -1;
	$erg['html'] = 'Fehler in der Datenbankabfrage '.$notenliste->getMessage()."<br />".$notenliste->getAdditionalInfo();
	echo json_encode($erg);
	return;
      }

$smarty->assign("absenzliste", $absenzliste);

$smarty->assign("notenliste", $notenliste);

$smarty->assign("fachtypliste", $fachtypliste);

$smarty->assign("absenzen", $absenzen);

$smarty->assign('fachliste', $fachliste);

$smarty->assign('schuelerliste', $schuelerliste);

$smarty->assign('klasse', $klasse);



$html = $smarty->fetch('private/ajax/schuelerliste_noten.tpl');

$erg['error'] = 0;
$erg['html'] = $html;

echo json_encode($erg);

return;


?>