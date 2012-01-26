<?php

  /**
   * @author Markus Windegger <markus@windegger.com>
   */


  /**
   *
   * class Benutzer
   *
   * @package: classes
   *
   *
   */


class Klasse extends DBObject
{

  private $stufe = 0;

  private $zug = NULL;

  private $fachrichtung = NULL;

  


  public function __construct()
  {

  }


  public function getStufe()
  {
    return $this->stufe;
  }

  public function getZug()
  {
    return $this->zug;
  }

  public function getFachrichtung()
  {
    return $this->fachrichtung;
  }



  public function setStufe($stufe)
  {
    $this->stufe = $stufe;
  }

  public function setZug($zug)
  {
    $this->zug = $zug;
  }

  public function setFachrichtung($fachrichtung)
  {
    $this->fachrichtung = $fachrichtung;
  }






  /**
   * This method syncronizes the current object with the database
   * @return a MyError if something goes wrong
   */
  public function update()
  {

    $con = AppDBO::getInstance();

    $insertquery = "Update Klasse set stufe = :stufe, zug = :zug, fachrichtung = :fachr where K_Id = :ident";
      
    if(!($stm = $con->prepare($insertquery)))
      {
	return MyError::raiseError('prepare_error', SQL_ERROR, $con->getErrorMsg());
      }
    $stm->bindValue(':stufe', $this->stufe);
    $stm->bindValue(':zug', $this->zug);
    $stm->bindValue(':fachr', $this->fachrichtung);
    $stm->bindValue(':ident', $this->identNumber);
    if(!($stm->execute()))
      {
	return MyError::raiseError('prepare_error', SQL_ERROR, $stm->getErrorMsg());
      }
    $stm->closeCursor();

  }
  
  /**
   * This method deletes the current object from the database
   * @return a MyError if something goes wrong
   */
  public function delete()
  {
    $con = AppDBO::getInstance();
    $updatequery = "update Klasse set deleteTime = :time, deleteUser = :user, valid = 0 where K_Id = :ident";
      
    if(!($stm = $con->prepare($updatequery)))
      {
	return MyError::raiseError('prepare_error', SQL_ERROR, $con->getErrorMsg());
      }

    $this->deleteUser = $_SESSION['benutzer']->getIdentNumber();
    $stm->bindValue(':user', $this->deleteUser);

    $this->deleteTime = new Datetime();
    $stm->bindValue(':time',($this->deleteTime->format('Y-m-d H:i:s'))); 

    $stm->bindValue(':ident', $this->identNumber);


    if(!$stm->execute())
      {
	return MyError::raiseError('execute_error', SQL_ERROR, $stm->getErrorMsg());
      }

    $stm->closeCursor();
      
  }

  /**
   * This method inserts the current object into the database
   * @return a MyError if something goes wrong
   */
  public function insert()
  {
    $con = AppDBO::getInstance();
    $insertquery = "insert into Klasse (stufe, zug, fachrichtung, createUser, 
			createTime, valid) values (:stufe, :zug, :fachr, :user, :time, 1)";
      
    if(!($stm = $con->prepare($insertquery)))
      {
	return MyError::raiseError('prepare_error', SQL_ERROR, $con->getErrorMsg());
      }
    $stm->bindValue(':stufe', $this->stufe);
    $stm->bindValue(':zug', $this->zug);
    $stm->bindValue(':fachr', $this->fachrichtung);

    $this->createUser = $_SESSION['benutzer']->getIdentNumber();
    $stm->bindValue(':user', $this->createUser);
    $this->createTime = new Datetime();
    $stm->bindValue(':time',($this->createTime->format('Y-m-d H:i:s'))); 
    if(!($stm->execute()))
      {
	return MyError::raiseError('prepare_error', SQL_ERROR, $stm->getErrorMsg()."<br />".$this->foto);
      }
    $this->identNumber = $con->lastInsertID();
    $stm->closeCursor();
  }


  /**
   * This method validates the current object, is useful for validating the 
   * object before inserting the object in the database.
   * @return The method returns NULL if everithing is going right, but 
   *		returns a MyError with the detailed description of the error.
   */
  public function validate()
  {
    if($this->identNumber != 0 && intval($this->identNumber) != $this->identNumber || $this->identNumber < 0)
      {
	return MyError::raiseError(gettext('set_valid_id'), SYS_ERROR, var_dump($this->identNumber));
      }
    if($this->fachrichtung == NULL || trim($this->fachrichtung) === "")
      {
	return MyError::raiseError(gettext('set_fachrichtung'), SYS_ERROR);
      }
    if($this->stufe != 0 && intval($this->stufe) != $this->stufe || $this->stufe < 0)
      {
	return MyError::raiseError(gettext('set_valid_stufe'), SYS_ERROR);
      }
    if($this->zug == NULL || trim($this->zug) === "")
      {
	return MyError::raiseError(gettext('set_zug'), SYS_ERROR);
      }
  }


  /**
   * This method returns the errors from the validation in an associated
   * array.
   * @return an array if some errors exist, true if the validation ends without 
   *		errors
   */
  public function getValidateErrors()
  {
    $error = array();
    if($this->identNumber != 0 && intval($this->identNumber) != $this->identNumber || $this->identNumber < 0)
      {
	$error['identNumber'] = "Identifikationsnummer nicht g&uuml;ltig";
      }
    if($this->fachrichtung == NULL || trim($this->fachrichtung) === "")
      {
	$error['fachrichtung'] = "G&uuml;ltige Fachrichtung angeben";
      }
    if($this->zug == NULL || trim($this->zug) === "")
      {
	$error['zug'] = "G&uuml;ltigen Zug angeben";
      }
    if($this->stufe != 0 && intval($this->stufe) != $this->stufe || $this->stufe < 0)
      {
	$error['stufe'] = "G&uuml;ltige Stufe angeben";
      }
    if (count($error))
      {
	return $error;
      }
    return true;
  }
}

?>