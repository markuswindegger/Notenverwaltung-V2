<?php

if($_SESSION['benutzer']->getRolle() != 1)
    {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
    }

$smarty->mergeInto('js_scripts', 'jquery.js');

$smarty->mergeInto('js_scripts', 'private/faecher.js');

if(MyError::isError($liste = ZeitraumListe::getList()))
    {
	$smarty->assign('message', $liste->getMessage()."<br/>".$liste->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }



$smarty->assign('semesterliste', $liste);

if(!isset($_REQUEST['trennzeichen']) || trim($_REQUEST['trennzeichen']) == "")
  {
    $smarty->assign('fehlermsg', "Ung&uuml;ltiges Trennzeichen");
    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
    return;
  }

if(!isset($_REQUEST['zeitraumnummer']) || trim($_REQUEST['zeitraumnummer']) == "")
  {
    $smarty->assign('fehlermsg', "Ung&uuml;ltiges Trennzeichen");
    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
    return;
  }

if(MyError::isError($semester = ZeitraumListe::getById($_REQUEST['zeitraumnummer'])) || $semester == NULL)
  {
    $smarty->assign('fehlermsg', "Ung&uuml;ltiges Semester");
    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
    return;
  }


	
if (isset($_FILES["datei"]))
  {
    if ($_FILES["datei"]["error"] == UPLOAD_ERR_OK)
      {
	if ($_FILES["datei"]["size"] > 0 && $_FILES["datei"]["size"] < 100000) 
	  {
	    $datei=fopen($_FILES["datei"]["tmp_name"], "r");
	    $anz_personen=0;
	    $con = AppDBO::getInstance();
	    
	    if(!$con->beginTransaction())
	      {
		$smarty->assign('fehlermsg', 'Fehler beim &Ouml;ffnen der Transaktion!');
		$smarty->addTemplate('content', 'private/uploadFaecher.tpl');
		return;
	      }

	    $zeile="";
	    $zeilennummer=2;
	    if(!$zeile = fgets($datei))
	      {
		@$con->rollback();		
		$smarty->assign('fehlermsg', 'Fehler in der Datei, keine g&uuml;ltigen Zeilen vorhanden!<br />Zeilennummer: '.$zeilennummer);
		$smarty->addTemplate('content', 'private/uploadFaecher.tpl');
		return;
	      }
	    while($zeile = fgets($datei))
	      {
		$daten=explode($_POST['trennzeichen'], $zeile);
		if(sizeof($daten) < 5)
		  {
		    @$con->rollback();		
		    $smarty->assign('fehlermsg', 'Fehler in der Datei, keine g&uuml;ltigen Zeilen vorhanden!<br />Zeilennummer: '.$zeilennummer);
		    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
		    return;
		  }
		$stufe = $daten[2];
		$zug = substr($daten[4], -1);
		$fachrichtung = $daten[0];
		if(MyError::isError($klasse = KlassenListe::getByName($stufe, $fachrichtung, $zug)))
		  {
		    @$con->rollback();		
		    $smarty->assign('fehlermsg', 'Fehler beim Holen der Klasse<br />'.$klasse->getAddtionalInfo()."<br />Zeilennummer: ".$zeilennummer);
		    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
		    return;
		  }
		if($klasse == NULL)
		  {
		    $klasse = new Klasse();
		    $klasse->setStufe($stufe);
		    $klasse->setFachrichtung($fachrichtung);
		    $klasse->setZug($zug);
		    if(MyError::isError($error = $klasse->insert()))
		      {
			@$con->rollback();
			$smarty->assign('fehlermsg', 'Fehler beim Einf&uuml;gen der Klasse<br />'.$error->getMessage()."<br />".$error->getAdditionalInfo()."<br />Zeilennummer: ".$zeilennummer);
			$smarty->addTemplate('content', 'private/uploadFaecher.tpl');
			return;
		      }
		  }
		$fachzeile = 10;
		$reihenfolge = 0;
		while (isset($daten[$fachzeile]) && $daten[$fachzeile] != "" && isset($daten[$fachzeile + 2]) && $daten[$fachzeile + 2] != "")
		  {
		    if($daten[$fachzeile] == "Verhalten")
		      {
			$vorname_lehrer = trim($daten[$fachzeile + 2]);
			$nachname_lehrer = trim($daten[$fachzeile + 1]);
			if(MyError::isError($lehrer = BenutzerListe::getByName($vorname_lehrer, $nachname_lehrer)))
			  {
			    @$con->rollback();
			    $smarty->assign('fehlermsg', 'Fehler beim Holen des Lehrers'."<br />Zeilennummer: ".$zeilennummer);
			    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
			    return;
			  }
			if($lehrer == NULL)
			  {
			    @$con->rollback();
			    $smarty->assign('fehlermsg', 'Benutzer nicht in Datenbank<br />Nachname: '.$nachname_lehrer."<br />Name: ".$vorname_lehrer."<br />Zeilennummer: ".$zeilennummer);
			    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
			    return;
			  }
			$lehrer->setRolle(3);
			if(MyError::isError($error = $lehrer->update()))
			  {
			    @$con->rollback();
			    $smarty->assign('fehlermsg', $error->getMessage()."<br/>".$error->getAdditionalInfo()."<br />Zeilennummer: ".$zeilennummer);
			    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
			    return;
			  }
			
			$vorstand = new Vorstand();
			$vorstand->setZeitraumnummer($semester->getIdentNumber());
			$vorstand->setKlassennummer($klasse->getIdentNumber());
			$vorstand->setLehrernummer($lehrer->getIdentNumber());

			if(MyError::isError($error = $vorstand->insert()))
			  {
			    @$con->rollback();
			    $smarty->assign('fehlermsg', $error->getMessage()."<br/>".$error->getAdditionalInfo()."<br />Zeilennummer: ".$zeilennummer);
			    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
			    return;
			  }
			
		      }
		    else
		      {
			$vorname_lehrer = trim($daten[$fachzeile + 2]);
			$nachname_lehrer = trim($daten[$fachzeile + 1]);
			if(MyError::isError($lehrer = BenutzerListe::getByName($vorname_lehrer, $nachname_lehrer)))
			  {
			    @$con->rollback();
			    $smarty->assign('fehlermsg', 'Fehler beim Holen des Lehrers'."<br />Zeilennummer: ".$zeilennummer);
			    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
			    return;
			  }
			if($lehrer == NULL)
			  {
			    @$con->rollback();
			    $smarty->assign('fehlermsg', 'Benutzer nicht in Datenbank<br />Nachname: '.$nachname_lehrer."<br />Name: ".$vorname_lehrer."<br />Zeilennummer: ".$zeilennummer);
			    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
			    return;
			  }
		    
			$fach = new Fach();
			$fach->setLehrernummer($lehrer->getIdentNumber());
			$fach->setKlassennummer($klasse->getIdentNumber());
			$fach->setZeitraumnummer($semester->getIdentNumber());
			$fach->setName($daten[$fachzeile]);
			$fach->setAbsenzen(1);
			$fach->setFachtypnummer(1);
		    
			if(MyError::isError($error = $fach->insert()))
			  {
			    @$con->rollback();
			    $smarty->assign('fehlermsg', $error->getMessage()."<br/>".$error->getAdditionalInfo()."<br />Zeilennummer: ".$zeilennummer);
			    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
			    return;
			  }
		      }
		    
		    $fachzeile += 3;
		    
		  }
	      }
	    
	  }
	else 
	  {
	    @$con->rollback();
	    $smarty->assign("fehlermsg", "Fehler beim Dateiupload!");
	    $smarty->addTemplate("content", "private/uploadFaecher.tpl");
	    return;
	  }
      }
    else 
      {
	@$con->rollback();
	$smarty->assign("fehlermsg", "Fehler beim Dateiupload!");
	$smarty->addTemplate("content", "private/uploadFaecher.tpl");
	return;
      }
  }
else
  {
    @$con->rollback();
    $smarty->assign("fehlermsg", "Fehler beim Dateiupload!");
    $smarty->addTemplate("content", "private/uploadFaecher.tpl");
    return;
  }
	
fclose($datei);

if(!$con->commit())
  {
    @$con->rollback();
    $smarty->assign("fehlermsg", "Fehler beim Best&auml;titgen der Datentransaktion!");
    $smarty->addTemplate("content", "private/uploadFaecher.tpl");
    return;
  }
$smarty->assign('message', "Die Faecher wurden erfolgreich importiert!");

$smarty->addTemplate('content', 'private/uploadFaecher.tpl');

?>