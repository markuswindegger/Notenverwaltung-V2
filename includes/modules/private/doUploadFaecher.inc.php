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
	    $zeilennummer=0;
	    while($zeile=fgets($datei))
	      {
		++$zeilennummer;
		$daten=explode($_POST['trennzeichen'], $zeile);
		if(sizeof($daten) == 7)
		  {
		    $daten[6] = substr($daten[6], 0, strlen($daten[6])-1);
		  }
		$stufe = substr($daten[4], 0, 1);
		$zug = substr($daten[4], -1, 1);
		$fachrichtung = substr($daten[4], strpos($daten[4], " "), strlen($daten[4]) - (strpos($daten[4], " ") + 2));
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
		
		$vorname_lehrer = trim($daten[3]);
		$nachname_lehrer = trim($daten[2]);
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
		$fach->setName($daten[0]);
		if($daten[5] == 1)
		  {
		    $fach->setAbsenzen(1);
		  }
		else
		  {
		    $fach->setAbsenzen(0);
		  }
		
		
		//Bestimmen ob fach schriftlich, muendlich oder praktisch oder alles
		$schriftlich = stripos($daten[1], "s");
		if($schriftlich === false)
		  $schriftlich = stripos($daten[1], "g");
		$muendlich = stripos($daten[1], "m");
		$praktisch = stripos($daten[1], "p");
		if(trim($daten[1]) == "")
		  $schriftlich = 13;
		if($schriftlich !== false)
		  {
		    $fach->setFachtypnummer(1);
		    if(MyError::isError($error = $fach->insert()))
		      {
			@$con->rollback();
			$smarty->assign('fehlermsg', $error->getMessage()."<br/>".$error->getAdditionalInfo()."<br />Zeilennummer: ".$zeilennummer);
			
			$smarty->addTemplate('content', 'private/uploadFaecher.tpl');
			return;
		      }
		  }
		if($muendlich !== false)
		  {
		    $fach->setFachtypnummer(2);
		    if(MyError::isError($error = $fach->insert()))
		      {
			@$con->rollback();
			if($error->getMessage() == "prepare_error" && strstr($error->getAdditionalInfo(), "23000: Duplicate"))
			  {
			    $smarty->assign('fehlermsg', "Benutzername schon vorhanden!<br />".$error->getAdditionalInfo()."<br />Zeilennummer: ".$zeilennummer);
			    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
			  }
			else
			  {
			    $smarty->assign('fehlermsg', $error->getMessage()."<br/>".$error->getAdditionalInfo()."<br />Zeilennummer: ".$zeilennummer);
			    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
			  }
			return;
		      }
		  }
		if($praktisch !== false)
		  {
		    $fach->setFachtypnummer(3);
		    if(MyError::isError($error = $fach->insert()))
		      {
			@$con->rollback();
			if($error->getMessage() == "prepare_error" && strstr($error->getAdditionalInfo(), "23000: Duplicate"))
			  {
			    $smarty->assign('fehlermsg', "Benutzername schon vorhanden!<br />".$error->getAdditionalInfo()."<br />Zeilennummer: ".$zeilennummer);
			    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
			  }
			else
			  {
			    $smarty->assign('fehlermsg', $error->getMessage()."<br/>".$error->getAdditionalInfo()."<br />Zeilennummer: ".$zeilennummer);
			    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
			  }
			return;
		      }
		  }
		if($daten[6] == 1)
		  {
		    $lehrer->setRolle(3);
		    if(MyError::isError($error = $lehrer->update()))
		      {
			@$con->rollback();
			if($error->getMessage() == "prepare_error" && strstr($error->getAdditionalInfo(), "23000: Duplicate"))
			  {
			    $smarty->assign('fehlermsg', "Benutzername schon vorhanden!<br />".$error->getAdditionalInfo()."<br />Zeilennummer: ".$zeilennummer);
			    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
			  }
			else
			  {
			    $smarty->assign('fehlermsg', $error->getMessage()."<br/>".$error->getAdditionalInfo()."<br />Zeilennummer: ".$zeilennummer);
			    $smarty->addTemplate('content', 'private/uploadFaecher.tpl');
			  }
			return;
		      }
		    $vorstand = new Vorstand();
		    $vorstand->setLehrernummer($lehrer->getIdentNumber());
		    $vorstand->setKlassennummer($klasse->getIdentNumber());
		    $vorstand->setZeitraumnummer($semester->getIdentNumber());
		    if(MyError::isError($error = $vorstand->insert()))
		      {
			@$con->rollback();
			$smarty->assign('fehlermsg', $error->getMessage()."<br/>".$error->getAdditionalInfo()."<br />Zeilennummer: ".$zeilennummer);
			$smarty->addTemplate('content', 'private/uploadFaecher.tpl');
			return;
		      }
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

$smarty->assign('message', "Dei Faecher wurden erfolgreich importiert!");

$smarty->addTemplate('content', 'private/uploadFaecher.tpl');

?>