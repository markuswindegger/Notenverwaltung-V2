<?php

if($_SESSION['benutzer']->getRolle() != 1)
    {
	$smarty->addTemplate("content", "keinen_zugriff.tpl");
	return;
    }

if(MyError::isError($liste = ZeitraumListe::getList()))
    {
	$smarty->assign('message', $liste->getMessage()."<br/>".$liste->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }


$smarty->mergeInto('js_scripts', 'jquery.js');

$smarty->mergeInto('js_scripts', 'ui/jquery-ui.min.js');

$smarty->mergeInto('stylesheets', 'css/redmond/redmond.css');

$smarty->mergeInto('js_scripts', 'private/semester.js');

$smarty->assign('semesterliste', $liste);


if(!isset($_REQUEST['semester']) || trim($_REQUEST['semester']) == "")
  {
    $smarty->assign('fehlermsg', "Bitte Semester ausw&auml;hlen");
    $smarty->addTemplate('content', 'private/semesterliste.tpl');
    return;
  }
if(!isset($_REQUEST['schuljahr']) || trim($_REQUEST['schuljahr']) == "")
  {
    $smarty->assign('fehlermsg', "Bitte Schuljahr eingeben");
    $smarty->addTemplate('content', 'private/semesterliste.tpl');
    return;
  }
if(!isset($_REQUEST['freidatum']) || trim($_REQUEST['freidatum']) == "")
  {
    $smarty->assign('fehlermsg', "Bitte ein Freigabedatum ausw&auml;hlen");
    $smarty->addTemplate('content', 'private/semesterliste.tpl');
    return;
  }
if(!isset($_REQUEST['sperrdatum']) || trim($_REQUEST['sperrdatum']) == "")
  {
    $smarty->assign('fehlermsg', "Bitte ein Sperrdatum ausw&auml;hlen");
    $smarty->addTemplate('content', 'private/semesterliste.tpl');
    return;
  }




if(!isset($_REQUEST['id']))
  {
    $zeit = new Zeitraum();
    $zeit->setSemester($_REQUEST['semester']);
    $zeit->setSchuljahr($_REQUEST['schuljahr']);
    
    $zeit->setFreidatum($date = DateTime::createFromFormat("d.m.Y H:i:s", $_REQUEST['freidatum']." 0:0:0"));
    $zeit->setSperrdatum($date = DateTime::createFromFormat("d.m.Y H:i:s", $_REQUEST['sperrdatum']." 0:0:0"));
    
    if(MyError::isError($error = $zeit->insert()))
      {
	if($error->getMessage() == "prepare_error" && strstr($error->getAdditionalInfo(), "23000: Duplicate"))
	  {
	    $smarty->assign('fehlermsg', "Semester schon vorhanden!<br />".$error->getAdditionalInfo());
	    $smarty->addTemplate('content', 'private/semesterliste.tpl');
	    return;
	  }
	else
	  {
	    $smarty->assign('fehlermsg', "Fehler beim Eintragen in die Datenbank!<br />".$error->getAdditionalInfo());
	    $smarty->addTemplate('content', 'private/semesterliste.tpl');	
	    return;
	  }
      }
  }
else
  {

    if(MyError::isError($zeit = ZeitraumListe::getById($_REQUEST['id'])))
      {
	$smarty->assign('fehlermsg', "Semester schon vorhanden!<br />".$error->getAdditionalInfo());
	$smarty->addTemplate('content', 'private/semesterliste.tpl');
	return;
      }
    if($zeit == NULL)
      {
	$smarty->assign('fehlermsg', "Semester schon vorhanden!<br />".$error->getAdditionalInfo());
	$smarty->addTemplate('content', 'private/semesterliste.tpl');
	return;
      }


    $zeit->setSemester($_REQUEST['semester']);
    $zeit->setSchuljahr($_REQUEST['schuljahr']);
    
    $zeit->setFreidatum($date = DateTime::createFromFormat("d.m.Y H:i:s", $_REQUEST['freidatum']." 0:0:0"));
    $zeit->setSperrdatum($date = DateTime::createFromFormat("d.m.Y H:i:s", $_REQUEST['sperrdatum']." 0:0:0"));
    
    if(MyError::isError($error = $zeit->update()))
      {
	if($error->getMessage() == "prepare_error" && strstr($error->getAdditionalInfo(), "23000: Duplicate"))
	  {
	    $smarty->assign('fehlermsg', "Semester schon vorhanden!<br />".$error->getAdditionalInfo());
	    $smarty->addTemplate('content', 'private/semesterliste.tpl');
	    return;
	  }
	else
	  {
	    $smarty->assign('fehlermsg', "Fehler beim Eintragen in die Datenbank!<br />".$error->getAdditionalInfo());
	    $smarty->addTemplate('content', 'private/semesterliste.tpl');	
	    return;
	  }
      }
  }
    
if(MyError::isError($liste = ZeitraumListe::getList()))
    {
	$smarty->assign('message', $liste->getMessage()."<br/>".$liste->getAdditionalInfo());
	$smarty->assign('err_type', 'error');
	$smarty->addTemplate('content', 'errors/message.tpl');
	return;
    }

$smarty->assign('semesterliste', $liste);

$smarty->addTemplate('content', 'private/semesterliste.tpl');

?>