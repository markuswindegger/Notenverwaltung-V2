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


class Schueler extends DBObject
{
  
  private $name = null;
  
  private $nachname = null;
  
  private $klassennummer = 0;

  private $zeitraumnummer = 0;
  

  public function __construct()
  {

  }


  public function getName()
  {
    return $this->name;
  }
  
  public function getNachname()
  {
    return $this->nachname;
  }

  public function getKlassennummer()
  {
    return $this->klassennummer;
  }

  public function getZeitraumnummer()
  {
    return $this->zeitraumnummer;
  }



  public function setName($name)
  {
    $this->name = $name;
  }
    
  public function setNachname($nachname)
  {
    $this->nachname = $nachname;
  }

  public function setKlassennummer($klassennummer)
  {
    $this->klassennummer = $klassennummer;
  }

  public function setZeitraumnummer($zeitraumnummer)
  {
    $this->zeitraumnummer = $zeitraumnummer;
  }





  /**
   * This method syncronizes the current object with the database
   * @return a MyError if something goes wrong
   */
  public function update()
  {

    $con = AppDBO::getInstance();

    $insertquery = "Update Schueler set name = :name, nachname = :nachname, K_Id = :klasse, ZR_Id = :zeitr where S_Id = :ident";
      
    if(!($stm = $con->prepare($insertquery)))
      {
	return MyError::raiseError('prepare_error', SQL_ERROR, $con->getErrorMsg());
      }

    $stm->bindValue(':name', $this->name);
    $stm->bindValue(':nachname', $this->nachname);
    $stm->bindValue(':klasse', $this->klassennummer);
    $stm->bindValue(':zeitr', $this->zeitraumnummer);
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
    $updatequery = "update Klasse set deleteTime = :time, deleteUser = :user, valid = 0 where S_Id = :ident";
      
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
    $insertquery = "insert into Schueler (name, nachname, K_Id, ZR_Id, createUser, 
			createTime, valid) values (:name, :nachname, :klasse, :zeitr, :user, :time, 1)";
      
    if(!($stm = $con->prepare($insertquery)))
      {
	return MyError::raiseError('prepare_error', SQL_ERROR, $con->getErrorMsg());
      }
    $stm->bindValue(':name', $this->name);
    $stm->bindValue(':nachname', $this->nachname);
    $stm->bindValue(':klasse', $this->klassennummer);
    $stm->bindValue(':zeitr', $this->zeitraumnummer);

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
    if($this->name == NULL || trim($this->name) === "")
      {
	return MyError::raiseError(gettext('set_name'), SYS_ERROR);
      }
    if($this->nachname == NULL || trim($this->nachname) === "")
      {
	return MyError::raiseError(gettext('set_nachname'), SYS_ERROR);
      }
    if($this->klassennummer != 0 && intval($this->klassennummer) != $this->klassennummer || $this->klassennummer < 0)
      {
	return MyError::raiseError(gettext('set_valid_id'), SYS_ERROR, var_dump($this->klassennummer));
      }
    if($this->zeitraumnummer != 0 && intval($this->zeitraumnummer) != $this->zeitraumnummer || $this->zeitraumnummer < 0)
      {
	return MyError::raiseError(gettext('set_valid_id'), SYS_ERROR, var_dump($this->zeitraumnummer));
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
    if($this->name == NULL || trim($this->name) === "")
      {
	  $error['name'] = "G&uuml;ltigen Namen angeben";
      }
    if($this->nachname == NULL || trim($this->nachname) === "")
      {
	  $error['nachname'] = "G&uuml;ltigen Nachnamen angeben";
      }
    if($this->klassennummer != 0 && intval($this->klassennummer) != $this->klassennummer || $this->klassennummer < 0)
      {
	$error['klassennummer'] = "G&uuml;ltige Klasse angeben";
      }
    if($this->zeitraumnummer != 0 && intval($this->zeitraumnummer) != $this->zeitraumnummer || $this->zeitraumnummer < 0)
      {
	$error['zeitraumnummer'] = "G&uuml;ltigen Zeitraum angeben";
      }

    if (count($error))
      {
	return $error;
      }
    return true;
  }
}

?>