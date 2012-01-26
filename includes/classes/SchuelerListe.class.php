<?php

  /**
   * @author Markus Windegger <markus@windegger.com>
   */


  /**
   *
   * class BenutzerListe
   *
   * @package: classes
   *
   *
   */


class SchuelerListe extends DBObjectList
{

  

  /**
   * This function returns an array of all the objects momentanly avaiable in the database
   * @return a list of objects if all goes right, alternativ it returns a MyError
   */
  public static function getList()
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Schueler where valid = '1' order by K_Id, nachname, name";
    if(!($stm = $con->query($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    $ident = "S_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Schueler();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setName($agdet['name']);
	$liste[$agdet[$ident]]->setNachname($agdet['nachname']);
	$liste[$agdet[$ident]]->setZeitraumnummer($agdet['ZR_Id']);
	$liste[$agdet[$ident]]->setKlassennummer($agdet['K_Id']);

	$liste[$agdet[$ident]]->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste[$agdet[$ident]]->setCreateTime($datetime);
	$liste[$agdet[$ident]]->setValid($agdet['valid']);
      }
    return $liste;
  }



  /**
   * This function is to control an object, wheter it's a instance of the implementing class of this abstract class
   * @return the result of the control
   */
  public static function isInstanceOf($object)
  {
    return ($object instanceof Schueler);
  }

  
  public static function getById($ident)
  {
    if(intval($ident) != $ident)
      {
	return MyError::raiseError(gettext('Elemento con ID ').$ident.gettext(' non essistente'), SYS_ERROR);
      }

    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Schueler where K_Id = :ident";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':ident', $ident);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    if($agdet = $stm->fetch())
      {
	$liste = new Schueler();
	$liste->setIdentNumber(($agdet['S_Id']));
	$liste->setName($agdet['name']);
	$liste->setNachname($agdet['nachname']);
	$liste->setKlassennummer($agdet['K_Id']);
	$liste->setZeitraumnummer($agdet['ZR_Id']);

	$liste->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste->setCreateTime($datetime);
	$liste->setValid($agdet['valid']);
      }
    $stm->closeCursor();
    return $liste;
  }

  public static function getByZeitraum($zeitraum)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Schueler where valid = 1 AND ZR_Id = :zeitr ORDER BY K_ID, nachname, name";

    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':zeitr', $zeitraum);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    $ident = "S_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Schueler();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setName($agdet['name']);
	$liste[$agdet[$ident]]->setNachname($agdet['nachname']);
	$liste[$agdet[$ident]]->setZeitraumnummer($agdet['ZR_Id']);
	$liste[$agdet[$ident]]->setKlassennummer($agdet['K_Id']);

	$liste[$agdet[$ident]]->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste[$agdet[$ident]]->setCreateTime($datetime);
	$liste[$agdet[$ident]]->setValid($agdet['valid']);

      }
    $stm->closeCursor();
    return $liste;
  }


  public static function getByKlassennummer($klasse,$zeitraum)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Schueler where valid = 1 AND ZR_Id = :zeitr AND K_Id = :klasse ORDER BY nachname, name";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':klasse', $klasse);
    $stm->bindParam(':zeitr', $zeitraum);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    $ident = "S_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Schueler();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setName($agdet['name']);
	$liste[$agdet[$ident]]->setNachname($agdet['nachname']);
	$liste[$agdet[$ident]]->setZeitraumnummer($agdet['ZR_Id']);
	$liste[$agdet[$ident]]->setKlassennummer($agdet['K_Id']);

	$liste[$agdet[$ident]]->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste[$agdet[$ident]]->setCreateTime($datetime);
	$liste[$agdet[$ident]]->setValid($agdet['valid']);

      }
    $stm->closeCursor();
    return $liste;
  }

}



?>