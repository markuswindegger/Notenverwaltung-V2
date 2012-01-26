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


class KlassenListe extends DBObjectList
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
    $selectquery="Select * from Klasse where valid = '1' order by stufe, fachrichtung, zug";
    if(!($stm = $con->query($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    $ident = "K_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Klasse();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setStufe($agdet['stufe']);
	$liste[$agdet[$ident]]->setZug($agdet['zug']);
	$liste[$agdet[$ident]]->setFachrichtung($agdet['fachrichtung']);

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
    return ($object instanceof Klasse);
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
    $selectquery="Select * from Klasse where K_Id = :ident";
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
	$liste = new Klasse();
	$liste->setIdentNumber(($agdet['K_Id']));
	$liste->setStufe($agdet['stufe']);
	$liste->setZug($agdet['zug']);
	$liste->setFachrichtung($agdet['fachrichtung']);

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
    $selectquery="Select k.K_Id, k.stufe, k.zug, k.fachrichtung, k.createUser, k.createTime, k.valid from Fach f, Klasse k where f.U_Id = :lehrer AND f.ZR_Id = :zeitraum AND f.K_Id = k.K_Id AND f.valid = 1 AND k.valid = 1 GROUP BY k.K_Id ORDER BY k.fachrichtung, k.stufe, k.zug";
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
    $ident = 0;
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Klasse();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setStufe($agdet[1]);
	$liste[$agdet[$ident]]->setZug($agdet[2]);
	$liste[$agdet[$ident]]->setFachrichtung($agdet[3]);

	$liste[$agdet[$ident]]->setCreateUser($agdet[4]);
	$datetime=new DateTime($agdet[5]);
	$liste[$agdet[$ident]]->setCreateTime($datetime);
	$liste[$agdet[$ident]]->setValid($agdet[6]);
      }
    $stm->closeCursor();
    return $liste;
  }



  public static function getByName($stufe, $fachrichtung, $zug)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery = "Select * from Klasse where stufe = :stufe AND zug = :zug AND fachrichtung = :fachrichtung AND valid = 1";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':stufe', $stufe);

    $stm->bindParam(':fachrichtung', $fachrichtung);

    $stm->bindParam(':zug', $zug);
    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('execute_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    if($agdet = $stm->fetch())
      {
	$liste = new Klasse();
	$liste->setIdentNumber(($agdet['K_Id']));
	$liste->setStufe($agdet['stufe']);
	$liste->setZug($agdet['zug']);
	$liste->setFachrichtung($agdet['fachrichtung']);

	$liste->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste->setCreateTime($datetime);
	$liste->setValid($agdet['valid']);
      }
    $stm->closeCursor();
    return $liste;
  }



  public static function getByZeitraumnummer($zeitraum)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery = "Select * from Klasse where K_Id IN (select distinct K_Id from Schueler where ZR_Id = :zeitraum and valid = 1) AND valid = 1 order by stufe, fachrichtung, zug";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':zeitraum', $zeitraum);
    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('execute_error'), SQL_ERROR, $stm->getErrorMsg());
      }
    $liste=NULL;
    $ident = "K_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Klasse();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setStufe($agdet['stufe']);
	$liste[$agdet[$ident]]->setZug($agdet['zug']);
	$liste[$agdet[$ident]]->setFachrichtung($agdet['fachrichtung']);

	$liste[$agdet[$ident]]->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste[$agdet[$ident]]->setCreateTime($datetime);
	$liste[$agdet[$ident]]->setValid($agdet['valid']);
      }
    return $liste;
  }



}



?>