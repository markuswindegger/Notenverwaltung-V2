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


class VorstandListe extends DBObjectList
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
    $selectquery="Select * from Vorstand where valid = '1'";
    if(!($stm = $con->query($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    $ident = "V_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Vorstand();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setZeitraumnummer($agdet['ZR_Id']);
	$liste[$agdet[$ident]]->setKlassennummer($agdet['K_Id']);
	$liste[$agdet[$ident]]->setLehrernummer(($agdet['U_Id']));
	
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
    return ($object instanceof Vorstand);
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
    $selectquery="Select * from Vorstand where V_Id = :ident";
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
	$liste = new Vorstand();
	$liste->setIdentNumber(($agdet['V_Id']));
	$liste->setZeitraumnummer($agdet['ZR_Id']);
	$liste->setKlassennummer($agdet['K_Id']);
	$liste->setLehrernummer(($agdet['U_Id']));

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
    $selectquery="Select * from Vorstand where U_Id = :lehrer AND ZR_Id = :zeitraum AND valid = 1";
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
    $ident = "V_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Vorstand();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setZeitraumnummer($agdet['ZR_Id']);
	$liste[$agdet[$ident]]->setKlassennummer($agdet['K_Id']);
	$liste[$agdet[$ident]]->setLehrernummer(($agdet['U_Id']));

	$liste[$agdet[$ident]]->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste[$agdet[$ident]]->setCreateTime($datetime);
	$liste[$agdet[$ident]]->setValid($agdet['valid']);
      }
    return $liste;
  }

  public static function getByKlassennummer($klassennummer, $zeitraumnummer)
  {

    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Vorstand where K_Id = :klasse AND ZR_Id = :zeitraum AND valid = 1";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':klasse', $klassennummer);
    
    $stm->bindParam(':zeitraum', $zeitraumnummer);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    if($agdet = $stm->fetch())
      {
	$liste = new Vorstand();
	$liste->setIdentNumber(($agdet['V_Id']));
	$liste->setZeitraumnummer($agdet['ZR_Id']);
	$liste->setKlassennummer($agdet['K_Id']);
	$liste->setLehrernummer(($agdet['U_Id']));

	$liste->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste->setCreateTime($datetime);
	$liste->setValid($agdet['valid']);
      }
    $stm->closeCursor();
    return $liste;
  }


}



?>