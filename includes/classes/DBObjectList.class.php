<?php

  /**
   * @author Markus Windegger <mwindegger@sad.it>
   * @version $Revision: 1.6 $
   * $Id: DBObjectList.class.php,v 1.6 2010/08/06 07:27:29 cwieser Exp $
   *
   */


  /**
   *
   * Abstract class DBObjectList
   *
   * @package: classes
   *
   *
   */


class DBObjectList
{

  /**
   * @var array This is the list which stores the agencies from the database for a better working with all of them, or to search something partikular
   */
  protected static $list = NULL;



  /**
   * This function adds an object to the agencylist and the database
   *
   * @param DBObject $object, the object wich is to add
   *
   * @return the new objectlist if all goes right, a MyError if something goes wrong
   */
  public static function add(DBObject $object)
  {
    if(!static::isInstanceOf($object))
      {
	return MyError::raiseError(gettext("not_valid_object"), SYS_ERROR, get_class($object));
      }
    if(MyError::isError($res = $object->validate()))
      {
	return $res;
      }
    if(MyError::isError($res = $object->insert()))
      {
	return $res;
      }
    if(MyError::isError($res = static::getList()))
      {
	return $res;
      }
    static::$list[$object->getIdentNumber()]=$object;

    return static::$list;
  }





  /**
   * This function removes an object from the objectlist and the database
   *
   * @param int $id, which is the id from the object which is to delete
   *
   * @return the new objectlist if all goes right, a MyError if something goes wrong
   */
  public static function remove($id)
  {
    if(intval($id) != $id)
      {
	return MyError::raiseError(gettext('is_not_a_valid_ID'), SYS_ERROR);
      }
    if(MyError::isError($res = static::getList()))
      {
	return $res;
      }
    if(!isset(static::$list[$id]))
      {
	return MyError::raiseError(gettext('is_not_a_valid_ID'), SYS_ERROR);
      }
    if(MyError::isError($res = static::$list[$id]->delete()))
      {
	return $res;
      }
    unset(static::$list[$id]);
    return static::$list;
  }




  /**
   * This function updates an object from the objectlist and the database
   *
   * @param DBObject $object, the object wich is to update
   *
   * @return the new objectlist if all goes right, a MyError if something goes wrong
   */
  public static function update($id)
  {
    if(intval($id) != $id)
      {
	return MyError::raiseError(gettext('is_not_a_valid_ID'), SYS_ERROR);
      }
    if(MyError::isError($res = static::getList()))
      {
	return $res;
      }
     if(!isset(static::$list[$id]))
      {
	return MyError::raiseError(gettext('is_not_a_valid_ID'), SYS_ERROR);
      }
    if(MyError::isError($res = static::$list[$id]->update()))
      {
	return $res;
      }
    static::$list[static::$list[$id]->getIdentNumber()] = static::$list[$id];
    unset(static::$list[$id]);
    return static::$list;
  }


  /**
   * This function returns the object with the given ID, and if the instance is given returns the object with the given instance if exist
   *
   * @param the id from the object
   *
   * @return the object with the given id if all goes right, a MyError if something goes wrong
   *
   */
  public static function getById($id)
  {
    if(intval($id) != $id)
      {
	return MyError::raiseError(gettext('is_not_a_valid_ID'), SYS_ERROR,  intval($id));
      }
    if(MyError::isError($res = static::getList()))
      {
	return $res;
      }
    if(!isset(static::$list[$id]))
      {
	return MyError::raiseError(gettext('is_not_a_valid_ID'), SYS_ERROR);
      }
    return static::$list[$id];
  }



  /**
   * This function returns an array of all the objects momentanly avaiable in the database
   * @return a list of objects if all goes right, alternativ it returns a MyError
   */
  public static function getList()
  {
    throw new Exception('The manually abstract method getList is not been hardcoded in the child class');
  }



  /**
   * This function is to control an object, wheter it's a instance of the implementing class of this abstract class
   * @return the result of the control
   */
   public static function isInstanceOf($object)
   {
     throw new Exception('The manually abstract method isInstanceOf is not been hardcoded in the child class');
   }

}

?>