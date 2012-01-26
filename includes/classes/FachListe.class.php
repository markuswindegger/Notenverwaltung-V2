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


class FachListe extends DBObjectList
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
    $selectquery="Select * from Fach where valid = '1'";
    if(!($stm = $con->query($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    $ident = "F_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Fach();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setName($agdet['namen']);
	$liste[$agdet[$ident]]->setZeitraumnummer($agdet['ZR_Id']);
	$liste[$agdet[$ident]]->setFachtypnummer($agdet['FT_Id']);
	$liste[$agdet[$ident]]->setKlassennummer($agdet['K_Id']);
	$liste[$agdet[$ident]]->setLehrernummer(($agdet['U_Id']));
	$liste[$agdet[$ident]]->setAbsenzen(($agdet['absenzen']));
	
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
    return ($object instanceof Fach);
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
    $selectquery="Select * from Fach where F_Id = :ident";
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
	$liste = new Fach();
	$liste->setIdentNumber(($agdet['F_Id']));
	$liste->setName($agdet['namen']);
	$liste->setZeitraumnummer($agdet['ZR_Id']);
	$liste->setFachtypnummer($agdet['FT_Id']);
	$liste->setKlassennummer($agdet['K_Id']);
	$liste->setLehrernummer(($agdet['U_Id']));
	$liste->setAbsenzen(($agdet['absenzen']));

	$liste->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste->setCreateTime($datetime);
	$liste->setValid($agdet['valid']);
      }
    $stm->closeCursor();
    return $liste;
  }

  public static function getByLehrernummer($lehrer, $zeitraum)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Fach where U_Id = :lehrer AND ZR_Id = :zeitraum AND valid = 1";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':lehrer', $lehrer);
    $stm->bindParam(':zeitraum', $zeitraum);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    $ident = "F_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Fach();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setName($agdet['namen']);
	$liste[$agdet[$ident]]->setZeitraumnummer($agdet['ZR_Id']);
	$liste[$agdet[$ident]]->setFachtypnummer($agdet['FT_Id']);
	$liste[$agdet[$ident]]->setKlassennummer($agdet['K_Id']);
	$liste[$agdet[$ident]]->setLehrernummer(($agdet['U_Id']));
	$liste[$agdet[$ident]]->setAbsenzen(($agdet['absenzen']));

	$liste[$agdet[$ident]]->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste[$agdet[$ident]]->setCreateTime($datetime);
	$liste[$agdet[$ident]]->setValid($agdet['valid']);
      }
    return $liste;
  }

  public static function getByKlassennummer($klassennummer, $zeitraum)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Fach where K_Id = :klasse AND ZR_Id = :zeitraum AND valid = 1 ORDER BY F_Id";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $stm->getErrorMsg());
      }

    $stm->bindParam(':klasse', $klassennummer);
    $stm->bindParam(':zeitraum', $zeitraum);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('execute_error'), SQL_ERROR, $stm->getErrorMsg());
      }
    $liste=NULL;
    $ident = "F_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Fach();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setName($agdet['namen']);
	$liste[$agdet[$ident]]->setZeitraumnummer($agdet['ZR_Id']);
	$liste[$agdet[$ident]]->setFachtypnummer($agdet['FT_Id']);
	$liste[$agdet[$ident]]->setKlassennummer($agdet['K_Id']);
	$liste[$agdet[$ident]]->setLehrernummer(($agdet['U_Id']));
	$liste[$agdet[$ident]]->setAbsenzen(($agdet['absenzen']));

	$liste[$agdet[$ident]]->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste[$agdet[$ident]]->setCreateTime($datetime);
	$liste[$agdet[$ident]]->setValid($agdet['valid']);
      }
    return $liste;
  }


  public static function getByLehrerKlasse($lehrer, $klasse, $zeitraum, $groupby)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    if($groupby == 1)
      {
	$selectquery="Select * from Fach where U_Id = :lehrer AND ZR_Id = :zeitraum AND K_Id = :klasse AND valid = 1 GROUP BY namen";
      }
    else
      {
	$selectquery="Select * from Fach where U_Id = :lehrer AND ZR_Id = :zeitraum AND K_Id = :klasse AND valid = 1";
      }
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':lehrer', $lehrer);
    $stm->bindParam(':zeitraum', $zeitraum);
    $stm->bindParam(':klasse', $klasse);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    $ident = "F_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Fach();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setName($agdet['namen']);
	$liste[$agdet[$ident]]->setZeitraumnummer($agdet['ZR_Id']);
	$liste[$agdet[$ident]]->setFachtypnummer($agdet['FT_Id']);
	$liste[$agdet[$ident]]->setKlassennummer($agdet['K_Id']);
	$liste[$agdet[$ident]]->setLehrernummer(($agdet['U_Id']));
	$liste[$agdet[$ident]]->setAbsenzen(($agdet['absenzen']));

	$liste[$agdet[$ident]]->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste[$agdet[$ident]]->setCreateTime($datetime);
	$liste[$agdet[$ident]]->setValid($agdet['valid']);
      }
    return $liste;
  }


  public static function getOrderByKlasses($zeitraum)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select F.F_Id, F.namen, F.ZR_Id, F.FT_Id, F.K_Id, F.U_Id, F.absenzen, F.createUser, F.createTime, F.valid from Fach F, Klasse K where ZR_Id = :zeitraum AND K.K_Id = F.K_Id AND K.valid = 1 AND F.valid = 1 ORDER BY K.stufe, K.fachrichtung, K.zug, F.namen, F.FT_Id";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':zeitraum', $zeitraum);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('execute_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    $ident = "0";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Fach();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setName($agdet[1]);
	$liste[$agdet[$ident]]->setZeitraumnummer($agdet[2]);
	$liste[$agdet[$ident]]->setFachtypnummer($agdet[3]);
	$liste[$agdet[$ident]]->setKlassennummer($agdet[4]);
	$liste[$agdet[$ident]]->setLehrernummer(($agdet[5]));
	$liste[$agdet[$ident]]->setAbsenzen(($agdet[6]));

	$liste[$agdet[$ident]]->setCreateUser($agdet[7]);
	$datetime=new DateTime($agdet[8]);
	$liste[$agdet[$ident]]->setCreateTime($datetime);
	$liste[$agdet[$ident]]->setValid($agdet[9]);
      }
    return $liste;
  }

  public static function getByKlassenNameLehrer($fachname, $klassennummer, $lehrernummer, $zeitraumnummer)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Fach where U_Id = :lehrer AND ZR_Id = :zeitraum AND K_Id = :klasse AND namen = :fachname AND valid = 1 ORDER BY FT_Id";
    
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $stm->getErrorMsg());
      }

    $stm->bindParam(':lehrer', $lehrernummer);
    $stm->bindParam(':zeitraum', $zeitraumnummer);
    $stm->bindParam(':klasse', $klassennummer);
    $stm->bindParam(':fachname', $fachname);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('execute_error'), SQL_ERROR, $stm->getErrorMsg());
      }
    $liste=NULL;
    $ident = "F_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Fach();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setName($agdet['namen']);
	$liste[$agdet[$ident]]->setZeitraumnummer($agdet['ZR_Id']);
	$liste[$agdet[$ident]]->setFachtypnummer($agdet['FT_Id']);
	$liste[$agdet[$ident]]->setKlassennummer($agdet['K_Id']);
	$liste[$agdet[$ident]]->setLehrernummer(($agdet['U_Id']));
	$liste[$agdet[$ident]]->setAbsenzen(($agdet['absenzen']));

	$liste[$agdet[$ident]]->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste[$agdet[$ident]]->setCreateTime($datetime);
	$liste[$agdet[$ident]]->setValid($agdet['valid']);
      }
    return $liste;
  }


  public static function getAbsenzen($zeitraum, $fachname, $lehrernummer, $klassennummer)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Fach where U_Id = :lehrer AND ZR_Id = :zeitraum AND K_Id = :klasse AND namen = :fachname AND valid = 1 AND absenzen = 1 ORDER BY FT_Id";
    
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':lehrer', $lehrernummer);
    $stm->bindParam(':zeitraum', $zeitraumnummer);
    $stm->bindParam(':klasse', $klassennummer);
    $stm->bindParam(':fachname', $fachname);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    if($stm->fetch())
      {
	$stm->closeCursor();
	return true;
      }
    $stm->closeCursor();
    return false;
  }

  public static function getAbsenzenFaecher($klassennummer, $zeitraumnummer)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    
    $selectquery = "select * from Fach where absenzen = 1 AND valid = 1 AND ZR_Id = :zeitraum AND K_Id = :klasse GROUP BY namen ORDER BY F_Id";
    
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $stm->getErrorMsg());
      }

    $stm->bindParam(':zeitraum', $zeitraumnummer);
    $stm->bindParam(':klasse', $klassennummer);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('execute_error'), SQL_ERROR, $stm->getErrorMsg());
      }
    $liste=NULL;
    $ident = "F_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Fach();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setName($agdet['namen']);
	$liste[$agdet[$ident]]->setZeitraumnummer($agdet['ZR_Id']);
	$liste[$agdet[$ident]]->setFachtypnummer($agdet['FT_Id']);
	$liste[$agdet[$ident]]->setKlassennummer($agdet['K_Id']);
	$liste[$agdet[$ident]]->setLehrernummer(($agdet['U_Id']));
	$liste[$agdet[$ident]]->setAbsenzen(($agdet['absenzen']));

	$liste[$agdet[$ident]]->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste[$agdet[$ident]]->setCreateTime($datetime);
	$liste[$agdet[$ident]]->setValid($agdet['valid']);
      }
    return $liste;
  }
  

}



?>