<?php

if(!isset($_SESSION['benutzer']) || $_SESSION['benutzer']->getRolle() != 1)
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler bei der Authentifizierung, melden sie sich bitte neu an';
    echo json_encode($erg);
    return;
  }
if(!isset($_REQUEST['zeitraumnummer']))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Bitte f&uuml;llen Sie alle Felder aus!';
    echo json_encode($erg);
    return;
  }

if(MyError::isError($semester = ZeitraumListe::getById($_REQUEST['zeitraumnummer'])))
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage'.$klasse->getMessage()."<br />".$klasse->getAdditionalInfo();
    echo json_encode($erg);
    return;
  }

if($semester == NULL)
  {
    $erg['error'] = -1;
    $erg['html'] = 'Fehler in der Datenbankabfrage';
    echo json_encode($erg);
    return;
  }

$smarty->assign('semester', $semester);

$html = $smarty->fetch('private/ajax/schuelerupload.tpl');

$erg['error'] = 0;
$erg['html'] = $html;

echo json_encode($erg);

return;


?>