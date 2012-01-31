<?php

if(!isset($_SESSION['benutzer']) || ($_SESSION['benutzer']->getRolle() != 1 && $_SESSION['benutzer']->getRolle() != 4))
    {
	echo 'Fehler bei der Authentifizierung, melden sie sich bitte neu an';
	exit;
    }
if(!isset($_REQUEST['klassennummer']) || !isset($_REQUEST['zeitraumnummer']))
    {
	echo 'Bitte f&uuml;llen Sie alle Felder aus!';
	exit;
    }
if(MyError::isError($klasse = KlassenListe::getById($_REQUEST['klassennummer'])))
  {
    echo 'Die Abfrage konnte nicht ausgef&uuml;hrt werden! Klassenliste: '.$klasse->getMessage()."<br />".$klasse->getAdditionalInfo();
    exit;
  }
if($klasse == NULL)
  {
    echo 'Die Klasse wurde nicht gefunden!!!';
    exit;
  }

if(MyError::isError($semester = ZeitraumListe::getById($_REQUEST['zeitraumnummer'])))
  {
    echo 'Die Abfrage konnte nicht ausgef&uuml;hrt werden! Zeitraumliste: '.$semester->getMessage()."<br />".$semester->getAdditionalInfo();
    exit;
  }
if($semester == NULL)
  {
    echo 'Die Klasse wurde nicht gefunden!!!';
    exit;
  }
if(MyError::isError($schuelerliste = SchuelerListe::getByKlassennummer($klasse->getIdentNumber(), $semester->getIdentNumber())))
  {
    echo 'Die Abfrage konnte nicht ausgef&uuml;hrt werden! Schuelerliste: '.$schuelerliste->getMessage()."<br />".$schuelerliste->getAdditionalInfo();
    exit;    
  }
if($schuelerliste == NULL)
  {
    echo 'Es wurden keine Sch&uuml;ler gefunden';
    exit;

  }
if(MyError::isError($fachliste = FachListe::getByKlassennummer($klasse->getIdentNumber(), $semester->getIdentNumber())))
  {
    echo 'Die Abfrage konnte nicht ausgef&uuml;hrt werden! Fachliste: '.$fachliste->getMessage()."<br />".$fachliste->getAdditionalInfo();
    exit;    
  }
if($fachliste == NULL)
  {
    echo 'Es wurden keine F&auml;cher gefunden';
    exit;

  }

$fachtypliste[1] = "schriftlich";
$fachtypliste[2] = "muendlich";
$fachtypliste[3] = "praktisch";

$notenliste = array();

$absenzenliste = array();

foreach($fachliste as $fach)
  {
    if(MyError::isError($notenlistefach = NotenListe::getByFachnummerSort($fach->getIdentNumber())))
      {
	$erg['html'] = 'Fehler in der Datenbankabfrage Notenliste: '.$notenlistefach->getMessage()."<br />".$notenlistefach->getAdditionalInfo();
	echo json_encode($erg);
	exit;
      }
    $notenliste[$fach->getIdentNumber()] = $notenlistefach;

    if ($fach->getAbsenzen() == 1)
      {
	if(MyError::isError($absenzenfach = AbsenzenListe::getByFachnummerSort($fach->getIdentNumber())))
	  {
	    $erg['html'] = 'Fehler in der Datenbankabfrage AbsenzenListe: '.$absenzenfach->getMessage()."<br />".$absenzenfach->getAdditionalInfo();
	    echo json_encode($erg);
	    exit;
	  }
	$absenzenliste[$fach->getIdentNumber()] = $absenzenfach;
      }
  }

if(MyError::isError($absenzenfaecher = FachListe::getAbsenzenFaecher($klasse->getIdentNumber(), $semester->getIdentNumber())))
      {
	echo 'Fehler in der Datenbankabfrage Vorstandliste: '.$absenzenfaecher->getMessage()."<br />".$absenzenfaecher->getAdditionalInfo();
	exit;
      }


if(MyError::isError($vorstand = VorstandListe::getByKlassennummer($klasse->getIdentNumber(), $semester->getIdentNumber())))
      {
	echo 'Fehler in der Datenbankabfrage Vorstandliste: '.$vorstand->getMessage()."<br />".$vorstand->getAdditionalInfo();
	exit;
      }


if(MyError::isError($betragenliste = BetragenListe::getByVorstandnummerOrder($vorstand->getIdentNumber(), $semester->getIdentNumber())))
      {
	echo 'Fehler in der Datenbankabfrage Betragenliste: '.$betragenliste->getMessage()."<br />".$betragenliste->getAdditionalInfo();
	exit;
      }
ob_clean();

header("Content-type: application/vnd.ms-excel");
header("Content-disposition:  attachment; filename=".$klasse->getStufe()."_".$klasse->getFachrichtung()."_".$klasse->getZug().".csv");


reset($fachliste);

$fachname = current($fachliste);

echo ";";

$anzahl = 0;
foreach($fachliste as $fach)
  {
    if($fachname->getName() == $fach->getName())
      {
	++$anzahl;
      }
    else
      {
	echo $fachname->getName().";";
	for($i = 0; $i < $anzahl; ++$i)
	  {
	    echo ";";
	  }
	$fachname = $fach;
	$anzahl = 1;
      }
  }

echo $fachname->getName();

echo "\nName des Schuelers;";

reset($fachliste);

$fachname = current($fachliste);

foreach($fachliste as $fach)
  {
    if($fachname->getName() == $fach->getName())
      {
	echo $fachtypliste[$fach->getFachtypnummer()].";";
      }
    else
      {
	echo "Absenzen;".$fachtypliste[$fach->getFachtypnummer()].";";
	$fachname = $fach;
      }
  }
echo "Absenzen;Betragen;Unentschuldigte Absenzen;Anzahl negativer Noten\n";

foreach($schuelerliste as $schueler)
  {
    echo $schueler->getNachname()." ".$schueler->getName().";";
    
    reset($absenzenfaecher);
    
    $fachname = current($absenzenfaecher);
    
    $anznegativ = 0;
    
    //echo count($notenliste)."\n";
    
    foreach($fachliste as $fach)
      {
	if($fachname->getName() == $fach->getName())
	  {
	    //Noten
	    if(isset($notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()]) && $notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()] instanceof Noten)
	      {
		echo $notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()]->getNote().";";
		if($notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()]->getNote() < 6 && 
		   $notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()]->getNote() != "?" && 
		   $notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()]->getNote() != "n.k.")
		  {
		    ++$anznegativ;
		  }
	      }
	    else
	      {
		echo "nicht eingetragen;";
	      }
	  }
	else
	  {
	    //Absenzen vorheriges Fach
	    if(isset($absenzenliste[$fachname->getIdentNumber()][$schueler->getIdentNumber()]) && $absenzenliste[$fachname->getIdentNumber()][$schueler->getIdentNumber()] instanceof Absenzen)
	      {
		echo $absenzenliste[$fachname->getIdentNumber()][$schueler->getIdentNumber()]->getAbsenzen().";";
	      }
	    else
	      {
		echo "nicht eingetragen;";
	      }
	    
	    $fachname = next($absenzenfaecher);

	    //Noten aktuelles Fach
	    if(isset($notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()]) && $notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()] instanceof Noten)
	      {
		echo $notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()]->getNote().";";
		if($notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()]->getNote() < 6&& 
		   $notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()]->getNote() != "?" && 
		   $notenliste[$fach->getIdentNumber()][$schueler->getIdentNumber()]->getNote() != "n.k.")
		  {
		    ++$anznegativ;
		  }
	      }
	    else
	      {
		echo "nicht eingetragen;";
	      }
	  }
      }

    
    if(isset($absenzenliste[$fachname->getIdentNumber()][$schueler->getIdentNumber()]) && $absenzenliste[$fachname->getIdentNumber()][$schueler->getIdentNumber()] instanceof Absenzen)
      {
	echo $absenzenliste[$fachname->getIdentNumber()][$schueler->getIdentNumber()]->getAbsenzen().";";
      }
    else
      {
	echo "nicht eingetragen;";
      }
    
    
    if(isset($betragenliste[$schueler->getIdentNumber()]) && $betragenliste[$schueler->getIdentNumber()] instanceof Betragen)
      {
	echo $betragenliste[$schueler->getIdentNumber()]->getBetragen().";";
    
	echo $betragenliste[$schueler->getIdentNumber()]->getAbsenzen().";";
      }
    else
      {
	echo "nicht eingetragen;nicht eingetragen;";
      }
    
    echo $anznegativ;
    
    echo "\n";
    
  }

exit;


?>