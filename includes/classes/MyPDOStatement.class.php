<?php

/**
 * Contiene la classe {@link MyPDOStatement}
 *
 * @package classes
 */

/** 
 * Estende la classe {@link PDOStatement}
 *
 * Estende la classe {@link PDOStatement} per permettere un metodo
 * personalizato per ottenere i messaggi d'errore
 *
 * @package classes
 */
class MyPDOStatement extends PDOStatement {


   /**
    *
    */
   public function getErrorMsg () {
      

      $err = $this->errorInfo();
      
      return @$err[0].": ".@$err[2];
   }
}



?>