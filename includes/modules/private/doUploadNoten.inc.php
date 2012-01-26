<?php
if(!$_SESSION['benutzer']->getLogin() || ($_SESSION['benutzer']->getRolle() != 2 && $_SESSION['benutzer']->getRolle() != 3))
  {
    	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
  }


if(!isset($_REQUEST['klasse']))
  {
    $smarty->addTemplate("content", "keinen_zugriff.tpl");
    return;
  }

if(MyError::isError($klasse = KlassenListe::getById($_REQUEST['klasse'])))
    {
	$smarty->assign('message', $klasse->getMessage()."<br/>".$klasse->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }
if($klasse == NULL)
  {
    $smarty->addTemplate("content", "keinen_zugriff.tpl");
    return;
  }

if(MyError::isError($schuelerliste = SchuelerListe::getByKlassennummer($_REQUEST['klasse'], $_SESSION['zeitraum']->getIdentNumber())))
    {
	$smarty->assign('message', $schuelerliste->getMessage()."<br/>".$schuelerliste->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }

foreach($_REQUEST['fach'] as $fachnummer)
  {
    if(MyError::isError($fachk = FachListe::getById($fachnummer)))
    {
	$smarty->assign('message', $fachk->getMessage()."<br/>".$fachk->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }
    if($fachk->getLehrernummer() != $_SESSION['benutzer']->getIdentNumber())
      {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
      }
  }

$con = AppDBO::getInstance();

if(!$con->beginTransaction())
  {
    $smarty->assign('message', 'Transaction begin error in line 56, doUploadNoten.inc.php <br />'.$con->getErrorMsg());
    $smarty->assign('err_type', 'error');
    $smarty->addTemplate('content', 'errors/message.tpl');
    return;
  }

$fachnummer = 0;


foreach($_REQUEST['fach'] as $fachnummer)
  {
    foreach($schuelerliste as $schueler)
      {
	if(isset($_REQUEST["".$schueler->getIdentNumber()."_".$fachnummer]))
	  {
	    $notenwert = $_REQUEST["".$schueler->getIdentNumber()."_".$fachnummer];
	    if($notenwert != "?" && $notenwert != "n.k." && $notenwert != "n. k." && $notenwert != "nk" && $notenwert != "n k" && (intval($notenwert) < 1 || intval($notenwert) > 10))
	      {
		$con->rollback();

		$smarty->mergeInto('js_scripts', 'jquery.js');

		$smarty->mergeInto('js_scripts', 'ui/jquery-ui.min.js');
		
		$smarty->mergeInto('stylesheets', 'css/redmond/redmond.css');
		
		$smarty->mergeInto('js_scripts', 'private/notenupload.js');
		
		if(MyError::isError($liste = KlassenListe::getByLehrernummer($_SESSION['benutzer']->getIdentNumber(), $_SESSION['zeitraum']->getIdentNumber())))
		  {
		    $smarty->assign('message', $liste->getMessage()."<br/>".$liste->getAdditionalInfo());
		    $smarty->assign('err_type', 'error');
		    $smarty->addTemplate('content', 'errors/message.tpl');
		    return;
		  }

		$smarty->assign('fehlermsg', "Ung&uuml;tige Noten eingegeben!!");
		
		$smarty->assign('klassenliste', $liste);
		
		$smarty->addTemplate('content', 'private/insertNoten.tpl');
		
		return;
	      }
	    if(intval($notenwert) > 1 && intval($notenwert) > 10)
	      {
		$notenwert = intval($notenwert);
	      }

	    $note = NULL;
	    if(MyError::isError($note = NotenListe::getBySchuelerFach($schueler->getIdentNumber(), $fachnummer)))
	      {
		$con->rollback();
		$smarty->assign('message', $note->getMessage()."<br/>".$note->getAdditionalInfo());
		$smarty->assign('err_type', 'error');
		$smarty->addTemplate('content', 'errors/message.tpl');
		return;
	      }
	    if($note == NULL)
	      {
		$note = new Noten();
		$note->setSchuelernummer($schueler->getIdentNumber());
		$note->setFachnummer($fachnummer); 
	      }
	    $note->setNote($notenwert);
	    if($note->getIdentNumber() == 0)
	      {
		if(MyError::isError($error = $note->insert()))
		  {
		    $con->rollback();
		    $smarty->assign('message', $error->getMessage()."<br/>".$error->getAdditionalInfo());
		    $smarty->assign('err_type', 'error');
		    $smarty->addTemplate('content', 'errors/message.tpl');
		    return;
		  }
	      }
	    else
	      {
		if(MyError::isError($error = $note->update()))
		  {
		    $con->rollback();
		    $smarty->assign('message', $error->getMessage()."<br/>".$error->getAdditionalInfo());
		    $smarty->assign('err_type', 'error');
		    $smarty->addTemplate('content', 'errors/message.tpl');
		    return;
		  }
	      }
	  }
      }
  }
$fachnummer = current($_REQUEST['fach']);

foreach($_REQUEST['fach'] as $fachkey)
  {
    if($fachkey < $fachnummer)
      {
	$fachnummer = $fachkey;
      }
  }
foreach($schuelerliste as $schueler)
  {
    if(isset($_REQUEST[$schueler->getIdentNumber()]))
      {
	$absenzwert = intval($_REQUEST[$schueler->getIdentNumber()]);
	if(intval($absenzwert) < 0)
	  {
	    $con->rollback();

	    $smarty->mergeInto('js_scripts', 'jquery.js');

	    $smarty->mergeInto('js_scripts', 'ui/jquery-ui.min.js');
		
	    $smarty->mergeInto('stylesheets', 'css/redmond/redmond.css');
		
	    $smarty->mergeInto('js_scripts', 'private/notenupload.js');
		
	    if(MyError::isError($liste = KlassenListe::getByLehrernummer($_SESSION['benutzer']->getIdentNumber(), $_SESSION['zeitraum']->getIdentNumber())))
	      {
		$smarty->assign('message', $liste->getMessage()."<br/>".$liste->getAdditionalInfo());
		$smarty->assign('err_type', 'error');
		$smarty->addTemplate('content', 'errors/message.tpl');
		return;
	      }

	    $smarty->assign('fehlermsg', "Ung&uuml;tige Absenz eingegeben!!");
		
	    $smarty->assign('klassenliste', $liste);
		
	    $smarty->addTemplate('content', 'private/insertNoten.tpl');
		
	    return;
	  }
	$absenz = NULL;
	if(MyError::isError($absenz = AbsenzenListe::getBySchuelerFach($schueler->getIdentNumber(), $fachnummer)))
	  {
	    $con->rollback();
	    $smarty->assign('message', $absenz->getMessage()."<br/>".$absenz->getAdditionalInfo());
	    $smarty->assign('err_type', 'error');
	    $smarty->addTemplate('content', 'errors/message.tpl');
	    return;
	  }
	if($absenz == NULL)
	  {
	    $absenz = new Absenzen();
	    $absenz->setSchuelernummer($schueler->getIdentNumber());
	    $absenz->setFachnummer($fachnummer); 
	  }

	$absenz->setAbsenzen($absenzwert);
	if($absenz->getIdentNumber() == 0)
	  {
	    if(MyError::isError($error = $absenz->insert()))
	      {
		$con->rollback();
		$smarty->assign('message', $error->getMessage()."<br/>".$error->getAdditionalInfo());
		$smarty->assign('err_type', 'error');
		$smarty->addTemplate('content', 'errors/message.tpl');
		return;
	      }
	  }
	else
	  {
	    if(MyError::isError($error = $absenz->update()))
	      {
		$con->rollback();
		$smarty->assign('message', $error->getMessage()."<br/>".$error->getAdditionalInfo());
		$smarty->assign('err_type', 'error');
		$smarty->addTemplate('content', 'errors/message.tpl');
		return;
	      }
	  }
      }
  }

if(!$con->commit())
  {
    $smarty->assign('message', 'Transaction commit error '.$con->getErrorMsg());
    $smarty->assign('err_type', 'error');
    $smarty->addTemplate('content', 'errors/message.tpl');
    return;
  }


$smarty->mergeInto('js_scripts', 'jquery.js');

$smarty->mergeInto('js_scripts', 'ui/jquery-ui.min.js');
		
$smarty->mergeInto('stylesheets', 'css/redmond/redmond.css');
		
$smarty->mergeInto('js_scripts', 'private/notenupload.js');
		
if(MyError::isError($liste = KlassenListe::getByLehrernummer($_SESSION['benutzer']->getIdentNumber(), $_SESSION['zeitraum']->getIdentNumber())))
  {
    $smarty->assign('message', $liste->getMessage()."<br/>".$liste->getAdditionalInfo());
    $smarty->assign('err_type', 'error');
    $smarty->addTemplate('content', 'errors/message.tpl');
    return;
  }

$smarty->assign('message', "Noten wurden eingetragen!!");
		
$smarty->assign('klassenliste', $liste);
		
$smarty->addTemplate('content', 'private/insertNoten.tpl');


?>