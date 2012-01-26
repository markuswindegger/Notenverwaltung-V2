<?php

  /**
   * @author Markus Windegger <mwindegger@sad.it>
   * @version $Revision: 1.2 $
   * $Id: DBObject.class.php,v 1.2 2010/08/03 14:18:07 mwindegger Exp $
   *
   */


  /**
   *
   * Abstract class DBObject
   *
   * @package: classes
   *
   *
   */

abstract class DBObject
{

  /**
   * @var String createUser is the user which creates the dataset in the database
   */
  protected $createUser = NULL;

  /**
   * @var Datetime createTime is the timestamp of the creatingtime of the object
   */
  protected $createTime = NULL;
  
  /**
   * @var bool valid describes if the current object is valid or not
   */
  protected $valid = false;
  
  /**
   * @var String deleteUser is the user which deletes the dataset in the database
   */
  protected $deleteUser = NULL;

  /**
   * @var Datetime deleteTime is the timestamp of the deletetime of the object
   */
  protected $deleteTime = NULL;

  /**
   * @var int identNumber is the identificationNumber of the object in the database
   */
  protected $identNumber = 0;



  /*****************************************************************************
   * Begin of the getter Methods
   ****************************************************************************/
  public function getCreateUser()
  {
    return $this->createUser;
  }

  public function getCreateTime()
  {
    return $this->createTime; 
  }

  public function getValid()
  {
    return $this->valid;
  }

  public function getDeleteUser()
  {
    return $this->deleteUser;
  }

  public function getDeleteTime()
  {
    return $this->deleteTime;
  }

  public function getIdentNumber()
  {
    return $this->identNumber;
  }
  /*****************************************************************************
   * End of the getter Methods
   ****************************************************************************/



  /*****************************************************************************
   * Begin of the setter methods 
   *****************************************************************************/
  public function setCreateUser($createUser)
  {
    $this->createUser=$createUser;
  }

  public function setCreateTime(DateTime $createTime)
  {
    $this->createTime=$createTime; 
  }

  public function setValid($valid)
  {
    $this->valid=$valid;
  }

  public function setDeleteUser($deleteUser)
  {
    $this->deleteUser = $deleteUser;
  }

  public function setDeleteTime(DateTime $deleteTime)
  {
    $this->deleteTime = $deleteTime;
  }
  public function setIdentNumber($identNumber)
  {
    $this->identNumber = $identNumber;
  }
  /******************************************************************************
   * End of the setter methods 
   *****************************************************************************/



  /******************************************************************************
   * Begin of the abstract methods
   *****************************************************************************/
  /**
   * This method syncronizes the current object with the database
   * @return a MyError if something goes wrong
   */
  public abstract function update();

  /**
   * This method deletes the current object from the database
   * @return a MyError if something goes wrong
   */
  public abstract function delete();

  /**
   * This method inserts the current object into the database
   * @return a MyError if something goes wrong
   */
  public abstract function insert();


  /**
   * This method validates the current object, is useful for validating the 
   * object before inserting the object in the database.
   * @return The method returns NULL if everithing is going right, but 
   *		returns a MyError with the detailed description of the error.
   */
  public abstract function validate();


  /**
   * This method returns the errors from the validation in an associated
   * array.
   * @return an array if some errors exist, true if the validation ends without 
   *		errors
   */
  public abstract function getValidateErrors();

  /******************************************************************************
   * End of the abstract methods
   *****************************************************************************/


}



?>