<?php

/**
 * @author Markus Windegger <mwindegger@sad.it>
 *
 */


/**
 *
 * class Foto
 *
 * @package: classes
 *
 *
 */

class Foto extends DBObject
{
  

   /**
    * @var int filetype is the filetype of the file
    */
   protected $filetype = NULL;

   /**
    * @var string filepath is the path of the file
    */
   protected $filepath = null;

   /**
    * @var string filename is the ame of the file
    */
   protected $filename = null;

   /**
    * @var irgngeppes content
    */
   protected $content = null;

   /**
    * The defaultconstructor of the AgencyDetail class
    */
   public function __construct()
   {
      //do nothing
   }


   /***********************************************
    * Begin of the getter methods
    ***********************************************/

   public function getFiletype()
   {
      return $this->filetype;
   }

   public function getFilepath()
   {
      return $this->filepath;
   }

   public function getFilename()
   {
      return $this->filename;
   }

   public function getContent()
   {
      return $this->content;
   }

   /************************************************
    * End of the getter methods
    ************************************************/


   /************************************************
    * Begin of the setter methods
    ************************************************/

   public function setFiletype($filetype)
   {
      $this->filetype = $filetype;
   }

   public function setFilename($filename)
   {
      $this->filename = $filename;
   }

   public function setFilepath($filepath)
   {
      $this->filepath = $filepath;
   }

   public function setContent($content)
   {
      $this->content = $content;
      $sha = sha1($content);
      $path[0] = substr($sha, 0, 1);
      $path[1] = substr($sha, 1, 1);
      $path[2] = substr($sha, 2, 1);
      $path[3] =  $sha;
      $this->filepath = $path;
   }

   /************************************************
    * End of the setter methods
    ************************************************/
  
   /************************************************
    * Begin of the implementing of the abstract methods/functions from
    * the abstract DBObject class
    ************************************************/



   /**
    * This method syncronizes the current object with the database
    * @return a MyError if something goes wrong
    */
   public function update()
   {
      return MyError::raiseError(gettext('update_not_allowed'), SYS_ERROR);
   }


   /**
    * This method deletes the current object from the database
    * @return a MyError if something goes wrong
    */
   public function delete()
   {
      return MyError::raiseError(gettext('update_not_allowed'), SYS_ERROR);
   }

   /**
    * This method inserts the current object into the database
    * @return a MyError if something goes wrong
    */
   public function insert()
   {
      $datadir = Conf::get('datadir');

      $con = AppDBO::getInstance();
      if(!($con->beginTransaction()))
      {
         return MyError::raiseError(gettext('transaction_begin_error'), 
                                    SQL_ERROR);
      }

      $path = $datadir.DIRECTORY_SEPARATOR.'images'.
         DIRECTORY_SEPARATOR.$this->filepath[0].
         DIRECTORY_SEPARATOR.$this->filepath[1].
         DIRECTORY_SEPARATOR.$this->filepath[2];
      $filename = $this->filepath[3];
      $path_name = $path.DIRECTORY_SEPARATOR.$filename;

      $select = "select F_Id from Foto where dateipfad = :path";

      if(!($stm = $con->prepare($select)))
      {
         $con->rollback();
         return MyError::raiseError(gettext('prepare_error foto filepath'), SQL_ERROR, 
                                    $con->getErrorMsg());
      }
      $stm->bindValue(':path', $path_name);

      if(!($stm->execute()))
      {
         $con->rollback();
         return MyError::raiseError(gettext('execute_error'), SQL_ERROR, 
                                    $stm->getErrorMsg());
      }

      if($erg = $stm->fetch())
      {
         $stm->closeCursor();
         $this->identNumber = $erg['F_Id'];
	 if(!$con->commit())
	     {
		 return MyError::raiseError(gettext('execute_error'), SQL_ERROR,
					    $stm->getErrorMsg());
	     }
	 return;
      }
      $stm->closeCursor();


      $insertquery="insert into Foto
		       (datatype, dateipfad, dateiname, createUser, createTime, valid)
                    VALUES
			(:type, :path, :name, :username, :time, 1)";


      if(!($stm = $con->prepare($insertquery)))
      {
         $con->rollback();
         return MyError::raiseError(gettext('prepare_error, foto'), SQL_ERROR, 
                                    $con->getErrorMsg());
      }

      $stm->bindValue(':type', $this->filetype);
      $stm->bindValue(':path', $path_name);
      $stm->bindValue(':name', $this->filename);

      $this->createUser = $_SESSION['benutzer']->getIdentNumber();
      $stm->bindParam(':username', $this->createUser);
      $this->createTime = new Datetime();
      $stm->bindParam(':time',($this->createTime->format('Y-m-d H:i:s'))); 

      if(!$stm->execute())
      {
         $con->rollback();
         return MyError::raiseError(gettext('execute_error'), SQL_ERROR, 
                                    $stm->getErrorMsg());
      }

      $this->identNumber = $con->lastInsertID();

      $stm->closeCursor();


      /****************************************
       * Writing the file to the harddisk, if directories not exist, create them
       ****************************************/
      if(!file_exists($path))
      {
         if(!is_writable($datadir.DIRECTORY_SEPARATOR.'images'))
         {
	    $con->rollback();
	    return MyError::raiseError(gettext('permission_denied'), SYS_ERROR,
                                       $datadir);
         }
         else
         {
            $old_umask = umask();
            umask(intval(Conf::get('document_dir_umask')));
	    if(!mkdir($path, intval(Conf::get('document_dir_permissions'), 8), 
                      true))
            {
               $con->rollback();
               return MyError::raiseError(gettext('mkdir_failed'), SYS_ERROR, 
                                          $path);
            }
            umask($old_umask);
         }
      }
      
      if(!file_put_contents($path_name, $this->content))
      {
         $con->rollback();
         return MyError::raiseError(gettext('cannot_create_file'), SYS_ERROR, 
                                    $path_name);
      }
      
      if(!$con->commit())
      {
         return MyError::raiseError(gettext('execute_error'), SQL_ERROR,
                                    $stm->getErrorMsg());
      }
      
      
   }
   
   
   /**
    * This method validates the current object, is useful for validating the 
    * object before inserting the object in the database.
    * @return The method returns true if everithing is going right, but 
    *		returns a MyError with the detailed description of the error.
    */
   public function validate()
   {
      if($this->identNumber != 0 && intval($this->identNumber) != $this->identNumber || $this->identNumber < 0)
      {
         return MyError::raiseError(gettext('set_valid_id'), SYS_ERROR);
      }
      if($this->filetype == null || trim($this->filetype) === "")
      {
         return MyError::raiseError(gettext('set_filetype'), SYS_ERROR);
      }
      if($this->filepath == null || !count($this->filepath))
      {
         return MyError::raiseError(gettext('set_filepath'), SYS_ERROR);
      }
      if($this->filename == null || trim($this->filename) === "")
      {
         return MyError::raiseError(gettext('set_filename'), SYS_ERROR);
      }
      if($this->content == null || trim($this->content) === "")
      {
         return MyError::raiseError(gettext('set_content'), SYS_ERROR);
      }
      return true;
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
      if($this->identNumber != 0 && 
         intval($this->identNumber) != $this->identNumber || 
         $this->identNumber < 0)
      {
         $error['identNumber'] = 
            gettext('Il numero identificativo non &egrave; valido');
      }
      if($this->filetype == null || trim($this->filetype) === "")
      {
         $error['filetype'] = gettext('Inserisci un nome valido');
      }
      if($this->filepath == null || !count($this->filepath))
      {
         $error['filepath'] = gettext('Inserisci un percorso valido');
      }
      if($this->filename == null || trim($this->filename) === "")
      {
         $error['filename'] = gettext('Inserisci un nome valido');
      }
      if($this->content == null || trim($this->content) === "")
      {
         $error['content'] = gettext('Inserisci un contenuto');
      }
      if (count($error))
      {
         return $error;
      }
      return true;
   }


   /************************************************
    * End of the implementing of the abstract methods/functions from
    * the abstract DBObject class
    ************************************************/
   
   public function loadClass($identNumber, $loadContent = false)
   {
      $this->identNumber = $identNumber;
      $con = AppDBO::getInstance();
    
      $selectquery = "Select * from Foto where F_Id = :ident";
    
      if(!($stm = $con->prepare($selectquery)))
      {
         return MyError::raiseError(gettext('prepare_error'), SYS_ERROR, 
                                    $con->getErrorMsg());
      }
    
      $stm->bindValue(':ident', $this->identNumber);
    
      if(!($stm->execute()))
      {
         return MyError::raiseError(gettext('execute_error'), SYS_ERROR, 
                                    $stm->getErrorMsg());
      }
    
      if(!($erg = $stm->fetch()))
      {
         return MyError::raiseError("Document not found", SYS_ERROR);
      }
    
      $this->filename = $erg['dateiname'];
      $this->filepath = $erg['dateipfad'];
      $this->filetype = $erg['datatype'];
      $datetime = new DateTime($erg['createTime']);
      $this->createTime = $datetime;
      $this->createUser = $erg['createUser'];
      $stm->closeCursor();

      if (!file_exists($this->filepath)) {
         return MyError::raiseError(gettext('Das Foto existiert nicht'),
                                    SYS_ERROR, $this->filepath);
      }

      if(!is_readable($this->filepath))
      {
         return MyError::raiseError(gettext('permission denied'), SYS_ERROR,
                                    $this->filepath);
      }
      
      if($loadContent)
      {
         
         if(!($this->content = file_get_contents($this->filepath)))
         {
	    return MyError::raiseError(gettext('open file failed'), SYS_ERROR,
                                       $this->filepath);
         }
      }
      else
      {
         $this->content = null;
      }
   }
   
   /**
    * Schreibt das Foto direkt in den Ausgabestrom des Skripts. 
    * Die Methode setzt ebenfalls den HTTP-Header, das bedeutet, dass in PHP-Skripts
    * welche diese Methode aufrufen vor dem Aufruf der Methode keine Ausgaben
    * erfolgen dürfen. Diese Methode erhöht auch die Anzahl der Zugriffe auf das
    * Foto um 1, denn nur wenn das Foto in seiner vollen Größe ausgegeben wird,
    * dann wird die Anzahl der Zugriffe erhöht
    */
   public function ausgabeFoto() {
       if ($this->content != null)
	   {
	       header("Content-type: " . $this->filetype);
	       echo $this->content;
	       return true;
	   }
       else
	   return false;
   }


}

?>