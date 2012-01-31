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


class NotenListe extends DBObjectList
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
    $selectquery="Select * from Noten where valid = '1'";
    if(!($stm = $con->query($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    $ident = "N_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Noten();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setNote($agdet['note']);
	$liste[$agdet[$ident]]->setFachnummer($agdet['F_Id']);
	$liste[$agdet[$ident]]->setSchuelernummer($agdet['S_Id']);

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
    return ($object instanceof Noten);
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
    $selectquery="Select * from Noten where N_Id = :ident";
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
	$liste = new Noten();
	$liste->setIdentNumber(($agdet['N_Id']));
	$liste->setNote($agdet['note']);
	$liste->setFachnummer($agdet['F_Id']);
	$liste->setSchuelernummer($agdet['S_Id']);

	$liste->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste->setCreateTime($datetime);
	$liste->setValid($agdet['valid']);
      }
    $stm->closeCursor();
    return $liste;
  }

  public static function getByFachnummer($fach)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Noten where valid = 1 AND F_Id = :fach";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':fach', $fach);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    $ident = "N_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Noten();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setNote($agdet['note']);
	$liste[$agdet[$ident]]->setFachnummer($agdet['F_Id']);
	$liste[$agdet[$ident]]->setSchuelernummer($agdet['S_Id']);

	$liste[$agdet[$ident]]->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste[$agdet[$ident]]->setCreateTime($datetime);
	$liste[$agdet[$ident]]->setValid($agdet['valid']);

      }
    $stm->closeCursor();
    return $liste;
  }
  

  public static function getByFachnummerSort($fach)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Noten where valid = 1 AND F_Id = :fach";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':fach', $fach);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('execute_error'), SQL_ERROR, $stm->getErrorMsg());
      }
    $liste=NULL;
    $ident = "S_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Noten();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet['N_Id']));
	$liste[$agdet[$ident]]->setNote($agdet['note']);
	$liste[$agdet[$ident]]->setFachnummer($agdet['F_Id']);
	$liste[$agdet[$ident]]->setSchuelernummer($agdet['S_Id']);

	$liste[$agdet[$ident]]->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste[$agdet[$ident]]->setCreateTime($datetime);
	$liste[$agdet[$ident]]->setValid($agdet['valid']);

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
    $selectquery="Select * from Noten where valid = 1 AND S_Id = :schueler";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':schueler', $schueler);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    $ident = "N_Id";
    while($agdet = $stm->fetch())
      {
	$liste[$agdet[$ident]] = new Noten();
	$liste[$agdet[$ident]]->setIdentNumber(($agdet[$ident]));
	$liste[$agdet[$ident]]->setNote($agdet['note']);
	$liste[$agdet[$ident]]->setFachnummer($agdet['F_Id']);
	$liste[$agdet[$ident]]->setSchuelernummer($agdet['S_Id']);

	$liste[$agdet[$ident]]->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste[$agdet[$ident]]->setCreateTime($datetime);
	$liste[$agdet[$ident]]->setValid($agdet['valid']);

      }
    $stm->closeCursor();
    return $liste;
  }

  public static function getBySchuelerFach($schuelernummer, $fachnummer)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Noten where S_Id = :schueler AND F_Id = :fach AND valid = 1";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':fach', $fachnummer);
    $stm->bindParam(':schueler', $schuelernummer);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    if($agdet = $stm->fetch())
      {
	$liste = new Noten();
	$liste->setIdentNumber(($agdet['N_Id']));
	$liste->setNote($agdet['note']);
	$liste->setFachnummer($agdet['F_Id']);
	$liste->setSchuelernummer($agdet['S_Id']);

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