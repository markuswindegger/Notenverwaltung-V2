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


class Vorstand extends DBObject
{



 
    private $zeitraumnummer = 0;

    private $klassennummer = 0;

    private $lehrernummer = 0;


    public function __construct()
    {

    }


    public function getZeitraumnummer()
    {
      return $this->zeitraumnummer;
    }


    public function getKlassennummer()
    {
      return $this->klassennummer;
    }

    public function getLehrernummer()
    {
      return $this->lehrernummer;
    }



    
    public function setZeitraumnummer($zeitraumnummer)
    {
      $this->zeitraumnummer = $zeitraumnummer;
    }

    public function setKlassennummer($klassennummer)
    {
      $this->klassennummer = $klassennummer;
    }

    public function setLehrernummer($lehrernummer)
    {
      $this->lehrernummer = $lehrernummer;
    }





  /**
   * This method syncronizes the current object with the database
   * @return a MyError if something goes wrong
   */
  public function update()
  {

      $con = AppDBO::getInstance();

      $insertquery = "Update Vorstand set  ZR_Id = :zeit, K_Id = :klasse, U_Id = :lehrer,  where V_Id = :ident";
      
      if(!($stm = $con->prepare($insertquery)))
	  {
	      return MyError::raiseError('prepare_error', SQL_ERROR, $con->getErrorMsg());
	  }
      $stm->bindValue(':zeit', $this->zeitraumnummer);
      $stm->bindValue(':klasse', $this->klassennummer);
      $stm->bindValue(':lehrer', $this->lehrernummer);

      $stm->bindValue(':ident', $this->identNumber);
      if(!($stm->execute()))
	  {
	      return MyError::raiseError('execute_error', SQL_ERROR, $stm->getErrorMsg());
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
      $updatequery = "update Vorstand set deleteTime = :time, deleteUser = :user, valid = 0 where V_Id = :ident";
      
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
      $insertquery = "insert into Vorstand (ZR_Id, K_Id, U_Id, createUser, 
			createTime, valid) values (:zeitraum, :klasse, :lehrer, :user, :time, 1)";
      
      if(!($stm = $con->prepare($insertquery)))
	  {
	      return MyError::raiseError('prepare_error', SQL_ERROR, $con->getErrorMsg());
	  }
      $stm->bindValue(':zeitraum', $this->zeitraumnummer);
      $stm->bindValue(':klasse', $this->klassennummer);
      $stm->bindValue(':lehrer', $this->lehrernummer);

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
    if($this->zeitraumnummer != 0 && intval($this->zeitraumnummer) != $this->zeitraumnummer || $this->zeitraumnummer < 0)
      {
	return MyError::raiseError(gettext('set_valid_zeitraumnummer'), SYS_ERROR);
      }
    if($this->klassennummer != 0 && intval($this->klassennummer) != $this->klassennummer || $this->klassennummer < 0)
      {
	return MyError::raiseError(gettext('set_valid_klassennummer'), SYS_ERROR);
      }
    if($this->lehrernummer != 0 && intval($this->lehrernummer) != $this->lehrernummer || $this->lehrernummer < 0)
      {
	return MyError::raiseError(gettext('set_valid_lehrernummer'), SYS_ERROR);
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
    if($this->zeitraumnummer != 0 && intval($this->zeitraumnummer) != $this->zeitraumnummer || $this->zeitraumnummer < 0)
      {
	$error['zeitraumnummer'] = "G&uuml;ltigen Zeitraum angeben";
      }
    if($this->klassennummer != 0 && intval($this->klassennummer) != $this->klassennummer || $this->klassennummer < 0)
      {
	$error['klassennummer'] = "G&uuml;ltige Klasse angeben";
      }
    if($this->lehrernummer != 0 && intval($this->lehrernummer) != $this->lehrernummer || $this->lehrernummer < 0)
      {
	$error['lehrernummer'] = "G&uuml;ltigen Lehrer angeben";
      }
    if (count($error))
      {
	return $error;
      }
    return true;
  }
}

?>