<?php
if(!$_SESSION['benutzer']->getLogin() || ($_SESSION['benutzer']->getRolle() != 2 && $_SESSION['benutzer']->getRolle() != 3))
  {
    	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
  }


if(!isset($_REQUEST['vorstandnummer']))
  {
    $smarty->addTemplate("content", "keinen_zugriff.tpl");
    return;
  }

if(MyError::isError($vorstand = VorstandListe::getById($_REQUEST['vorstandnummer'])))
    {
	$smarty->assign('message', $klasse->getMessage()."<br/>".$klasse->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }
if($vorstand == NULL)
  {
    $smarty->addTemplate("content", "keinen_zugriff.tpl");
    return;
  }

if(MyError::isError($schuelerliste = SchuelerListe::getByKlassennummer($vorstand->getKlassennummer(), $_SESSION['zeitraum']->getIdentNumber())))
    {
	$smarty->assign('message', $schuelerliste->getMessage()."<br/>".$schuelerliste->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }

if($vorstand->getLehrernummer() != $_SESSION['benutzer']->getIdentNumber())
  {
    $smarty->addTemplate("content", "keinen_zugriff.tpl");
    return;
  }


$con = AppDBO::getInstance();

if(!$con->beginTransaction())
  {
    $smarty->assign('message', 'Transaction begin error in line 56, doUploadNoten.inc.php <br />'.$con->getErrorMsg());
    $smarty->assign('err_type', 'error');
    $smarty->addTemplate('content', 'errors/message.tpl');
    return;
  }


foreach($schuelerliste as $schueler)
  {
    if(isset($_REQUEST["abs_".$schueler->getIdentNumber()]) && isset($_REQUEST["betr_".$schueler->getIdentNumber()]))
      {
	$absenzwert = intval($_REQUEST["abs_".$schueler->getIdentNumber()]);
	$betragenwert = intval($_REQUEST["betr_".$schueler->getIdentNumber()]);
	if($absenzwert < 0 || $betragenwert < 0)
	  {
	    $con->rollback();

	    $smarty->mergeInto('js_scripts', 'jquery.js');

	    $smarty->mergeInto('js_scripts', 'ui/jquery-ui.min.js');

	    $smarty->mergeInto('stylesheets', 'css/redmond/redmond.css');

	    $smarty->mergeInto('js_scripts', 'private/betragenupload.js');

	    if(MyError::isError($vorstandliste = VorstandListe::getByLehrernummer($_SESSION['benutzer']->getIdentNumber(), $_SESSION['zeitraum']->getIdentNumber())))
	      {
		$smarty->assign('message', $vorstandliste->getMessage()."<br/>".$vorstandliste->getAdditionalInfo());
		$smarty->assign('err_type', 'error');
		$smarty->addTemplate('content', 'errors/message.tpl');
		return;
	      }

	    if(MyError::isError($klassenliste = KlassenListe::getList()))
	      {
		$smarty->assign('message', $klassenliste->getMessage()."<br/>".$klassenliste->getAdditionalInfo());
		$smarty->assign('err_type', 'error');
		$smarty->addTemplate('content', 'errors/message.tpl');
		return;
	      }

	    $smarty->assign('fehlermsg', 'Bitte &uuml;berpr&uuml;fen Sie die Eingabe, sie war nicht korrekt!');

	    $smarty->assign('klassenliste', $klassenliste);

	    $smarty->assign('vorstandliste', $vorstandliste);

	    $smarty->addTemplate('content', 'private/insertBetragen.tpl');
		
	    return;
	  }

	$betragen = NULL;
	if(MyError::isError($betragen = BetragenListe::getBySchuelernummer($schueler->getIdentNumber())))
	  {
	    $con->rollback();
	    $smarty->assign('message', $betragen->getMessage()."<br/>".$betragen->getAdditionalInfo());
	    $smarty->assign('err_type', 'error');
	    $smarty->addTemplate('content', 'errors/message.tpl');
	    return;
	  }
	if($betragen == NULL)
	  {
	    $betragen = new Betragen();
	    $betragen->setSchuelernummer($schueler->getIdentNumber());
	    $betragen->setVorstandnummer($vorstand->getIdentNumber()); 
	  }
	$betragen->setAbsenzen($absenzwert);
	$betragen->setBetragen($betragenwert);
	if($betragen->getIdentNumber() == 0)
	  {
	    if(MyError::isError($error = $betragen->insert()))
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
	    if(MyError::isError($error = $betragen->update()))
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

$smarty->mergeInto('js_scripts', 'private/betragenupload.js');

if(MyError::isError($vorstandliste = VorstandListe::getByLehrernummer($_SESSION['benutzer']->getIdentNumber(), $_SESSION['zeitraum']->getIdentNumber())))
  {
    $smarty->assign('message', $vorstandliste->getMessage()."<br/>".$vorstandliste->getAdditionalInfo());
    $smarty->assign('err_type', 'error');
    $smarty->addTemplate('content', 'errors/message.tpl');
    return;
  }

if(MyError::isError($klassenliste = KlassenListe::getList()))
  {
    $smarty->assign('message', $klassenliste->getMessage()."<br/>".$klassenliste->getAdditionalInfo());
    $smarty->assign('err_type', 'error');
    $smarty->addTemplate('content', 'errors/message.tpl');
    return;
  }

$smarty->assign('message', "Die Absenzen und Betragensnoten wurden erfolgreich eingetragen!");

$smarty->assign('klassenliste', $klassenliste);

$smarty->assign('vorstandliste', $vorstandliste);

$smarty->addTemplate('content', 'private/insertBetragen.tpl');



?>