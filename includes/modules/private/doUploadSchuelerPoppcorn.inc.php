<?php

if($_SESSION['benutzer']->getRolle() != 1)
    {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
    }

$smarty->mergeInto('js_scripts', 'jquery.js');

$smarty->mergeInto('js_scripts', 'private/schueleruploadpoppcorn.js');

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
    $smarty->addTemplate('content', 'private/uploadSchuelerPoppcorn.tpl');
    return;
  }

if(!isset($_REQUEST['zeitraumnummer']) || trim($_REQUEST['zeitraumnummer']) == "")
  {
    $smarty->assign('fehlermsg', "Ung&uuml;ltiges Trennzeichen");
    $smarty->addTemplate('content', 'private/uploadSchuelerPoppcorn.tpl');
    return;
  }

if(MyError::isError($semester = ZeitraumListe::getById($_REQUEST['zeitraumnummer'])) || $semester == NULL)
  {
    $smarty->assign('fehlermsg', "Ung&uuml;ltiges Semester");
    $smarty->addTemplate('content', 'private/uploadSchuelerPoppcorn.tpl');
    return;
  }


	
if (isset($_FILES["datei"]))
  {
    if ($_FILES["datei"]["error"] == UPLOAD_ERR_OK)
      {
	if ($_FILES["datei"]["size"] > 0 && $_FILES["datei"]["size"] < 100000000) 
	  {
	    $datei=fopen($_FILES["datei"]["tmp_name"], "r");
	    $anz_personen=0;
	    $con = AppDBO::getInstance();
	    if(!$con->beginTransaction())
	      {
		$smarty->assign('fehlermsg', 'Fehler beim Beginnen der Transaktion: '.$con->getErrorMsg());
		$smarty->addTemplate('content', 'private/uploadSchuelerPoppcorn.tpl');
		return;
	      }
	    $zeile=fgets($datei);
	    while($zeile=fgets($datei))
	      {
		$daten=explode($_POST['trennzeichen'], $zeile);
		$stufe = substr($daten[4], 0, 1);
		$zug = substr($daten[4], -1, 1);
		$fachrichtung = substr($daten[4], strpos($daten[4], " "), strlen($daten[4]) - (strpos($daten[4], " ") + 2));
		if(MyError::isError($klasse = KlassenListe::getByName($stufe, $fachrichtung, $zug)))
		  {
		    @$con->rollback();
		    $smarty->assign('fehlermsg', 'Fehler beim Holen der Klasse');
		    $smarty->addTemplate('content', 'private/uploadSchuelerPoppcorn.tpl');
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
			$smarty->assign('fehlermsg', 'Fehler beim Einf&uuml;gen der Klasse<br />'.$error->getMessage()."<br />".$error->getAdditionalInfo());
			$smarty->addTemplate('content', 'private/uploadSchuelerPoppcorn.tpl');
			return;
		      }
		  }
		
		$schueler = new Schueler();
		
		$schueler->setName($daten[6]);
		$schueler->setNachname($daten[5]);
		$schueler->setKlassennummer($klasse->getIdentNumber());
		$schueler->setZeitraumnummer($semester->getIdentNumber());
		
		if(MyError::isError($error = $schueler->insert()))
		  {
		    @$con->rollback();
		    $smarty->assign('fehlermsg', 'Fehler beim Einf&uuml;gen des Sch&uuml;lers<br />'.$error->getMessage()."<br />".$error->getAdditionalInfo());
		    $smarty->addTemplate('content', 'private/uploadSchuelerPoppcorn.tpl');
		    return;
		  }
	      }
	  }
	else 
	  {
	    $smarty->assign("fehlermsg", "Fehler beim Dateiupload!");
	    $smarty->addTemplate("content", "private/uploadSchuelerPoppcorn.tpl");
	    return;
	  }
      }
    else 
      {
	$smarty->assign("fehlermsg", "Fehler beim Dateiupload!");
	$smarty->addTemplate("content", "private/uploadSchuelerPoppcorn.tpl");
	return;
      }
  }
else
  {
    $smarty->assign("fehlermsg", "Fehler beim Dateiupload!");
    $smarty->addTemplate("content", "private/uploadSchuelerPoppcorn.tpl");
    return;
  }

if(!$con->commit())
  {
    @$con->rollback();
    $smarty->assign('message', $con->getErrorMsg()."<br/>");
    $smarty->assign('err_type', 'error');
    $smarty->addTemplate('content', 'errors/message.tpl');
    return;
  }
fclose($datei);



$smarty->assign('message', "Die Sch&uuml;ler wurden erfolgreich importiert!");

$smarty->addTemplate('content', 'private/uploadSchuelerPoppcorn.tpl');

?>