<?php

if(!isset($_SESSION['benutzer']) || ($_SESSION['benutzer']->getRolle() != 2 && $_SESSION['benutzer']->getRolle() != 3))
  {
    echo 'Fehler bei der Authentifizierung, melden sie sich bitte neu an';
    exit;
  }
if(!isset($_REQUEST['vorstandnummer']))
  {
    echo 'Bitte f&uuml;llen Sie alle Felder aus!';
    exit;
  }
if(MyError::isError($vorstand = VorstandListe::getById($_REQUEST['vorstandnummer'])))
  {
    echo 'Fehler in der Datenbankabfrage '.$vorstand->getMessage()."<br />".$vorstand->getAdditionalInfo();
    exit;
  }
if($vorstand == NULL)
  {
    echo 'Fehler in der Datenbank bei der Abfrage nach der Klasse!';
    exit;
  }

if(MyError::isError($schuelerliste = SchuelerListe::getByKlassennummer($vorstand->getKlassennummer(), $_SESSION['zeitraum']->getIdentNumber())))
  {
    echo 'Fehler in der Datenbankabfrage '.$schuelerliste->getMessage()."<br />".$schuelerliste->getAdditionalInfo();
    exit;
  }

if(MyError::isError($betragenliste = BetragenListe::getByVorstandnummerOrder($vorstand->getIdentNumber())))
  {
    echo 'Fehler in der Datenbankabfrage '.$betragenliste->getMessage()."<br />".$betragen->getAdditionalInfo();
    exit;
  }


$smarty->assign('schuelerliste', $schuelerliste);

$smarty->assign('betragenliste', $betragenliste);

$smarty->assign('vorstandnummer', $_REQUEST['vorstandnummer']);

echo $smarty->fetch('private/print_betragen.tpl');

exit;

?>