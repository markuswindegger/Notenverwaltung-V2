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


class Zeitraum extends DBObject
{
  
  
  
  private $semester = 0;
  
  private $schuljahr = null;
  
  private $freidatum = null;
  
  private $sperrdatum = null;
  
  
  public function __construct()
  {
    
  }
  
  
  public function getSemester()
  {
    return $this->semester;
  }

  public function getSchuljahr()
  {
    return $this->schuljahr;
  }

  public function getFreidatum()
  {
    return $this->freidatum;
  }

  public function getSperrdatum()
  {
    return $this->sperrdatum;
  }


  
  public function setSemester($semester)
  {
    $this->semester = $semester;
  }

  public function setSchuljahr($schuljahr)
  {
    $this->schuljahr = $schuljahr;
  }

  public function setFreidatum(DateTime $freidatum)
  {
    $this->freidatum = $freidatum;
  }

  public function setSperrdatum(DateTime $sperrdatum)
  {
    $this->sperrdatum = $sperrdatum;
  }
  
  
  
  
  /**
   * This method syncronizes the current object with the database
   * @return a MyError if something goes wrong
   */
  public function update()
  {

      $con = AppDBO::getInstance();

      $insertquery = "Update Zeitraum set semester = :semester, schuljahr = :schuljahr, freigabedatum = :frei, sperrdatum = :sperr where ZR_Id = :ident";
      
      if(!($stm = $con->prepare($insertquery)))
	  {
	      return MyError::raiseError('prepare_error', SQL_ERROR, $con->getErrorMsg());
	  }
      $stm->bindValue(':semester', $this->semester);
      $stm->bindValue(':schuljahr', $this->schuljahr);
      $stm->bindValue(':frei', $this->freidatum->format('Y-m-d H:i:s'));
      $stm->bindValue(':sperr', $this->sperrdatum->format('Y-m-d H:i:s'));
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
      $updatequery = "update Zeitraum set deleteTime = :time, deleteUser = :user, valid = 0 where ZR_Id = :ident";
      
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
      $insertquery = "insert into Zeitraum (semester, schuljahr, freigabedatum, sperrdatum, createUser, 
			createTime, valid) values (:semester, :schuljahr, :frei, :sperr, :user, :time, 1)";
      
      if(!($stm = $con->prepare($insertquery)))
	  {
	      return MyError::raiseError('prepare_error', SQL_ERROR, $con->getErrorMsg());
	  }
      $stm->bindValue(':semester', $this->semester);
      $stm->bindValue(':schuljahr', $this->schuljahr);
      $stm->bindValue(':frei', $this->freidatum->format('Y-m-d H:i:s'));
      $stm->bindValue(':sperr', $this->sperrdatum->format('Y-m-d H:i:s'));
      $this->createUser = $_SESSION['benutzer']->getIdentNumber();
      $stm->bindValue(':user', $this->createUser);
      $this->createTime = new Datetime();
      $stm->bindValue(':time',($this->createTime->format('Y-m-d H:i:s'))); 
      if(!($stm->execute()))
	  {
	    return MyError::raiseError('prepare_error', SQL_ERROR, $stm->getErrorMsg());
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
    if($this->schuljahr == NULL || trim($this->schuljahr) === "")
      {
	return MyError::raiseError(gettext('set_name'), SYS_ERROR);
      }
    if($this->semester != 0 && intval($this->semester) != $this->semester || $this->semester < 0)
      {
	return MyError::raiseError(gettext('set_valid_semester'), SYS_ERROR);
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
    if($this->schuljahr == NULL || trim($this->schuljahr) === "")
      {
	$error['schuljahr'] = "G&uuml;ltiges Schuljahr angeben";
      }
    if($this->semester != 0 && intval($this->semester) != $this->semester || $this->semester < 0)
      {
	$error['semester'] = "G&uuml;ltigen Semster angeben";
      }
    if (count($error))
      {
	return $error;
      }
    return true;
  }
}

?>