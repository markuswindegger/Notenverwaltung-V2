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


class BetragenListe extends DBObjectList
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
    $selectquery="Select * from Betragen where valid = '1'";
    if(!($stm = $con->query($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    $ident = "B_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Betragen();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setAbsenzen($agdet['absenzen']);
	$liste[$agdet[$ident]]->setBetragen($agdet['betragen']);
	$liste[$agdet[$ident]]->setSchuelernummer($agdet['S_Id']);
	$liste[$agdet[$ident]]->setVorstandnummer($agdet['V_Id']);

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
    return ($object instanceof Betragen);
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
    $selectquery="Select * from Betragen where B_Id = :ident";
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
	$liste = new Betragen();
	$liste->setIdentNumber(($agdet['B_Id']));
	$liste->setAbsenzen($agdet['absenzen']);
	$liste->setBetragen($agdet['betragen']);
	$liste->setSchuelernummer($agdet['S_Id']);
	$liste->setVorstandnummer($agdet['V_Id']);

	$liste->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste->setCreateTime($datetime);
	$liste->setValid($agdet['valid']);
      }
    $stm->closeCursor();
    return $liste;
  }

  

  public static function getBySchuelernummer($schueler)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Betragen where valid = 1 AND S_Id = :schueler";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':schueler', $schueler);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste = NULL;
    $ident = "B_Id";
    while($agdet = $stm->fetch())
      {
	$liste = new Betragen();
	$liste->setIdentNumber(($agdet[$ident]));
	$liste->setAbsenzen($agdet['absenzen']);
	$liste->setBetragen($agdet['betragen']);
	$liste->setSchuelernummer($agdet['S_Id']);
	$liste->setVorstandnummer($agdet['V_Id']);

	$liste->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste->setCreateTime($datetime);
	$liste->setValid($agdet['valid']);

      }
    $stm->closeCursor();
    return $liste;
  }

  public static function getByVorstandnummer($vorstandnummer)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Betragen where valid = 1 AND V_Id = :vorstand";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':vorstand', $vorstandnummer);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    $ident = "B_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Betragen();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setAbsenzen($agdet['absenzen']);
	$liste[$agdet[$ident]]->setBetragen($agdet['betragen']);
	$liste[$agdet[$ident]]->setSchuelernummer($agdet['S_Id']);
	$liste[$agdet[$ident]]->setVorstandnummer($agdet['V_Id']);

	$liste[$agdet[$ident]]->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste[$agdet[$ident]]->setCreateTime($datetime);
	$liste[$agdet[$ident]]->setValid($agdet['valid']);

      }
    $stm->closeCursor();
    return $liste;
  }



  public static function getByVorstandnummerOrder($vorstandnummer)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Betragen where valid = 1 AND V_Id = :vorstand";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':vorstand', $vorstandnummer);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    $ident = "S_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Betragen();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet['B_Id']));
	$liste[$agdet[$ident]]->setAbsenzen($agdet['absenzen']);
	$liste[$agdet[$ident]]->setBetragen($agdet['betragen']);
	$liste[$agdet[$ident]]->setSchuelernummer($agdet['S_Id']);
	$liste[$agdet[$ident]]->setVorstandnummer($agdet['V_Id']);

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