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


class BenutzerListe extends DBObjectList
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
    $selectquery="Select * from Benutzer where valid = '1'";
    if(!($stm = $con->query($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    while($agdet = $stm->fetch())
      {
	$liste[$agdet['U_Id']] = new Benutzer();
	$liste[$agdet['U_Id']]->setIdentNumber((int)($agdet['U_Id']));
	$liste[$agdet['U_Id']]->setName($agdet['name']);
	$liste[$agdet['U_Id']]->setNachname($agdet['nachname']);
	$liste[$agdet['U_Id']]->setUser($agdet['benutzername']);
	$liste[$agdet['U_Id']]->setPassword($agdet['password']);
	$liste[$agdet['U_Id']]->setRolle((int)($agdet['R_Id']));
	$liste[$agdet['U_Id']]->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste[$agdet['U_Id']]->setCreateTime($datetime);
	$liste[$agdet['U_Id']]->setValid($agdet['valid']);
      }
    return $liste;
  }



  /**
   * This function is to control an object, wheter it's a instance of the implementing class of this abstract class
   * @return the result of the control
   */
  public static function isInstanceOf($object)
  {
    return ($object instanceof Benutzer);
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
    $selectquery="Select * from Benutzer where U_Id = :ident";
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
	$liste = new Benutzer();
	$liste->setIdentNumber((int)($agdet['U_Id']));
	$liste->setName($agdet['name']);
	$liste->setNachname($agdet['nachname']);
	$liste->setUser($agdet['benutzername']);
	$liste->setPassword($agdet['password']);
	$liste->setRolle((int)($agdet['R_Id']));
	$liste->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste->setCreateTime($datetime);
	$liste->setValid($agdet['valid']);
      }
    $stm->closeCursor();
    return $liste;
  }

  public static function getByRollennummer($rolle)
  {
    if(intval($rolle) != $rolle)
      {
	return MyError::raiseError(gettext('Elemento con ID ').$ident.gettext(' non essistente'), SYS_ERROR);
      }

    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Benutzer where R_Id = :ident AND valid = 1 ODER BY nachname";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':ident', $rolle);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;

    while($agdet = $stm->fetch())
      {
	$liste[$agdet['U_Id']] = new Benutzer();
	$liste[$agdet['U_Id']]->setIdentNumber((int)($agdet['U_Id']));
	$liste[$agdet['U_Id']]->setName($agdet['name']);
	$liste[$agdet['U_Id']]->setNachname($agdet['nachname']);
	$liste[$agdet['U_Id']]->setUser($agdet['benutzername']);
	$liste[$agdet['U_Id']]->setPassword($agdet['password']);
	$liste[$agdet['U_Id']]->setRolle((int)($agdet['R_Id']));
	$liste[$agdet['U_Id']]->setCreateUser($agdet['createUser']);
	$datetime=new DateTime($agdet['createTime']);
	$liste[$agdet['U_Id']]->setCreateTime($datetime);
	$liste[$agdet['U_Id']]->setValid($agdet['valid']);
      }
    $stm->closeCursor();
    return $liste;
  }


  public static function getByName($name, $nachname)
  {
    $con = AppDBO::getInstance();
    /********************************************************************
     * selectquery to get the data from tha database
     *******************************************************************/
    $selectquery="Select * from Benutzer where name = :name AND nachname = :nachname AND valid = 1";
    if(!($stm = $con->prepare($selectquery)))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindParam(':name', $name);
    $stm->bindParam(':nachname', $nachname);

    if(!($stm->execute()))
      {
	return MyError::raiseError(gettext('prepare_error'), SQL_ERROR, $con->getErrorMsg());
      }
    $liste=NULL;
    if($agdet = $stm->fetch())
      {
	$liste = new Benutzer();
	$liste->setIdentNumber((int)($agdet['U_Id']));
	$liste->setName($agdet['name']);
	$liste->setNachname($agdet['nachname']);
	$liste->setUser($agdet['benutzername']);
	$liste->setPassword($agdet['password']);
	$liste->setRolle((int)($agdet['R_Id']));
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