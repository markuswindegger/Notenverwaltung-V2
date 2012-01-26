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


class Benutzer extends DBObject
{


    private $rolle = 0;

    private $name = null;

    private $nachname = null;

    private $user = null;

    private $password = null;

    private $login = false;

    private $auth = false;


    public function __construct()
    {

    }

    public function getRolle()
    {
	return $this->rolle;
    }

    public function getName()
    {
	return $this->name;
    }

    public function getNachname()
    {
	return $this->nachname;
    }

    public function getUser()
    {
	return $this->user;
    }

    public function getPassword()
    {
	return $this->password;
    }

    public function getLogin()
    {
	return $this->login;
    }

    public function getAuth()
    {
	return $this->auth;
    }




    public function setRolle($rolle)
    {
	$this->rolle = $rolle;
    }
    
    public function setName($name)
    {
	$this->name = $name;
    }
    
    public function setNachname($nachname)
    {
	$this->nachname = $nachname;
    }
    
    public function setUser($user)
    {
	$this->user = $user;
    }

    public function setPassword($password)
    {
	$this->password = $password;
    }

    public function setLogin($login)
    {
	$this->login = $login;
    }




    public function logout()
    {
	$this->login = false;
    }


    public function auth($user, $password)
    {
	$con = AppDBO::getInstance();
	$this->password = hash('sha256', $password);
	$this->user = $user;

	$selectquery = "Select * from Benutzer where password = :pwd AND benutzername = :user AND valid = 1 limit 1";
	if(!($stm = $con->prepare($selectquery)))
	    {
		return MyError::raiseError('prepare_error', SQL_ERROR, $con->getErrorMsg());
	    }
	$stm->bindValue(':pwd', $this->password);
	$stm->bindValue(':user', $this->user);
	if(!($stm->execute()))
	    {
		return MyError::raiseError('prepare_error', SQL_ERROR, $stm->getErrorMsg());
	    }
	if(!($erg = $stm->fetch()))
	    {
		return MyError::raiseError('authentification failed', SYS_ERROR);
	    }
	$stm->closeCursor();
	$this->login = true;
	$this->auth = true;
	$this->name = $erg['name'];
	$this->nachname = $erg['nachname'];
	$this->rolle = $erg['R_Id'];
	$this->createUser = $erg['createUser'];
	$this->createTime = $erg['createTime'];
	$this->valid = $erg['valid'];
	$this->identNumber = $erg['U_Id'];
	return true;
    }
    

    public function changePassword($oldpassword, $newpassword1, $newpassword2)
    {
	if(!$this->login || !$this->auth)
	    {
		return MyError::raiseError('authentication failed', SYS_ERROR);
	    }
	if(hash('sha256', $oldpassword) != $this->password)
	    {
		return MyError::raiseError('Das alte Passwort stimmt nicht &uuml;berein!', SYS_ERROR);
	    }
	if($newpassword1 != $newpassword2)
	    {
		return MyError::raiseError('Bitte das neue Passwort korrekt wiederholen!!', SYS_ERROR);
	    }
	$this->password = hash('sha256', $newpassword1);
	if(MyError::isError($error = $this->update()))
	    {
		return $error;
	    }
	return TRUE;
    }

  /**
   * This method syncronizes the current object with the database
   * @return a MyError if something goes wrong
   */
  public function update()
  {

      $con = AppDBO::getInstance();
      $insertquery = "Update Benutzer set name= :name, nachname= :nachname, benutzername=:benutzername, password=:password, R_Id=:rolle where U_Id = :user";
      
      if(!($stm = $con->prepare($insertquery)))
	  {
	      return MyError::raiseError('prepare_error', SQL_ERROR, $con->getErrorMsg());
	  }
      $stm->bindValue(':name', $this->name);
      $stm->bindValue(':nachname', $this->nachname);
      $stm->bindValue(':benutzername', $this->user);
      $stm->bindValue(':password', $this->password);
      $stm->bindValue(':rolle', $this->rolle);
      $stm->bindValue(':user', $this->identNumber);
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
      $updatequery = "update Benutzer set deleteTime = :time, deleteUser = :user, valid = 0 where U_Id = :ident";
      
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
      $insertquery = "insert into Benutzer (name, nachname, benutzername, password, R_Id, createUser, 
			createTime, valid) values (:name, :nachname, :benutzername, :password, :rolle, :user, :time, 1)";
      
      if(!($stm = $con->prepare($insertquery)))
	  {
	      return MyError::raiseError('prepare_error', SQL_ERROR, $con->getErrorMsg());
	  }
      $stm->bindValue(':name', $this->name);
      $stm->bindValue(':nachname', $this->nachname);
      $stm->bindValue(':benutzername', $this->user);
      $stm->bindValue(':password', $this->password);
      $stm->bindValue(':rolle', $this->rolle);
      $this->createUser = 1;
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
      if($this->name == NULL || trim($this->name) === "")
	  {
	      return MyError::raiseError(gettext('set_name'), SYS_ERROR);
	  }
      if($this->nachname == NULL || trim($this->nachname) === "")
	  {
	      return MyError::raiseError(gettext('set_nachname'), SYS_ERROR);
	  }
      if($this->user == NULL || trim($this->user) === "")
	  {
	      return MyError::raiseError(gettext('set_user'), SYS_ERROR);
	  }
      if($this->password == NULL || trim($this->password) === "")
	  {
	      return MyError::raiseError(gettext('set_password'), SYS_ERROR);
	  }
      if($this->rolle != 0 && intval($this->rolle) != $this->rolle || $this->rolle < 0)
	  {
	      return MyError::raiseError(gettext('set_valid_rolle'), SYS_ERROR, var_dump($this->identNumber));
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
    if($this->user == NULL || trim($this->user) === "")
      {
	  $error['user'] = "G&uuml;ltigen User angeben";
      }
    if($this->password == NULL || trim($this->password) === "")
      {
	  $error['password'] = "G&uuml;ltiges Passwort angeben";
      }
    if($this->rolle != 0 && intval($this->rolle) != $this->rolle || $this->rolle < 0)
	{
	    $error['rolle'] = "Rolle nicht g&uuml;ltig";
	}
    if (count($error))
	{
	    return $error;
	}
    return true;
  }
}

?>