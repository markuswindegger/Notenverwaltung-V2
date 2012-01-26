<?php

/**
 * Contains Class PDOWrapper
 *
 * @package classes
 */
require_once(Conf::get('classdir').'/MyPDOStatement.class.php');

/**
 * Abstract Class PDOWrapper
 *
 * Questa classe deve essere ereditata da tutte le classi che 
 * stabiliscono una connessione con un server Database
 *
 * @package classes
 */
abstract class PDOWrapper {

   /**
    * Istanza della classe PDO
    * 
    * @static
    * @access protected
    */
   protected static $pdo;

   /**
    * Puntatore alla istanza disponibile
    *
    * @static
    * @access protected
    */
   protected static $instance = NULL;

   /**
    * Transaction level
    * 
    * @static
    * @access protected
    */
   protected static $transactionLevel=0;
	
   /**
    * Force rollback
    * 
    * @static
    * @access protected
    */
   protected static $forceRollBack=false;

   

   /**
    * Costruttore della classe AppDBO
    * 
    * @access private
    */
   protected function __construct(PDO $pdo){
      
      self::$pdo = $pdo;
   }


   
   final public function __call($methodName, $arrArguments) {
      
      //also check if the method exists
      return call_user_func_array(array(self::$pdo , $methodName), 
                                  $arrArguments);
   }


   
   /**
    *
    */
   public function getErrorMsg () {
      
      $err = self::$pdo->errorInfo();
      
      return @$err[2];
   }


   /**
    * Sovrascrive il metodo prepare di pdo
    *
    */
   public function prepare ($statement, $driver_options=array()) {

      $driver_options[PDO::ATTR_STATEMENT_CLASS] = array('MyPDOStatement');

      return self::$pdo->prepare($statement, $driver_options);
   }



   /**
    * Overwrite the PDO beginTransaction method
    *
    * Nested transaction aren't supported. If a PDO::beginTransaction()
    * is called when a transaction is currently open this causes a premature
    * commit of the first transaction. To emulate a nesting transaction
    * system this method increment a counter for each time it is called.
    * Only if the counter $transactionLevel is =0 PDO::beginTransaction()
    * is effective called.
    *
    * @access public
    */
   public function beginTransaction() {
      
      // Create a new effective transaction 
      if (self::$transactionLevel == 0) {
         // Error in create a transaction
         if (!self::$pdo->beginTransaction()) {
            return FALSE;
         }
         
         self::$transactionLevel++;
         self::$forceRollBack = false;
      }
      // New nested transaction
      elseif (self::$transactionLevel > 0) {
         
         self::$transactionLevel++;
         
      }
      // FATAL ERROR! $transactionLevel cannot be negative!!!!!!!!
      else {
         return FALSE;
      }
      
      return TRUE;
   }
   
   
   /**
    * Overwrite the PDO rollBack method
    *
    * Nested transaction aren't supported.
    * To emulate a nesting transaction system this method decrement
    * the $transactionLevel counter for each time it is called.
    * Only if the counter $transactionLevel is =1 PDO::rollBack()
    * is effective called. If a rollBack is called into a nested
    * transaction $forceRollBack is set to true, to avoid to committing
    * the transaction at the end. If commit is invoked, a rollback
    * is called instead.
    *
    * @access public
    */
   public function rollBack() {
      
      // Perform an effective rollback
      if (self::$transactionLevel == 1) {
         
         // Error in rollback a transaction
         if (!self::$pdo->rollBack()) {
            return FALSE;
         }
         
         self::$transactionLevel--;
         self::$forceRollBack = false;
         
      }
      // Rollback in nested transaction
      // Force to execute rollback at end of main transaction
      elseif (self::$transactionLevel > 1) {
         self::$transactionLevel--;
         self::$forceRollBack = true;
      }
      // FATAL ERROR! $transactionLevel cannot <1 if a rollback is called!!!!
      else {
         return FALSE;
      }

      return TRUE;
   }
   
   
   /**
    * Overwrite the PDO commit method
    *
    * Nested transaction aren't supported.
    * To emulate a nesting transaction system this method decrement
    * the $transactionLevel counter for each time it is called.
    * Only if the counter $transactionLevel is =1 PDO::commit()
    * is effective called. If a rollBack was called into a nested
    * transaction $forceRollBack is also set to true, if commit is
    * invoked, a rollback with $forceRollBack=true rollBack is called instead.
    *
    * @access public
    */
   
   public function commit() {
      // Perform an effective commit or rollback
      if (self::$transactionLevel == 1) {
         
         // FORCE ROLLBACK
         if (self::$forceRollBack == true) {
            
            // Error in rollback a transaction
            if (!self::$pdo->rollBack()) {
               return FALSE;
            }
         }
         // Real COMMIT
         else {
            
            // Error in commit a transaction
            if (!self::$pdo->commit()) {
               return FALSE;
            }
            
         }
         
         self::$transactionLevel--;
         self::$forceRollBack = false;
         
      }
      // Commit in nested transaction
      elseif (self::$transactionLevel > 1) {
         
         self::$transactionLevel--;
         
      }
      // FATAL ERROR! $transactionLevel cannot <1 if a commit is called!!!!
      else {
         return FALSE;
      }

      return TRUE;
   }
   

   /**
    * Restituisce l'istanza di questa classe
    *
    * @access public
    * @static
    * @return DBConn
    */
   static public function getInstance() {

   }

   
   /**
    * Distrugge l'oggetto PDO
    *
    * Distruggendo l'oggetto PDO verra' chiusa la connessione con il 
    * server
    *
    */
   final public function destroy() {
      
      $this->pdo = NULL;
      
      return TRUE;
   }

}

?>