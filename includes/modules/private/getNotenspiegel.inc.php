<?php

if(!isset($_SESSION['benutzer']) || ($_SESSION['benutzer']->getRolle() != 2 && $_SESSION['benutzer']->getRolle() != 3))
  {
    echo 'Fehler bei der Authentifizierung, melden sie sich bitte neu an';
    exit;
  }
if(!isset($_REQUEST['fachnummer']))
  {
    echo 'Bitte f&uuml;llen Sie alle Felder aus!';
    exit;
  }
if(MyError::isError($fach = FachListe::getById($_REQUEST['fachnummer'])))
  {
    echo 'Fehler in der Datenbankabfrage '.$Fach->getMessage()."<br />".$Fach->getAdditionalInfo();
    exit;
  }
if($fach == NULL)
  {
    echo 'Fehler in der Datenbank bei der Abfrage nach der Klasse!';
    exit;
  }
if(MyError::isError($klasse = KlassenListe::getById($fach->getKlassennummer())))
  {
    echo 'Fehler in der Datenbankabfrage'.$klasse->getMessage()."<br />".$klasse->getAdditionalInfo();
    exit;
  }
if($klasse == NULL)
  {
    echo 'Fehler in der Datenbankabfrage bei Abfrage auf Klasse';
    exit;
  }
if(MyError::isError($fachliste = FachListe::getByKlassenNameLehrer($fach->getName(), $klasse->getIdentNumber(), $_SESSION['benutzer']->getIdentNumber(), $_SESSION['zeitraum']->getIdentNumber())))
  {
    echo 'Fehler in der Datenbankabfrage '.$fachliste->getMessage()."<br />".$fachliste->getAdditionalInfo();
    exit;
  }
if(MyError::isError($schuelerliste = SchuelerListe::getByKlassennummer($klasse->getIdentNumber(), $_SESSION['zeitraum']->getIdentNumber())))
  {
    echo 'Fehler in der Datenbankabfrage '.$schuelerliste->getMessage()."<br />".$schuelerliste->getAdditionalInfo();
    exit;
  }

$fachtypliste[1] = "schriftlich";
$fachtypliste[2] = "m&uuml;dlich";
$fachtypliste[3] = "praktisch";

$absenzen = 0;

$notenliste = array();

$absenzenfach = current($fachliste)->getIdentNumber();

foreach($fachliste as $fach)
  {
    if(MyError::isError($notenlistefach = NotenListe::getByFachnummerSort($fach->getIdentNumber())))
      {
	echo 'Fehler in der Datenbankabfrage '.$notenliste->getMessage()."<br />".$notenliste->getAdditionalInfo();
	exit;
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
	echo 'Fehler in der Datenbankabfrage '.$notenliste->getMessage()."<br />".$notenliste->getAdditionalInfo();
	exit;
      }

$smarty->assign("fachnummer", $_REQUEST['fachnummer']);

$smarty->assign("absenzliste", $absenzliste);

$smarty->assign("notenliste", $notenliste);

$smarty->assign("fachtypliste", $fachtypliste);

$smarty->assign("absenzen", $absenzen);

$smarty->assign('fachliste', $fachliste);

$smarty->assign('schuelerliste', $schuelerliste);

$smarty->assign('klasse', $klasse);



echo $smarty->fetch('private/print.tpl');

exit;

?>