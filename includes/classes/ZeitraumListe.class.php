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


class ZeitraumListe extends DBObjectList
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
    $selectquery="Select * from Zeitraum where valid = '1'";
    if(!($stm = $con->query($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    $ident = "ZR_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Zeitraum();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setSemester($agdet['semester']);
	$liste[$agdet[$ident]]->setSchuljahr($agdet['schuljahr']);
	$datetime=new DateTime($agdet['freigabedatum']);
	$liste[$agdet[$ident]]->setFreidatum($datetime);
	$datetime=new DateTime($agdet['sperrdatum']);
	$liste[$agdet[$ident]]->setSperrdatum($datetime);

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
    return ($object instanceof Zeitraum);
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
    $selectquery="Select * from Zeitraum where ZR_Id = :ident";
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
	$liste = new Zeitraum();
	$liste->setIdentNumber(($agdet['ZR_Id']));
	$liste->setSemester($agdet['semester']);
	$liste->setSchuljahr($agdet['schuljahr']);
	$datetime=new DateTime($agdet['freigabedatum']);
	$liste->setFreidatum($datetime);
	$datetime=new DateTime($agdet['sperrdatum']);
	$liste->setSperrdatum($datetime);


	$liste->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste->setCreateTime($datetime);
	$liste->setValid($agdet['valid']);
      }
    $stm->closeCursor();
    return $liste;
  }


  public static function getAktuellenZeitraum()
  {
    
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Zeitraum where CURRENT_TIMESTAMP <= sperrdatum AND CURRENT_TIMESTAMP >= freigabedatum AND valid = 1";
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
	$liste = new Zeitraum();
	$liste->setIdentNumber(($agdet['ZR_Id']));
	$liste->setSemester($agdet['semester']);
	$liste->setSchuljahr($agdet['schuljahr']);
	$datetime=new DateTime($agdet['freigabedatum']);
	$liste->setFreidatum($datetime);
	$datetime=new DateTime($agdet['sperrdatum']);
	$liste->setSperrdatum($datetime);


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