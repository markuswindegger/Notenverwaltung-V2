<?php

/**
 * Contiene la classe {@link AppDBO}
 *
 * Questo file contiene la classe {@link AppDBO}
 *
 * @package classes
 */

/**
 * Classe che gestisce la communicazione con il database dei treni
 *
 * Questa classe viene utilizzata per communicare con il database 
 * dei treni.
 *
 * @package classes
 */
class AppDBO extends PDOWrapper{


   /**
    * Methodo singleton
    *
    * @access public
    * @return AppDBO
    */
   public static function getInstance() {
      
      $dsn='';
         
      if (Conf::get('dbPort')) {
         $dsn = Conf::get('dbType').":host=".Conf::get('dbHost').
            ";port=".Conf::get('dbPort').";dbname=".Conf::get('dbName');
      } else {
         $dsn = Conf::get('dbType').":host=".Conf::get('dbHost').
            ";dbname=".Conf::get('dbName');
      }
      
         
      if (self::$instance == NULL) {
         
         try {
            $pdo = new PDO($dsn, Conf::get('dbUser'), Conf::get('dbPassword'),
                           array(PDO::MYSQL_ATTR_INIT_COMMAND =>
                                 'SET NAMES utf8'));
            
            self::$instance = new AppDBO($pdo);

         } catch (PDOException $e) {
            $err = MyError::raiseError('Database non disponibile',
                                       SYS_FATAL_ERROR, $e->getMessage(),
                                       __FILE__, 'AppDBO', $e->getLine());
            $err->displayMessage();
         }
         
      }

      if (!$sth = self::$instance->query('SELECT 1')) {
         $err_info = self::$instance->errorInfo();
         if ($err_info[1] == "2006" || $err_info[1] == "2013") {
            try {
               $pdo = new PDO($dsn, Conf::get('dbUser'), 
                              Conf::get('dbPassword'),
                              array(PDO::MYSQL_ATTR_INIT_COMMAND =>
                                    'SET NAMES utf8'));

               self::$instance = new AppDBO($pdo);

            } catch (PDOException $e) {
               $err = MyError::raiseError('Database non disponibile',
                                          SYS_FATAL_ERROR, $e->getMessage(),
                                          __FILE__, 'AppDBO', $e->getLine());
               $err->displayMessage();
            }
         } else {
            $err = MyError::raiseError('Database non disponibile',
                                       SYS_FATAL_ERROR, $err_info[2],
                                       __FILE__, 'AppDBO', __LINE__);
            $err->displayMessage();
         }
      } else {
         $sth->closeCursor();
      }

      return self::$instance;
   }

   
}
?>
