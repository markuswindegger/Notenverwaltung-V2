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


class Absenzen extends DBObject
{

  private $absenzen = 0;

  private $fachnummer = 0;

  private $schuelernummer = 0;


  public function __construct()
  {
    
  }

  public function getAbsenzen()
  {
    return $this->absenzen;
  }

  public function getFachnummer()
  {
    return $this->fachnummer;
  }

  public function getSchuelernummer()
  {
    return $this->schuelernummer;
  }
  




  public function setAbsenzen($absenzen)
  {
    $this->absenzen = $absenzen;
  }

  public function setFachnummer($fachnummer)
  {
    $this->fachnummer = $fachnummer;
  }

  public function setSchuelernummer($schuelernummer)
  {
    $this->schuelernummer = $schuelernummer;
  }




  /**
   * This method syncronizes the current object with the database
   * @return a MyError if something goes wrong
   */
  public function update()
  {

    $con = AppDBO::getInstance();
    if(!$con->beginTransaction())
      {
	return MyError::raiseError('transaction_begin_error', SQL_ERROR, $con->getErrorMsg());
      }

    if(MyError::isError($error = $this->delete()))
      {
	$con->rollback();
	return $error;
      }
    
    if(MyError::isError($error = $this->insert()))
      {
	$con->rollback();
	return $error;
      }
    if(!$con->commit())
      {
	@$con->rollback();
	return MyError::raiseError('commit_error', SQL_ERROR, $con->getErrorMsg());
      }

  }
  
  /**
   * This method deletes the current object from the database
   * @return a MyError if something goes wrong
   */
  public function delete()
  {
    $con = AppDBO::getInstance();
    $updatequery = "update Absenzen_Faecher set deleteTime = :time, deleteUser = :user, valid = 0 where AF_Id = :ident";
      
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
    $insertquery = "insert into Absenzen_Faecher (anzahl, F_Id, S_Id, createUser, 
			createTime, valid) values (:absenzen, :fach, :schueler, :user, :time, 1)";
      
    if(!($stm = $con->prepare($insertquery)))
      {
	return MyError::raiseError('prepare_error', SQL_ERROR, $con->getErrorMsg());
      }
    $stm->bindValue(':absenzen', $this->absenzen);
    $stm->bindValue(':fach', $this->fachnummer);
    $stm->bindValue(':schueler', $this->schuelernummer);

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
    if($this->absenzen != 0 && intval($this->absenzen) != $this->absenzen || $this->absenzen < 0)
      {
	return MyError::raiseError(gettext('set_valid_absenzen'), SYS_ERROR);
      }

    if($this->fachnummer != 0 && intval($this->fachnummer) != $this->fachnummer || $this->fachnummer < 0)
      {
	return MyError::raiseError(gettext('set_valid_fachnummer'), SYS_ERROR);
      }
    if($this->schuelernummer != 0 && intval($this->schuelernummer) != $this->schuelernummer || $this->schuelernummer < 0)
      {
	return MyError::raiseError(gettext('set_valid_schuelernummer'), SYS_ERROR);
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
    if($this->absenzen != 0 && intval($this->absenzen) != $this->absenzen || $this->absenzen < 0)
      {
	$error['absenzen'] = "G&uuml;ltige Absenzen eingeben";
      }
    if($this->fachnummer != 0 && intval($this->fachnummer) != $this->fachnummer || $this->fachnummer < 0)
      {
	$error['fachnummer'] = "G&uuml;ltiges Fach angeben";
      }
    if($this->schuelernummer != 0 && intval($this->schuelernummer) != $this->schuelernummer || $this->schuelernummer < 0)
      {
	$error['schuelernummer'] = "G&uuml;ltigen Schueler angeben";
      }
    if (count($error))
      {
	return $error;
      }
    return true;
  }
}

?>