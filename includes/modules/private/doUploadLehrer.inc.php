<?php

if($_SESSION['benutzer']->getRolle() != 1)
    {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
    }

if(!isset($_REQUEST['trennzeichen']) || trim($_REQUEST['trennzeichen']) == "")
  {
    $smarty->assign('fehlermsg', "Ung&uuml;ltiges Trennzeichen");
    $smarty->addTemplate('content', 'private/uploadLehrer.tpl');
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
		$smarty->assign('message', $con->getErrorMsg()."<br/>");
		$smarty->assign('err_type', 'error');
		$smarty->addTemplate('content', 'errors/message.tpl');
		return;
	      }
	    $zeile="";
	    while($zeile=fgets($datei))
	      {
		$daten=explode($_POST['trennzeichen'], $zeile);
		if(sizeof($daten) > 3)
		  {
		    $lehrer = new Benutzer();
		    $lehrer->setNachname($daten[1]);
		    $lehrer->setName($daten[0]);
		    $lehrer->setUser($daten[2]);
		    if(sizeof($daten) == 4)
		      {
			$pwdhash = hash("sha256", substr($daten[3], 0, strlen($daten[3])-1));
		      }
		    else
		      {
			$pwdhash = hash("sha256", $daten[3]);
		      }
		    $lehrer->setPassword($pwdhash);
		    $lehrer->setRolle(2);
		    if(MyError::isError($error = $lehrer->insert()))
		      {
			@$con->rollback();
			if($error->getMessage() == "prepare_error" && strstr($error->getAdditionalInfo(), "23000: Duplicate"))
			  {
			    $smarty->assign('fehlermsg', "Benutzername schon vorhanden!<br />".$error->getAdditionalInfo());
			    $smarty->addTemplate('content', 'private/uploadLehrer.tpl');
			  }
			else
			  {
			    $smarty->assign('fehlermsg', $error->getMessage()."<br/>".$error->getAdditionalInfo());
			    $smarty->addTemplate('content', 'private/uploadLehrer.tpl');
			  }
			return;
		      }
		    ++$anz_personen;
		  }
		else
		  {
		    @$con->rollback();
		    $smarty->assign("fehlermsg", "Die Datei ist Fehlerhaft (evtl Leerzeilen l&ouml;schen).");
		    fclose($datei);
		    $smarty->addTemplate("content", "private/uploadLehrer.tpl");
		    return;
		  }
	      }
	  }
	else 
	  {
	    $smarty->assign("fehlermsg", "Fehler beim Dateiupload!");
	    $smarty->addTemplate("content", "private/uploadLehrer.tpl");
	    return;
	  }
      }
    else 
      {
	$smarty->assign("fehlermsg", "Fehler beim Dateiupload!");
	$smarty->addTemplate("content", "private/uploadLehrer.tpl");
	return;
      }
  }
else
  {
    $smarty->assign("fehlermsg", "Fehler beim Dateiupload!");
    $smarty->addTemplate("content", "private/uploadLehrer.tpl");
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






if(MyError::isError($liste = BenutzerListe::getList()))
    {
	$smarty->assign('message', $liste->getMessage()."<br/>".$liste->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }


$rollen[1] = "Administrator";
$rollen[2] = "Lehrer";
$rollen[3] = "Klassenvorstand";
$rollen[4] = "Verwalter";

$con = AppDBO::getInstance();

$smarty->assign('anzahlpersonen', $anz_personen);

$smarty->assign('benutzerliste', $liste);

$smarty->assign('rollenliste', $rollen);

$smarty->addTemplate('content', 'private/benutzerliste.tpl');

?>